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
    var $clientcertsource = $("#id_clientcertsource");
    var $secretexpiryrecipients = $("#id_secretexpiryrecipients");
    var $changesecret = $("#id_changesecret");

    // Get the original masked value for client secret - needed by multiple handlers.
    var originalSecretValue = '';
    if ($changesecret.length) {
        // 1. Try data attribute (most reliable, set directly in form definition)
        if ($clientsecret.attr('data-original-masked')) {
            originalSecretValue = $clientsecret.attr('data-original-masked');
        }

        // 2. Fallback to hidden field
        if (!originalSecretValue) {
            var $originalsecretmasked = $("#id_originalsecretmasked");
            if ($originalsecretmasked.length) {
                originalSecretValue = $originalsecretmasked.val();
            }
        }

        // 3. Last fallback: if field value looks masked, use it
        // Pattern matches either 10 asterisks (for short secrets) or 2 chars + 10 asterisks.
        if (!originalSecretValue && $clientsecret.val() && $clientsecret.val().match(/^(.{2})?\*{10}$/)) {
            originalSecretValue = $clientsecret.val();
        }
    }

    $idptype.change(function() {
        if ($(this).val() != idptype_ms) {
            $("#id_clientauthmethod option[value='" + authmethodcertificate + "']").each(function() {
                $(this).remove();
            });
            $clientauthmethod.val(authmethodsecret);
            $clientsecret.prop('disabled', false);
            $clientcertsource.prop('disabled', true);
            $clientcert.prop('disabled', true);
            $clientprivatekey.prop('disabled', true);
            $clientprivatekeyfile.prop('disabled', true);
            $clientcertfile.prop('disabled', true);
            $clientcertpassphrase.prop('disabled', true);
            $secretexpiryrecipients.prop('disabled', false);
        } else {
            $clientauthmethod.append("<option value='" + authmethodcertificate + "'>" + authmethodcertificatetext + "</option>");
        }
    });

    $clientauthmethod.change(function() {
        if ($(this).val() == authmethodcertificate) {
            if ($clientcertsource.val() == 'file') {
                $clientcert.prop('disabled', true);
                $clientprivatekey.prop('disabled', true);
                $clientprivatekeyfile.prop('disabled', false);
                $clientcertfile.prop('disabled', false);
            } else {
                $clientcert.prop('disabled', false);
                $clientprivatekey.prop('disabled', false);
                $clientprivatekeyfile.prop('disabled', true);
                $clientcertfile.prop('disabled', true);
            }
            $clientcertpassphrase.prop('disabled', false);
            $clientcertsource.prop('disabled', false);
            // Disable the "change secret" checkbox when certificate authentication is selected.
            if ($changesecret.length) {
                // If the checkbox is checked, restore the masked value before disabling.
                if ($changesecret.is(':checked') && originalSecretValue) {
                    $clientsecret.val(originalSecretValue);
                }
                $changesecret.prop('disabled', true);
                $changesecret.prop('checked', false);
            }
            $clientsecret.prop('disabled', true);
        } else {
            $secretexpiryrecipients.prop('disabled', false);
            // Re-enable the "change secret" checkbox when secret authentication is selected.
            if ($changesecret.length) {
                $changesecret.prop('disabled', false);
            }
        }
    });

    // Handle "change secret" checkbox - clear field when checked, restore when unchecked.
    if ($changesecret.length) {
        $changesecret.change(function() {
            if ($(this).is(':checked')) {
                // Clear the masked value when user wants to change the secret.
                $clientsecret.prop('disabled', false); // Ensure it's enabled.
                $clientsecret.val('');
                $clientsecret.focus();
            } else {
                // Restore the original masked value when unchecked.
                if (originalSecretValue) {
                    // Set the value BEFORE Moodle's disabledIf disables the field.
                    $clientsecret.prop('disabled', false); // Temporarily enable to set value.
                    $clientsecret.val(originalSecretValue);
                    // Small delay to ensure value is set before Moodle's form dependencies disable it.
                    setTimeout(function() {
                        // Moodle's disabledIf will handle disabling the field after this.
                    }, 10);
                }
            }
        });

        // On page load, if checkbox is unchecked, ensure field shows the masked value.
        if (!$changesecret.is(':checked')) {
            if (originalSecretValue && $clientsecret.val() !== originalSecretValue) {
                $clientsecret.val(originalSecretValue);
            }
        }
    }

    // Handle "change certificate passphrase" checkbox.
    var $changecertpassphrase = $("#id_changecertpassphrase");
    if ($changecertpassphrase.length) {
        // Get the original masked value - try multiple sources for reliability.
        var originalPassphraseValue = '';

        // 1. Try data attribute (most reliable, set directly in form definition)
        if ($clientcertpassphrase.attr('data-original-masked')) {
            originalPassphraseValue = $clientcertpassphrase.attr('data-original-masked');
        }

        // 2. Fallback to hidden field
        if (!originalPassphraseValue) {
            var $originalpassphrasemasked = $("#id_originalpassphrasemasked");
            if ($originalpassphrasemasked.length) {
                originalPassphraseValue = $originalpassphrasemasked.val();
            }
        }

        // 3. Last fallback: if field value looks masked, use it
        // Pattern matches either 10 asterisks (for short passphrases) or 2 chars + 10 asterisks.
        if (!originalPassphraseValue && $clientcertpassphrase.val() && $clientcertpassphrase.val().match(/^(.{2})?\*{10}$/)) {
            originalPassphraseValue = $clientcertpassphrase.val();
        }

        $changecertpassphrase.change(function() {
            if ($(this).is(':checked')) {
                // Clear the masked value when user wants to change the passphrase.
                $clientcertpassphrase.prop('disabled', false); // Ensure it's enabled.
                $clientcertpassphrase.val('');
                $clientcertpassphrase.focus();
            } else {
                // Restore the original masked value when unchecked.
                if (originalPassphraseValue) {
                    // Set the value BEFORE Moodle's disabledIf disables the field.
                    $clientcertpassphrase.prop('disabled', false); // Temporarily enable to set value.
                    $clientcertpassphrase.val(originalPassphraseValue);
                    // Small delay to ensure value is set before Moodle's form dependencies disable it.
                    setTimeout(function() {
                        // Moodle's disabledIf will handle disabling the field after this.
                    }, 10);
                }
            }
        });

        // On page load, if checkbox is unchecked, ensure field shows the masked value.
        if (!$changecertpassphrase.is(':checked')) {
            if (originalPassphraseValue && $clientcertpassphrase.val() !== originalPassphraseValue) {
                $clientcertpassphrase.val(originalPassphraseValue);
            }
        }
    }

    // Initial state: disable "change secret" checkbox if certificate authentication is selected.
    if ($changesecret.length && $clientauthmethod.val() == authmethodcertificate) {
        $changesecret.prop('disabled', true);
        $changesecret.prop('checked', false);
    }
};
