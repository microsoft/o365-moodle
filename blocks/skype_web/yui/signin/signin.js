M.block_skype_web = M.block_skype_web || {};
NS = M.block_skype_web.signin = {};

NS.init = function (config) {
    'use strict';
    var clientId = config.client_id;
    var root = config.wwwroot;
    var errormessage = config.errormessage;
    window['sign-in_load'] = function () {
        var windowCtr = 1;
        $('#btnOpenChat').on('click', function () {
            window.open(root + '/blocks/skype_web/skypechat.php', 'Skype Chat' + windowCtr++, 'width=375,height=400,');
        });
        if (window.skypeWebApp && window.skypeWebApp.signInManager.state() == "SignedIn") {
            $('.wrappingdiv .signed-in').show();
            return;
        } else {
            $('.wrappingdiv .signed-in').hide();
            $('.modal').show();
            testForConfigAndSignIn({
                "client_id": clientId,
                "origins": ["https://webdir.online.lync.com/autodiscover/autodiscoverservice.svc/root"],
                "cors": true,
                "version": 'SkypeOnlinePreviewApp/1.0.0',
                "redirect_uri": root + '/blocks/skype_web/skypeloginreturn.php'
            });
        }
        function signin(options) {
            window.skypeWebApp.signInManager.signIn(options).then(function () {
                // When the sign in operation succeeds display the user name.
                $(".modal").hide();
                $('body').trigger({type: 'UserLoggedIn'});

                var svcToLoad = ['contact_load', 'self_load', 'chat-service_load', 'groups_load'];
                for (var svcCtr = 0; svcCtr < svcToLoad.length; svcCtr++) {
                    if (window[svcToLoad[svcCtr]] != null) {
                        window[svcToLoad[svcCtr]]();
                    }
                }
                console.log('Signed in as ' + window.skypeWebApp.personsAndGroupsManager.mePerson.displayName());
                if (!window.skypeWebApp.personsAndGroupsManager.mePerson.id()
                        && !window.skypeWebApp.personsAndGroupsManager.mePerson.avatarUrl()
                        && !window.skypeWebApp.personsAndGroupsManager.mePerson.email()
                        && !window.skypeWebApp.personsAndGroupsManager.mePerson.displayName()
                        && !window.skypeWebApp.personsAndGroupsManager.mePerson.title()) {
                    window['noMeResource'] = true;
                }
                $("#anonymous-join").addClass("disable");
                $(".menu #sign-in").click();
                // listenForConversations();
            }, function (error) {
                // If something goes wrong in either of the steps above,
                // display the error message.
                $(".modal").hide();
                alert(errormessage);
                console.log(error || 'Cannot sign in');
            });
        }
        function testForConfigAndSignIn(options) {
            Skype.initialize({
                apiKey: '9c967f6b-a846-4df2-b43d-5167e47d81e1'
            }, function (api) {
                window.skypeWebApp = api.UIApplicationInstance;
                window.skypeApi = api;
                window.skypeWebAppCtor = api.application;
                signin(options);
            }, function (err) {
                console.log(err);
            });
        }
    };
    window['sign-in_load']();
};
