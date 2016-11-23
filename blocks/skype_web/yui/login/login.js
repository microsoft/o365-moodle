M.block_skype_web = M.block_skype_web || {};
NS = M.block_skype_web.login = {};
NS.init = function (config) {
    'use strict';
    var clientId = config.client_id;
    $(function () {
        var frm = $('#frmLoginToSkype');
        $(frm).find("input[type='hidden'][name='state']").val(window.location.href);
        $(frm).find('#btnSkypeLogin').on('click', function () {
            $('#frmLoginToSkype').submit();
        });
        $(frm).find('input[type="hidden"][name="client_id"]').val(clientId);
    });
};