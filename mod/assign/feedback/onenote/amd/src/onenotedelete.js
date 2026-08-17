define(['jquery', 'core/ajax', 'core/notification', 'core/str', 'core/modal_delete_cancel', 'core/modal_events'],
    function($, ajax, notification, Str, ModalDeleteCancel, ModalEvents) {
        return {
            init: function() {
                var trigger = $('#deleteuserfeedback');
                var gradeid = $(trigger).attr('gradeid');
                var contextid = $(trigger).attr('contextid');
                var userid = $(trigger).attr('userid');

                trigger.on('click', function(e) {
                    e.preventDefault();
                    Str.get_strings([
                        {key: 'deletefeedbackconfirm', component: 'assignfeedback_onenote'},
                        {key: 'deletefeedbackconfirmdetail', component: 'assignfeedback_onenote'},
                    ]).then(function(strings) {
                        return ModalDeleteCancel.create({
                            title: strings[0],
                            body: strings[1],
                        });
                    }).then(function(modal) {
                        modal.getRoot().on(ModalEvents.delete, function(e) {
                            // Stop the default delete button behaviour which is to close the modal.
                            e.preventDefault();
                            var requests = ajax.call([{
                                methodname: 'mod_assign_feedback_onenote_delete',
                                args: {contextid: contextid, gradeid: gradeid, userid: userid}
                            }]);

                            requests[0].done(function() {
                                location.reload();
                            }).fail(notification.exception);
                        });
                        modal.show();
                        return modal;
                    }).catch(notification.exception);
                });
            }
        };
    }
);
