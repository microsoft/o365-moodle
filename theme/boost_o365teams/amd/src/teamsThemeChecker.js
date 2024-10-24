define(['jquery', 'microsoftTeams'], function($, microsoftTeams) {
    return {
        init: function() {
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
    };
});
