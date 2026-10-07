define(['jquery', 'core/config'], function($, config) {
    return {
        init: function(teamsThemeForced) {
            if (inTeams()) {
                // In Teams, hide page elements.
                $('body.drawer-open-left').css('margin-left', '0');
                $('div#page').css('margin-top', '0');
                $('section#region-main.has-blocks').css('width', '100%');
                $('div#page-wrapper').css('margin-bottom', '0');
                $('div.context-header-settings-menu').remove();
                $('div.region-main-settings-menu').remove();
                $('div.region_main_settings_menu_proxy').remove();
                $('div.action-menu-trigger').remove();
                $('div.ml-auto').remove();
                $('a.printicon').remove();
                $('header#page-header').css('display', 'none');
                $('.activityinstance a').click(function() {
                    $(this).attr('target', '_blank');
                });
                $('.modtype_assign .activityinstance a').click(function() {
                    $(this).attr('target', '_self');
                });
                $('.modtype_quiz .activityinstance a').click(function() {
                    $(this).attr('target', '_self');
                });
                $('#page-mod-assign-view .submissionlinks a').click(function() {
                    $(this).attr('target', '_blank');
                });
                $('.quizattempt .singlebutton form').click(function() {
                    $(this).attr('target', '_blank');
                    $(this).attr('method', 'get');
                });
            } else if (teamsThemeForced) {
                // Not in Teams, but this page is only rendering with the Teams theme because a
                // theme override left over from an earlier Teams tab visit is still active in the
                // session. Clear it and reload once so this page re-renders with the normal site
                // theme instead of leaking the Teams-only theme into direct browser access.
                resetForcedTeamsTheme();
                return;
            } else {
                showStandardElements();
            }
            $("body").fadeIn(150);
        }
    };

    /**
     * Show the standard page elements that the Teams tab view hides.
     */
    function showStandardElements() {
        $('nav.navbar').show();
        $('nav.navbar').css('display', 'flex');
        $('div#nav-drawer').show();
        $('section[data-region="blocks-column"]').show();
        $('footer#page-footer').show();
        $('div#course_page_title').css('display', 'none');
        $('.popupicon').css('display', 'none');
    }

    /**
     * Clear the session's Teams theme override and reload the page once, so it re-renders with
     * the normal site theme.
     */
    function resetForcedTeamsTheme() {
        fetch(config.wwwroot + '/local/o365/teams_theme_reset.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'sesskey=' + encodeURIComponent(config.sesskey)
        }).then(function(response) {
            if (!response.ok) {
                // The fetch() call only rejects on network failure, not on an HTTP error status
                // (e.g. a 403 from an expired sesskey), so that must be checked explicitly here.
                // Otherwise the reload below would fire even though the override was never
                // actually cleared, reloading into the same state and looping.
                throw new Error('Failed to reset the Teams theme override: ' + response.status);
            }
            window.location.reload();
            return;
        }).catch(function() {
            // If the reset request failed, fall back to showing the page as-is rather than
            // leaving it hidden.
            showStandardElements();
            $("body").fadeIn(150);
        });
    }

    /**
     * Check if the page is being displayed in Microsoft Teams.
     *
     * @return {boolean} True if the page is being displayed in Microsoft Teams, false otherwise.
     */
    function inTeams() {
        return ((window.location != window.parent.location) || (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)));
    }
});
