define(['jquery'], function($) {
    return {
        init: function() {
            if (typeof microsoftTeams !== 'undefined') {
                microsoftTeams.initialize();

                microsoftTeams.getContext(function(context) {
                    var theme = context.theme;
                    $("body").addClass("theme_" + theme);
                });

                microsoftTeams.registerOnThemeChangeHandler(function(theme) {
                    $("body").removeClass("theme_default theme_dark theme_contrast");
                    $("body").addClass("theme_" + theme);
                });
            }
        }
    };
});
