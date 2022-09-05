odoo.define('s_base_utils.NotificationService', function (require) {
    "use strict";

    var NotificationService = require('web.NotificationService');

    NotificationService.include({
        progress: function (notificationId, progress) {
            if (notificationId in this.notifications) {
                var notification = this.notifications[notificationId];
                notification.updateProgress(progress.state, progress.text);
            }
        },
    });

});
