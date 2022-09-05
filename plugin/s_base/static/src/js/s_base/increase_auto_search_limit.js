odoo.define('s_base.increase_auto_search_limit', function (require) {
    "use strict";
    var relational_fields = require('web.relational_fields');
    relational_fields.FieldMany2One.include({
        init: function ($node) {
            var self = this;
            this._super.apply(this, arguments);
            this.limit = 1000;
            this.current_offet_top = 0
        },
        _bindAutoComplete: function () {
            var self = this;
            // avoid ignoring autocomplete="off" by obfuscating placeholder, see #30439
            if ($.browser.chrome && this.$input.attr('placeholder')) {
                this.$input.attr('placeholder', function (index, val) {
                    return val.split('').join('\ufeff');
                });
            }
            this.$input.autocomplete({
                source: function (req, resp) {
                    _.each(self._autocompleteSources, function (source) {
                        // Resets the results for this source
                        source.results = [];

                        // Check if this source should be used for the searched term
                        if (!source.validation || source.validation.call(self, req.term)) {
                            source.loading = true;

                            // Wrap the returned value of the source.method with a promise
                            // So event if the returned value is not async, it will work
                            Promise.resolve(source.method.call(self, req.term)).then(function (results) {
                                source.results = results;
                                source.loading = false;
                                resp(self._concatenateAutocompleteResults());
                            });
                        }
                    });
                },
                select: function (event, ui) {
                    // we do not want the select event to trigger any additional
                    // effect, such as navigating to another field.
                    event.stopImmediatePropagation();
                    event.preventDefault();

                    var item = ui.item;
                    self.floating = false;
                    if (item.id) {
                        self.reinitialize({id: item.id, display_name: item.name});
                    } else if (item.action) {
                        item.action();
                    }
                    return false;
                },
                focus: function (event) {
                    event.preventDefault(); // don't automatically select values on focus
                },
                open: function (event) {
                    // start logan
                    self.current_offet_top = self.$input.offset().top;
                    self._onScroll = function (ev) {
                        if (ev.target !== self.$input.get(0) && self.$input.hasClass('ui-autocomplete-input') && self.$input.offset().top != self.current_offet_top) {
                            self.$input.autocomplete('close');
                        }
                    };
                    // end logan
                    window.addEventListener('scroll', self._onScroll, true);
                },
                close: function (event) {
                    this.is_focus = false
                    // it is necessary to prevent ESC key from propagating to field
                    // root, to prevent unwanted discard operations.
                    if (event.which === $.ui.keyCode.ESCAPE) {
                        event.stopPropagation();
                    }
                    if (self._onScroll) {
                        window.removeEventListener('scroll', self._onScroll, true);
                    }
                },
                autoFocus: true,
                html: true,
                minLength: 0,
                delay: this.AUTOCOMPLETE_DELAY,
            });
            this.$input.autocomplete("option", "position", {my: "left top", at: "left bottom"});
            this.autocomplete_bound = true;
        },
    });
});