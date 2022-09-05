odoo.define('s_base.FieldImageURL', function (require) {
    "use strict";
    var AbstractField = require('web.AbstractField');
    var core = require('web.core');
    var registry = require('web.field_registry');
    var _t = core._t;
    var UrlImage = AbstractField.extend({
        className: 'o_attachment_image',
        template: 'FieldImageURL',
        placeholder: "/s_base/static/src/img/favicon.png",
        supportedFieldTypes: ['char'],
        url: function () {
            return this.value ? this.value : this.placeholder;
        },
        _render: function () {
            this._super(arguments);
            var self = this;
            var $img = this.$("img:first");
            $img.on('error', function () {
                console.log('error load image: ' + this.value);
                $img.attr('src', self.placeholder);
                // self.do_warn(
                //     _t("Image"), _t("Could not display the selected image."));
            });
        },
    });
    registry.add('image_url', UrlImage);
});
