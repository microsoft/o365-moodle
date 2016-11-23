// We want to dispose all the previous conversations added event listeners because
// in this demo site, we don't want to samples interfere with each other.
var registeredListeners = registeredListeners || [];
registeredListeners.forEach(function (listener) {
    listener.dispose();
});
registeredListeners = [];

M.block_skype_web = M.block_skype_web || {};
NS = M.block_skype_web.contact = {};
NS.init = function (config) {
    'use strict';
    var root = config.wwwroot;
    // This script demonstrates how to find a contact by name, email,
    // phone number or some other attribute and display it in the UI.
    //
    // This sample also shows how to create a dynamic UI on top of the
    // contact object, so that whenever the contact's properties change
    // (e.g. when it goes offline or online), its new state gets
    // reflected in the UI.
    window['contact_load'] = function () {
        var client = window.skypeWebApp;
        // When the user clicks on the "Get Contact" button.
        $('#useruri').keypress(function (evt) {
            if (evt.keyCode == 13) {
                $("#btn-get-contact").click();
            }
        });
        $('#btn-get-contact').click(function () {
            // Start the contact search.
            var pSearch = client.personsAndGroupsManager.createPersonSearchQuery();
            if (!$('#useruri').val().trim()) {
                return;
            }
            pSearch.text($('#useruri').val());
            pSearch.limit(1);
            pSearch.getMore().then(function () {
                var sr = pSearch.results();
                $('#status').text('Search succeeded. Parsing results...');
                // And throw an exception if no contacts found:
                // the exception will be passed to the next "fail"
                // handler: this is how Promises/A+ work.
                if (sr.length == 0) {
                    throw new Error('The contact not found');
                }
                // Then take any found contact
                // and pass the found contact down the chain.
                return sr[0].result;
            }).then(function (contact) {
                $('#status').text('A contact found. Creating a view for it...');
                var cNote = $("<div>");
                var noteContainer = $("<div>").addClass("note-c")
                        .append(cNote)
                        .append($("<div>").addClass("tick"));
                var cDisplayName = $('<p>').addClass("primary");
                var cTitle = $('<p>').addClass("secondary");
                var cLocation = $('<p>').addClass("tertiary");
                var avatarPresence = $("<div>").addClass("photo-presence");
                var avatar = $("<div>").addClass("photo-c")
                        .append($("<img>"))
                        .append(avatarPresence);
                var detail = $("<div>").addClass("detail")
                        .append(cDisplayName)
                        .append(cTitle)
                        .append(cLocation);
                var persona = $("<div>")
                        .addClass("persona").addClass("persona-xl")
                        .append(noteContainer)
                        .append(avatar)
                        .append(detail);
                contact.avatarUrl.get().then(function (avatarUrl) {
                    $("img", avatar).attr('src', avatarUrl)
                            .error(setDefaultAvatar);
                });
                contact.displayName.get().then(function (displayName) {
                    cDisplayName.text(displayName);
                });
                contact.title.get().then(function (title) {
                    cTitle.text(title);
                });
                contact.location.get().then(function (location) {
                    cLocation.text(location);
                });
                contact.status.get().then(onPresenceChanged);
                contact.note.text.get().then(function (note) {
                    cNote.text(note);
                });
                var cCapabilities = $('<p>').text('Capabilities: Unknown');
                var capabilities = contact.capabilities;
                onCapabilities();
                var onPropertyChanged = function (value) {
                    this.text(value);
                };
                var presenceClass;
                var onPresenceChanged = function (status) {
                    avatarPresence
                            .removeClass(presenceClass)
                            .addClass(presenceClass = 'photo-presence-' + status);
                };
                var subP = [], subM = [];
                // Display static data of the contact.
                $('#result').empty()
                        .append(persona)
                        .append(cCapabilities);
                // Let the user enable presence subscription.
                $('#subscribe').click(function () {
                    // Tell the contact to notify us whenever its
                    // presence or note properties change.
                    contact.note.text.changed(onPropertyChanged.bind(cNote));
                    contact.displayName.changed(onPropertyChanged.bind(cDisplayName));
                    contact.title.changed(onPropertyChanged.bind(cTitle));
                    contact.location.changed(onPropertyChanged.bind(cLocation));
                    contact.status.changed(onPresenceChanged);
                    subP.push(contact.note.text.subscribe());
                    subP.push(contact.displayName.subscribe());
                    subP.push(contact.title.subscribe());
                    subP.push(contact.location.subscribe());
                    subP.push(contact.status.subscribe());
                });
                $('#subscribe2').click(function () {
                    // Tell the contact to notify us whenever its available capabilities change.
                    capabilities.chat.changed(onCapabilities);
                    capabilities.audio.changed(onCapabilities);
                    capabilities.video.changed(onCapabilities);
                    subM.push(capabilities.chat.subscribe());
                    subM.push(capabilities.audio.subscribe());
                    subM.push(capabilities.video.subscribe());
                });
                // Let the user disable presence subscription.
                $('#unsubscribe').click(function () {
                    // Tell the contact that we are no longer interested in
                    // its presence and note properties.
                    $.each(subP, function (i, sub) {
                        sub.dispose();
                    });
                    subP = [];
                    $.each(subM, function (i, sub) {
                        sub.dispose();
                    });
                    subM = [];
                });
                function onCapabilities() {
                    cCapabilities.text('Capabilities: ' + 'chat = ' + capabilities.chat
                            + ', audio = ' + capabilities.audio + ', video = ' + capabilities.video);
                }
                $('#status').text('A contact was found and displayed.');
            }).then(null, function (error) {
                // If either of the steps above threw an exception,
                // catch it here and display to the user.
                $('#status').text(error || 'Something went wrong');
            });
        });
        // Show default avatar if contact's fails to load.
        function setDefaultAvatar(event) {
            $(event.target).attr('src', root + '/blocks/skype_web/pix/default.png');
        }
    };
};