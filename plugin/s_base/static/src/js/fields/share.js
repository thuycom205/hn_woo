odoo.define('s_base_utils.share', function (require) {
    "use strict";

    var core = require('web.core');
    var session = require('web.session');
    var fields = require('web.basic_fields');
    var registry = require('web.field_registry');

    var utils = require('s_base_utils.utils');
    var copy = require('s_base_utils.copy');

    var _t = core._t;
    var QWeb = core.qweb;

    var ShareMixin = {
        shareEvents: {
            'click .s_base_share_dropdown_message': '_onShareMessageClick',
            'click .s_base_share_dropdown_note': '_onShareNoteClick',
            'click .s_base_share_dropdown_mail': '_onShareMailClick',
            'click .s_base_share_dropdown_send': '_onShareSendClick',
        },
        getShareMessageValues: function (message) {
            var values = {
                name: session.partner_display_name,
                record: this.recordData.display_name,
                url: utils.isUrl(this.value) && this.value,
                value: this.value,
            };
            return {
                subject: _.template(this.shareOptions.subjectTemplate)(values),
                body: QWeb.render(this.shareOptions.bodyTemplate, values),
                text: _.template(this.shareOptions.textTemplate)(values),
                url: utils.isUrl(this.value) && this.value,
            }
        },
        openShareChat: function (note) {
            var values = this.getShareMessageValues();
            var context = {
                default_is_log: note,
                default_body: values.body,
                default_subject: values.subject,
                default_model: this.shareOptions.res_model,
                default_res_id: this.shareOptions.res_id,
                mail_post_autofollow: false,
            };
            this.do_action({
                type: 'ir.actions.act_window',
                res_model: 'mail.compose.message',
                view_mode: 'form',
                views: [[false, 'form']],
                target: 'new',
                context: context,
            });
        },
        _onShareMessageClick: function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.openShareChat(false);
        },
        _onShareNoteClick: function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.openShareChat(true);
        },
        _onShareMailClick: function (event) {
            event.preventDefault();
            event.stopPropagation();
            var values = this.getShareMessageValues();
            var subject = "subject=" + values.subject;
            var body = "&body=" + encodeURIComponent(values.text);
            window.location.href = "mailto:?" + subject + body;
        },
        _onShareSendClick: function (event) {
            event.preventDefault();
            event.stopPropagation();
            var values = this.getShareMessageValues();
            navigator.share({
                title: values.subject,
                text: values.text,
                url: values.url,
            });
        },
    };

    var CharShare = fields.CharCopyClipboard.extend(ShareMixin, {
        fieldDependencies: _.extend({}, fields.CharCopyClipboard.prototype.fieldDependencies, {
            display_name: {type: 'char'},
        }),
        events: _.extend({}, fields.CharCopyClipboard.prototype.events, ShareMixin.shareEvents),
        init: function (parent, name, record) {
            this._super.apply(this, arguments);
            this.navigator = window.navigator.share;
            this.chatter = _.contains(odoo._modules, "mail");
            this.shareOptions = _.defaults(this.nodeOptions, {
                subjectTemplate: _t("<%= name %> shared a message!"),
                textTemplate: _t("<%= value %>"),
                bodyTemplate: 's_base_utils.ShareMessage',
            });
            this.shareOptions = _.extend({}, this.shareOptions, {
                res_model: this.recordData[this.nodeOptions.res_model] || this.model,
                res_id: this.recordData[this.nodeOptions.res_id] || this.res_id,
            });
        },
        _render: function () {
            this._super.apply(this, arguments);
            this.$el.addClass('s_base_field_share');
            this.$el.prepend($(QWeb.render('s_base_utils.CharShare', {
                navigator: !!this.navigator,
                chatter: !!this.chatter,
            })));
        },
    });

    var TextShare = fields.TextCopyClipboard.extend(ShareMixin, {
        fieldDependencies: _.extend({}, fields.TextCopyClipboard.prototype.fieldDependencies, {
            display_name: {type: 'char'},
        }),
        events: _.extend({}, fields.TextCopyClipboard.prototype.events, ShareMixin.shareEvents),
        init: function (parent, name, record) {
            this._super.apply(this, arguments);
            this.navigator = window.navigator.share;
            this.chatter = _.contains(odoo._modules, "mail");
            this.shareOptions = _.defaults(this.nodeOptions, {
                subjectTemplate: _t("<%= name %> shared a message!"),
                textTemplate: _t("<%= value %>"),
                bodyTemplate: 's_base_utils.ShareMessage',
            });
            this.shareOptions = _.extend({}, this.shareOptions, {
                res_model: this.recordData[this.nodeOptions.res_model] || this.model,
                res_id: this.recordData[this.nodeOptions.res_id] || this.res_id,
            });
        },
        _render: function () {
            this._super.apply(this, arguments);
            this.$el.addClass('s_base_field_share');
            this.$el.prepend($(QWeb.render('s_base_utils.TextShare', {
                navigator: !!this.navigator,
                chatter: !!this.chatter,
            })));
        }
    });

    var BinaryFileShare = copy.BinaryFileCopy.extend(ShareMixin, {
        fieldDependencies: _.extend({}, fields.FieldBinaryFile.prototype.fieldDependencies, {
            display_name: {type: 'char'},
        }),
        events: _.extend({}, copy.BinaryFileCopy.prototype.events, ShareMixin.shareEvents, {
            'click .s_base_share_button': '_onShareDropdownClick',
        }),
        init: function () {
            this._super.apply(this, arguments);
            this.navigator = window.navigator.share;
            this.chatter = _.contains(odoo._modules, "mail");
            this.shareOptions = _.defaults(this.nodeOptions, {
                subjectTemplate: _t("<%= name %> shared a file!"),
                textTemplate: _t("<%= value %>"),
                bodyTemplate: 's_base_utils.ShareBinaryMessage',
            });
            this.shareOptions = _.extend({}, this.shareOptions, {
                res_model: this.recordData[this.nodeOptions.res_model] || this.model,
                res_id: this.recordData[this.nodeOptions.res_id] || this.res_id,
            });
        },
        getShareMessageValues: function () {
            var values = {
                name: session.partner_display_name,
                record: this.recordData.display_name,
                url: this.shareUrl,
                value: this.shareUrl,
            };
            return {
                subject: _.template(this.shareOptions.subjectTemplate)(values),
                body: QWeb.render(this.shareOptions.bodyTemplate, values),
                text: _.template(this.shareOptions.textTemplate)(values),
                url: this.shareUrl,
            }
        },
        _renderReadonly: function () {
            this._super.apply(this, arguments);
            this.$el.addClass('s_base_field_share');
            this.$el.append($(QWeb.render('s_base_utils.BinaryShare', {
                navigator: !!this.navigator,
                chatter: !!this.chatter,
                share: !!this.shareUrl,
            })));
        },
        _onShareDropdownClick: function (event) {
            $(event.currentTarget).dropdown("toggle");
            event.stopPropagation();
        },
    });

    registry.add('share_char', CharShare);
    registry.add('share_text', TextShare);
    registry.add('share_binary', BinaryFileShare);

    return {
        ShareMixin: ShareMixin,
        CharShare: CharShare,
        TextShare: TextShare,
        BinaryFileShare: BinaryFileShare,
    };

});