odoo.define('s_base_utils.path', function (require) {
    "use strict";

    var core = require('web.core');
    var fields = require('web.basic_fields');
    var registry = require('web.field_registry');

    var AbstractField = require('web.AbstractField');

    var _t = core._t;
    var QWeb = core.qweb;

    var FieldPathNames = fields.FieldChar.extend({
        init: function (parent, name, record) {
            this._super.apply(this, arguments);
            this.max_width = this.nodeOptions.width || 500;
        },
        _renderReadonly: function () {
            var show_value = this._formatValue(this.value);
            var text_witdh = $.fn.textWidth(show_value);
            if (text_witdh >= this.max_width) {
                var ratio_start = (1 - (this.max_width / text_witdh)) * show_value.length;
                show_value = ".." + show_value.substring(ratio_start, show_value.length);
            }
            this.$el.text(show_value);
        },
    });

    var FieldPathJson = fields.FieldText.extend({
        events: _.extend({}, fields.FieldText.prototype.events, {
            'click a': '_onNodeClicked',
        }),
        init: function (parent, name, record) {
            this._super.apply(this, arguments);
            this.max_width = this.nodeOptions.width || 500;
            this.seperator = this.nodeOptions.seperator || "/";
            this.prefix = this.nodeOptions.prefix || false;
            this.suffix = this.nodeOptions.suffix || false;
        },
        _renderReadonly: function () {
            this.$el.empty();
            this._renderPath();
        },
        _renderPath: function () {
            var text_width_measure = "";
            var path = JSON.parse(this.value || "[]");
            $.each(_.clone(path).reverse(), function (index, element) {
                text_width_measure += element.name + "/";
                if ($.fn.textWidth(text_width_measure) >= this.max_width) {
                    this.$el.prepend($('<span/>').text(".."));
                } else {
                    if (index == 0) {
                        if (this.suffix) {
                            this.$el.prepend($('<span/>').text(this.seperator));
                        }
                        this.$el.prepend($('<span/>').text(element.name));
                        this.$el.prepend($('<span/>').text(this.seperator));
                    } else {
                        this.$el.prepend($('<a/>', {
                            'class': 'oe_form_uri',
                            'data-model': element.model,
                            'data-id': element.id,
                            'href': "javascript:void(0);",
                            'text': element.name,
                        }));
                        if (index != path.length - 1) {
                            this.$el.prepend($('<span/>').text(this.seperator));
                        } else if (this.prefix) {
                            this.$el.prepend($('<span/>').text(this.seperator));
                        }
                    }
                }
                return ($.fn.textWidth(text_width_measure) < this.max_width);
            }.bind(this));
        },
        _onNodeClicked: function (event) {
            this.do_action({
                type: 'ir.actions.act_window',
                res_model: $(event.currentTarget).data('model'),
                res_id: $(event.currentTarget).data('id'),
                views: [[false, 'form']],
                target: 'current',
                context: {},
            });
        }
    });

    registry.add('path_names', FieldPathNames);
    registry.add('path_json', FieldPathJson);

    return {
        FieldPathNames: FieldPathNames,
        FieldPathJson: FieldPathJson,
    };

});