<?php

namespace local_o365\tests;

trait apitesttrait {
	/**
     * Get a mock token object to use when constructing the API client.
     *
     * @return \local_o365\oauth2\token The mock token object.
     */
    protected function get_mock_clientdata() {
        $cfg = (object)[
            'clientid' => 'clientid',
            'clientsecret' => 'clientsecret',
            'authendpoint' => 'http://example.com/auth',
            'tokenendpoint' => 'http://example.com/token'
        ];

        return new \local_o365\oauth2\clientdata($cfg->clientid, $cfg->clientsecret, $cfg->authendpoint, $cfg->tokenendpoint);
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return \local_o365\oauth2\token The mock token object.
     */
    protected function get_mock_token() {
        $httpclient = new \local_o365\tests\mockhttpclient();

        $tokenrec = (object)[
            'token' => 'token',
            'expiry' => time() + 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'scope',
            'user_id' => '2',
            'resource' => 'resource',
        ];

        $clientdata = $this->get_mock_clientdata();
        return new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope,
        		$tokenrec->resource, $tokenrec->user_id, $clientdata, $httpclient);
    }
}