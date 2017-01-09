// We want to dispose all the previous conversations added event listeners because
// in this demo site, we don't want to samples interfere with each other.
var registeredListeners = registeredListeners || [];
registeredListeners.forEach(function (listener) {
    listener.dispose();
});
registeredListeners = [];

M.block_skypeweb = M.block_skypeweb || {};
NS = M.block_skypeweb.groups = {};
NS.init = function (config) {
    'use strict';
    var root = config.wwwroot;
    // This sample demonstrates how to get the contact list,
    // how to get the list of groups and how to get the list
    // of relationships ("Colleagues", "Workgroup" and so on).
    window['groups_load'] = function () {
        var client = window.skypeWebApp;
        var tagContactList = createGroupView(client.personsAndGroupsManager.all.persons, 'Contact List');
        $('#results').append(tagContactList);
        // Display the list of groups and relationship groups.
        client.personsAndGroupsManager.all.groups.subscribe();
        client.personsAndGroupsManager.all.groups.added(function (group) {
            var tagGroup;
            if (group.name()) {
                tagGroup = createGroupView(group.persons, group.name());
            }
            else if(group.type()) {
                tagGroup = createGroupView(group.persons, group.type());
            }
            else {
                tagGroup = createGroupView(group.persons, group.relationshipLevel());
            }
            $('#results').append(tagGroup);
        });
        /**
         * Creates a <div> element that contains a visual representation of
         * the given collection of contacts.
         *
         * @param {Collection} contacts
         * @param {String} title
         *
         * @returns A <div> element created with jQuery.
         */
        function createGroupView(contacts, title) {
            var tagName = $('<div>').text(title).addClass('group-name');
            var tagGroup = $('<div>').addClass("persona-list").append(tagName);
            contacts.subscribe();
            // When a contact gets added to the group.
            contacts.added(function (contact) {
                var avatar = $("<div>").addClass("photo-c")
                        .append($("<img>")
                                .error(setDefaultAvatar));
                var detailPrimary = $("<div>").addClass("primary");
                var detail = $("<div>").addClass("detail")
                        .append(detailPrimary);
                var tagContact = $("<li>").addClass("persona").addClass("persona-small")
                        .append(avatar)
                        .append(detail)
                        .appendTo(tagGroup);
                // When the contact's avatar changes, update the <img> src.
                contact.avatarUrl.get().then(function (url) {
                    $("img", avatar).attr("src", url);
                });
                // When the contact's name changes, update the <li> tag's text.
                contact.displayName.get().then(function (displayName) {
                    detailPrimary.text(displayName);
                });
            });
            return tagGroup;
        }
        // Show default avatar if user's fails to load.
        function setDefaultAvatar(event) {
            $(event.target).attr('src', root + '/blocks/skypeweb/pix/default.png');
        }
    };
};
