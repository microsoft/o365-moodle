<?php

    /*******************************************************************************
    Copyright (C) 2009  Microsoft Corporation. All rights reserved.
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2 as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

    *******************************************************************************/
    require_once(dirname(__FILE__).'/../../config.php');
    require_once( $CFG->dirroot . '/auth/azuread/auth.php' );
    require_once( $CFG->dirroot . '/auth/azuread/graph.php' );
    require_once( $CFG->libdir . '/authlib.php' );
    require_once ($CFG->libdir . '/moodlelib.php');


    /* If SimpleSAML is officially installed use files from there. Otherwise use embedded files*/
    if (file_exists($CFG->dirroot.'/simplesamlphp'))
    {
        $simpdir = $CFG->dirroot.'/simplesamlphp';
        require_once ($simpdir.'/lib/xmlseclibs.php');


        require_once ( $simpdir.'/lib/SAML2/XML/saml/SubjectConfirmationData.php');
        require_once ( $simpdir.'/lib/SAML2/XML/saml/SubjectConfirmation.php');
        require_once ( $simpdir.'/lib/SAML2/Utils.php');
        require_once ( $simpdir.'/lib/SAML2/Const.php');
        require_once ( $simpdir.'/lib/SAML2/SignedElement.php');
        require_once ( $simpdir.'/lib/SAML2/Assertion.php');


        require_once ( $simpdir.'/lib/SimpleSAML/Utilities.php');

    }else{
        require_once (dirname(__FILE__) . '/simplesaml/xmlseclibs.php');


        require_once (dirname(__FILE__) . '/simplesaml/SubjectConfirmationData.php');
        require_once (dirname(__FILE__) . '/simplesaml/SubjectConfirmation.php');
        require_once (dirname(__FILE__) . '/simplesaml/Utils.php');
        require_once (dirname(__FILE__) . '/simplesaml/Const.php');
        require_once (dirname(__FILE__) . '/simplesaml/SignedElement.php');
        require_once (dirname(__FILE__) . '/simplesaml/Assertion.php');


        require_once (dirname(__FILE__) . '/simplesaml/Utilities.php');
    }
    //HTTPS is required in this page when $CFG->loginhttps enabled
    $PAGE->https_required();

    /**
    * This is called back by AzureAD for a login
    */
    class SAMLToken
    {
        const   CLAIM_EMAIL = 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name';
        const   CLAIM_FIRSTNAME = 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname';
        const   CLAIM_LASTNAME = 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname';
        const   CLAIM_PAIRWISEID = 'PairwiseID';
        const   CLAIM_OBJECTID = "http://schemas.microsoft.com/identity/claims/objectidentifier";
        const   NS_WSTRUST = 'http://schemas.xmlsoap.org/ws/2005/02/trust';
        const   NS_SAMLTOKEN = 'urn:oasis:names:tc:SAML:2.0:assertion';
        private $_tokenxml;
        private $_claims;
        private $_error;
        private $_simplesamltoken;



        public function __construct($tokenxml)
        {
            $this->_tokenxml = $tokenxml;
            unset($this->_error);
            $dom = new DOMDocument();
            $this->_tokenxml = str_replace('\r', '', $this->_tokenxml);//Windows/Linux compat
            $dom->loadXML($this->_tokenxml);
            $xpath = new DOMXpath($dom);
            $xpath->registerNamespace('wst', SAMLToken::NS_WSTRUST);
            $xpath->registerNamespace('saml',SAMLToken::NS_SAMLTOKEN);

            //Grab the assertions out of the token 
            $assertions = $xpath->query('/wst:RequestSecurityTokenResponse/wst:RequestedSecurityToken/saml:Assertion');
            if ($assertions->length == 0) {
                $_error = 'Received a response without an assertion on the WS-Fed PRP handler.';
            }
            if ($assertions->length > 1) {
                $_error = 'The WS-Fed PRP handler currently only supports a single assertion in a response.';
            }
            $assertion = $assertions->item(0);

            $attributes = $xpath->query('./saml:AttributeStatement/saml:Attribute', $assertion);

            $this->_claims = array ();
            foreach ($attributes as $attribute) {
                $this->_claims[$attribute->getAttribute('Name')] =$attribute->textContent;
            }
            $name = $xpath->query('./saml:Subject/saml:NameID',$assertion);      
            
            if (isset($name) && ($name->length == 1)){
                $this->_claims[SAMLToken::CLAIM_PAIRWISEID]=$name->item(0)->nodeValue;
            }
            if (!isset($this->_claims[SAMLToken::CLAIM_OBJECTID]))
                $this->_error = 'No object claim in token';
            try {
                $this->_simplesamltoken = new SAML2_Assertion($assertion);
            }catch (Exception $e){
                $this->_error = 'SAML token validation error:'.$e->__toString();
            }

        }

        public function isvalid()
        {
            /* Add checks to make sure that the token is valid */
            if (isset($this->_error))
                return false;
            /* Check the time validity*/
            $t = new DateTime('now');
            $tunix = $t->getTimestamp();
            if ($tunix < $this->_simplesamltoken->getNotBefore()-300)
                return false;
            if ($tunix > $this->_simplesamltoken->getNotOnOrAfter()+300) 
                return false;
            return true;   

        }
        private function validateone($target,$arr)
        {
            if(!isset($target))
                return true;
            foreach ($arr as $val)
            {
                if (strcasecmp($val,$target)==0)
                    return true;    
            }
            return false;
        }
        /* Validate token against these critera. If it does not meet the criteria then mark error in the token */
        public function validate($audience,$issuer,$certthumbprint)
        {
            if (!isset($this->_simplesamltoken))
                return;
                
            if (!$this->validateone($audience,$this->_simplesamltoken->getValidAudiences())){
                $this->_error = "Invalid audience";
                return;
            }
            $thumbs = array();
            foreach ($this->_simplesamltoken->getCertificates() as $cert)
            {
                $thumbs[] = sha1(base64_decode($cert));
            }
            ;
            if (!$this->validateone($certthumbprint,$thumbs)){
                $this->_error = "Invalid cert";
                return;
            }
            if (strcasecmp($issuer  ,$this->_simplesamltoken->getIssuer())!=0){
                $this->_error = "Invalid issuer";
                return;
            }

        }


        public function getClaim($claimname)
        {
            if (isset($this->_error))
                return NULL;
            if (!isset($this->_claims))    
                return NULL;
            return $this->_claims[$claimname];    

        }
        public function getDisplayNameClaim()
        {
            $name = "";
            $name .= $this->getClaim(SAMLToken::CLAIM_FIRSTNAME)." ".$this->getClaim(SAMLToken::CLAIM_LASTNAME);
            return $name;
        }
    }   

    function _ishttpinstalled() {
        if  (in_array  ('http', get_loaded_extensions())) {
            return true;
        }
        else{
            return false;
        }
    }
    if (!_ishttpinstalled())
    {
        echo ("PHP Extension Http is required for this plugin. Please install the php_http extension for PHP");
    }else{
    

        $tok = new SAMLToken($_POST['wresult']);
        if (isset($tok)){
            global $_TenantThumb;
            /* Validate the token against audience, issuer etc. If its not valid the isvalid function called below will return false*/

            /* Audience is just the app id*/
            $aud = "spn:".get_config('block_azuread','appid');

            /* Ussuer has to be ACS at the company\university id */
            $iss = STSJWTToken::URL_ISSUER."/".get_config('block_azuread','companyid')."/";

            if (!isset($_TenantThumb))
            {


                try{
                    $dom = get_config('block_azuread','companydomain');
                    $url = STSJWTToken::URL_STSMETADATA;
                    $url=str_ireplace("%1",$dom,$url);
                    $response = http_get($url);
                    if (isset($response)){
                        $dom = new DOMDocument();
                        $resparr = http_parse_message($response);
                        if (isset($resparr) && $resparr->responseCode == 200 && isset($resparr->body)){


                            $dom->loadXML($resparr->body);
                            $certs = $dom->getElementsByTagName('X509Certificate');
                            $_TenantThumb = sha1(base64_decode($certs->item(0)->textContent));
                        }
                    }
                }catch (Exception $ex)
                {
                    $_TenantThumb =null;
                }   
            }     


            $tok->validate($aud,$iss,$_TenantThumb);
        }
        /* We do some magic here. If the token is valid we make a call to the overall login function
        for Moodle. We do this by setting a username and a fake "password" which is the AzureADSecret setup at AzureAD initalization time. The AzureAD
        user_login user always checks for the password to be the AzurADSecret and logs a user in if it is. If the token is 
        invalid we just send userback to home page 
        */
        if ($tok->isvalid())
        {
            global $_AzureADSecret;

            $objid = $tok->getClaim(SAMLToken::CLAIM_OBJECTID);
            if (isset($objid))    
                $u = authenticate_user_login($objid,$_AzureADSecret);
            if ($u != false){
                //Complete the login and send user back to the page they stated from
                complete_user_login($u);
                $SESSION->aaduser = $_POST['wresult'];
                $SESSION->aadusername = $tok->getDisplayNameClaim();        

            }
        }
        /* In all cases success or failure send user back to page they came from */
        if (!empty($SESSION->wantsurl)) {
            $go = $SESSION->wantsurl;
            unset($SESSION->wantsurl);
        }
        if (!isset($go))
            $go = $CFG->wwwroot;

        redirect($go);
    }
?>
