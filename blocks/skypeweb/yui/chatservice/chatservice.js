// We want to dispose all the previous conversations added event listeners because
// in this demo site, we don't want to samples interfere with each other.
var registeredListeners = registeredListeners || [];
registeredListeners.forEach(function (listener) {
    listener.dispose();
});
registeredListeners = [];

M.block_skypeweb = M.block_skypeweb || {};
NS = M.block_skypeweb.chatservice = {};

NS.init = function (config) {
    // This script demonstrates how to send instant messages
    // with the SkypeWeb Conversation model.
    'use strict';
    window['chat-service_load'] = function () {
        if (window['noMeResource']) {
            $('.container .content .noMe').show();
        }
        var client = window.skypeWebApp;
        var chatService;
        var xHistory = $('#message-history');
        var incomingMessageCount = 0;
        var addedListener = client.conversationsManager.conversations.added(function (conversation) {
            var con = client.conversationsManager.conversations(0);
            if (con && con.selfParticipant.chat.state() == "Connected") {
                return;
            }
            chatService = conversation.chatService;
            chatService.accept.enabled.when(true, function () {
                // Instead of using chatService.accept.enabled.changed, selfParticipant.chat.state.changed should also work.
                // conversation.selfParticipant.chat.state.changed(function (state) {
                var fAccept = confirm("Accept this IM invitation?");
                if (fAccept) {
                    incomingMessageCount = 0;
                    chatService.accept();
                    uiToChatState();
                    $(".chat-name").text(conversation.participants(0).person.displayName());
                } else {
                    chatService.reject();
                }
                conversation.historyService.activityItems.added(function (message) {
                    incomingMessageCount++;
                    if (incomingMessageCount != 2) {
                        historyAppend(XMessage(message));
                    }
                });
            });
        });
        registeredListeners.push(addedListener);
        var removedListener = client.conversationsManager.conversations.removed(function (conversation) {
            console.log('one conversation is removed');
        });
        registeredListeners.push(removedListener);
        $('#btn-start-messaging').click(function () {
            startInstantMessaging();
        });
        $('#chat-to').keypress(function (evt) {
            if (evt.keyCode == 13) {
                evt.preventDefault();
                startInstantMessaging();
            }
        });
        $("#btn-send-message").click(function () {
            sendMessage();
        });
        $('#input-message').on('keypress', function (evt) {
            if (evt.keyCode == 13) {
                evt.preventDefault();
                sendMessage();
            }
        });
        function sendMessage() {
            var message = $("#input-message").text();
            if (message) {
                chatService.sendMessage(message).catch(function () {
                    console.log('Cannot send the message');
                });
            }
            $("#input-message").text("");
        }
        function startInstantMessaging() {
            var pSearch = client.personsAndGroupsManager.createPersonSearchQuery();
            pSearch.limit(1);
            pSearch.text($('#chat-to').text());
            pSearch.getMore().then(function () {
                var sr = pSearch.results();
                if (sr.length < 1) {
                    throw new Error('Contact not found');
                }
                return sr[0].result;
            }).then(function (contact) {
                uiToChatState();
                $(".chat-name").text(contact.displayName());
                var conversation = client.conversationsManager.getConversation(contact);
                chatService = conversation.chatService;
                conversation.selfParticipant.chat.state.when("Connected", function (state) {
                    addNotification('Conversation state: ' + state);
                    addNotification('Now you can send messages');
                    conversation.historyService.activityItems.added(function (message) {
                        historyAppend(XMessage(message));
                    });
                });
                chatService.start().then(function () {
                    //chatService.sendMessage('How are you?');
                });
            }).then(null, function (error) {
                console.error(error);
                addNotification('Search failed ' + error);
            });
            function addNotification(text) {
                $(".notification").text(text);
            }
        }
        // Returns a DOM element attached to the Message model.
        function XMessage(message) {
            var xTitle = $('<div>').addClass('sender');
            var xStatus = $('<div>').addClass('status');
            var xText = $('<div>').addClass('text').text(message.text());
            var xMessage = $('<div>').addClass('message');
            xMessage.append(xTitle, xStatus, xText);
            if (message.sender) {
                message.sender.displayName.get().then(function (displayName) {
                    xTitle.text(displayName);
                });
            }
            message.status.changed(function (status) {
                // xStatus.text(status);
            });
            if (message.sender.id() == client.personsAndGroupsManager.mePerson.id()) {
                xMessage.addClass("fromMe");
            }
            return xMessage;
        }
        $('#btn-stop-messaging').click(function () {
            chatService.stop().then(function () {
                uiToStartState();
            });
        });
        function uiToChatState() {
            $("#input-message").show();
            $("#start").hide();
            $('#status-header').show();
        }
        function uiToStartState() {
            $("#message-history").empty();
            $("#input-message").hide();
            $("#start").show();
            $('#status-header').hide();
        }
        function historyAppend(message) {
            xHistory.append(message);
            xHistory.animate({"scrollTop": xHistory[0].scrollHeight}, 'fast');
        }
    };
};
