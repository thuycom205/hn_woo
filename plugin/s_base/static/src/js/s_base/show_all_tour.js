var s_update_tip_function_created = false;
var s_update_tip_function = undefined;
odoo.define('s_base.show_all_tour', function (require) {
    "use strict";
    var tour_manager = require('web_tour.TourManager');
    var all_tour = undefined;
    tour_manager.include({
        _register_all: function () {
            var self = this;
            self.$modal_displayed = [];
            var result = this._super.apply(this, arguments);
            if (s_update_tip_function_created === false) {
                s_update_tip_function = {
                    update_ui: function UpdateTipFunction() {
                        if (all_tour === undefined) {
                            all_tour = self.tours;
                        }
                        // manual active tour
                        var keys = Object.keys(all_tour)
                        for (var i = 0; i < keys.length; i++) {
                            if (keys[i].indexOf('tour_s_') !== -1) {
                                for (var j = 0; j < all_tour[keys[i]]['steps'].length; j++) {
                                    self._deactivate_tip(all_tour[keys[i]]['steps'][j]);
                                    self._check_for_tooltip(all_tour[keys[i]]['steps'][j], keys[i]);
                                }
                            }
                        }
                    }
                }
                typeof s_update_tip_function !== 'undefined' ? s_update_tip_function.update_ui() : false
                s_update_tip_function_created = true;
            }
            return result;
        },
    })
});
odoo.define('s_base.s_listen_do_action', function (require) {
    "use strict";
    var core = require('web.core');
    core.bus.on('DOM_updated', this, function () {
         typeof s_update_tip_function !== 'undefined' ? s_update_tip_function.update_ui() : false
    });
});