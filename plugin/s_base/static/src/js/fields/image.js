odoo.define('s_base_utils.image', function (require) {
    "use strict";

    var core = require('web.core');
    var session = require('web.session');
    var fields = require('web.basic_fields');

    var _t = core._t;
    var QWeb = core.qweb;

    fields.FieldBinaryImage.extend({
        willStart: function () {
            var def = this._rpc({
                route: '/config/s_base_utils.binary_max_size',
            }).then(function (result) {
                this.max_upload_size = result.max_upload_size * 1024 * 1024;
            }.bind(this));
            return this._super.apply(this, arguments);
        },
        _render: function () {
            this._super.apply(this, arguments);
            this.$('.s_base_field_image_wrapper').remove();
            this.$('img').wrap($('<div/>', {
                class: "s_base_field_image_wrapper"
            }));
            var $wrapper = $('.s_base_field_image_wrapper');
            var width = this.nodeOptions.size ?
                this.nodeOptions.size[0] : this.attrs.width;
            var height = this.nodeOptions.size ?
                this.nodeOptions.size[1] : this.attrs.height;
            $wrapper.css('min-width', (width || 50) + 'px');
            $wrapper.css('min-height', (height || 50) + 'px');
        },
    });

});
