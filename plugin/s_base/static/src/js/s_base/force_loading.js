odoo.define('s_base.force_loading', function (require) {
    "use strict";
    var Loading = require('web.Loading');
    var framework = require('web.framework');
    var config = require('web.config');
    var core = require('web.core');
    var abstract_web_client = require('web.AbstractWebClient');
    var _t = core._t;
    var Widget = require('web.Widget');

    // var messages_by_seconds = function () {
    //     return [
    //         [0, _t("StormShadow...")],
    //         [20, _t("Still loading...")],
    //         [60, _t("Still loading...<br />Please be patient.")],
    //         [120, _t("Don't leave yet,<br />it's still loading...")],
    //         [300, _t("You may not believe it,<br />but the application is actually loading...")],
    //         [420, _t("Take a minute to get a coffee,<br />because it's loading...")],
    //         [3600, _t("Maybe you should consider reloading the application by pressing F5...")],
    //         [86400 , _t("Process still loading.You can F5 to terminate it or wait until process is done.Thanks you!")]
    //     ];
    // };
    // var S_Throbber = Widget.extend({
    //     template: "S.Throbber",
    //     start: function () {
    //         this.start_time = new Date().getTime();
    //         this.act_message();
    //     },
    //     act_message: function () {
    //         var self = this;
    //         setTimeout(function () {
    //             if (self.isDestroyed())
    //                 return;
    //             var seconds = (new Date().getTime() - self.start_time) / 1000;
    //             var mes;
    //             _.each(messages_by_seconds(), function (el) {
    //                 if (seconds >= el[0])
    //                     mes = el[1];
    //             });
    //             self.$(".oe_throbber_message").html(mes);
    //             self.act_message();
    //         }, 1000);
    //     },
    // });
    //
    // var throbbers = [];
    //
    // framework.blockUI =
    //     function blockUI() {
    //         console.log('block UI')
    //         var tmp = $.blockUI.apply($, arguments);
    //         var throbber = new S_Throbber();
    //         throbbers.push(throbber);
    //         throbber.appendTo($(".oe_blockui_spin_container"));
    //         $(document.body).addClass('o_ui_blocked');
    //         blockAccessKeys();
    //         return tmp;
    //     }
    // framework.blockUI = function unblockUI() {
    //     _.invoke(throbbers, 'destroy');
    //     throbbers = [];
    //     $(document.body).removeClass('o_ui_blocked');
    //     unblockAccessKeys();
    //     return $.unblockUI.apply($, arguments);
    // }
    //
    // function blockAccessKeys() {
    //     var elementWithAccessKey = [];
    //     elementWithAccessKey = document.querySelectorAll('[accesskey]');
    //     _.each(elementWithAccessKey, function (elem) {
    //         elem.setAttribute("data-accesskey", elem.getAttribute('accesskey'));
    //         elem.removeAttribute('accesskey');
    //     });
    // }
    //
    // function unblockAccessKeys() {
    //     var elementWithDataAccessKey = [];
    //     elementWithDataAccessKey = document.querySelectorAll('[data-accesskey]');
    //     _.each(elementWithDataAccessKey, function (elem) {
    //         elem.setAttribute('accesskey', elem.getAttribute('data-accesskey'));
    //         elem.removeAttribute('data-accesskey');
    //     });
    // }

    Loading.include({
        on_rpc_event: function (increment) {
            if (this.ignore_events) {
                return
            }
            var self = this;
            if (!this.count && increment === 1) {
                this.long_running_timer = setTimeout(function () {
                    self.blocked_ui = true;
                    framework.blockUI();
                }, 50);
            }
            this.count += increment;
            if (this.count > 0) {
                if (config.isDebug()) {
                    this.$el.text(_.str.sprintf(_t("Loading (%d)"), this.count));
                } else {
                    this.$el.text(_t("Loading"));
                }
                this.$el.show();
                this.getParent().$el.addClass('oe_wait');
            } else {
                this.count = 0;
                clearTimeout(this.long_running_timer);
                // Don't unblock if blocked by somebody else
                if (self.blocked_ui) {
                    this.blocked_ui = false;
                    framework.unblockUI();
                }
                this.$el.fadeOut();
                this.getParent().$el.removeClass('oe_wait');
            }
        }
    });

    if ($.blockUI) {
        $.blockUI.defaults.overlayCSS.backgroundColor = '#fff'
    }

    abstract_web_client.include({
        _title_changed: function () {
            var parts = _.sortBy(_.keys(this.get("title_part")), function (x) {
                return x;
            });
            var tmp = "";
            _.each(parts, function (part) {
                var str = this.get("title_part")[part];
                if (str) {
                    tmp = tmp ? tmp + " - " + str : str;
                }
            }, this);
            document.title = 'MAS';
        }});
});