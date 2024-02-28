/*global $, M, sessionStorage*/

M.auth_oidc = {};

M.auth_oidc.init = function(Y, idptype_ms, authmethodsecret, authmethodcertificate, authmethodcertificatetext) {
    var $idptype = $("#id_idptype");
    var $clientauthmethod = $("#id_clientauthmethod");
    var $clientsecret = $("#id_clientsecret");
    var $clientcert = $("#id_clientcert");
    var $clientprivatekey = $("#id_clientprivatekey");
    var $clientprivatekeyfile = $("#id_clientprivatekeyfile");
    var $clientcertfile = $("#id_clientcertfile");
    var $clientcertpassphrase = $("#id_clientcertpassphrase");

    $idptype.change(function() {
        if ($(this).val() != idptype_ms) {
            $("#id_clientauthmethod option[value='" + authmethodcertificate + "']").each(function() {
                $(this).remove();
            });
            $clientauthmethod.val(authmethodsecret);
            $clientsecret.prop('disabled', false);
            $clientcert.prop('disabled', true);
            $clientprivatekey.prop('disabled', true);
            $clientprivatekeyfile.prop('disabled', true);
            $clientcertfile.prop('disabled', true);
            $clientcertpassphrase.prop('disabled', true);
        } else {
            $clientauthmethod.append("<option value='" + authmethodcertificate + "'>" + authmethodcertificatetext + "</option>");
        }
    });

    $clientauthmethod.change(function() {
        if ($(this).val() == authmethodcertificate) {
            $clientcert.prop('disabled', false);
            $clientprivatekey.prop('disabled', false);
            $clientprivatekeyfile.prop('disabled', false);
            $clientcertfile.prop('disabled', false);
            $clientcertpassphrase.prop('disabled', false);
        }
    });
};
