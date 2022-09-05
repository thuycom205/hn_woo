odoo.define('s_base.ActionManager', function (require) {
    "use strict";
    var rpc = require('web.rpc');
    // var session = require('web.session');
    var ActionManager = require('web.ActionManager');

    ActionManager.include({

        getMenuCookie: function (cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        _handleAction: function (action) {
            try {
                // console.log(action)
                var is_first_action = false
                // phuong an tam thoi, se tim cach lam tot hon
                if (typeof action.res_model != 'undefined') {
                    if (action.res_model.includes('.about')) {
                        is_first_action = true
                    }
                } else {
                    if (typeof action.model_name != 'undefined') {
                        var model_name = action.model_name
                        if (model_name.includes('.about')) {
                            is_first_action = true
                        }
                    }
                }

                if (!$('.s_menu_active').length > 0) {
                    var current_menu_id = this.getMenuCookie('currentMenuID')
                    var current_menu_match = false

                    async function processFindCurrentMenu(elements) {
                        // map array to promises
                        const promises = $.each(elements, function (index, value) {
                            if ($(value).attr('class').indexOf('s_base_menu_no_icon') == -1) {
                                var menu_data_id = parseInt($(value).attr('data-menu'))
                                if (parseInt(current_menu_id) == menu_data_id && !is_first_action) {
                                    $(value).addClass('s_menu_active')
                                    current_menu_match = true
                                }

                            }

                        });
                        // wait until all promises are resolved
                        await Promise.all(promises);
                        if (!current_menu_match) {
                            $.each(elements, function (index, value) {
                                if ($(value).attr('class').indexOf('s_base_menu_no_icon') == -1) {
                                    $(value).addClass('s_menu_active')
                                    return false
                                }

                            });
                        }
                    }

                    // setTimeout(function () {
                    //     var menus = $('.o_menu_entry_lvl_1')
                    //     processFindCurrentMenu(menus)
                    // }, 750);
                    var waitForEl = function (selector, callback) {
                        if ($(selector).length > 0) {
                            callback();
                        } else {
                            setTimeout(function () {
                                waitForEl(selector, callback);
                            }, 200);
                        }
                    };
                    setTimeout(function () {
                        waitForEl('.o_menu_entry_lvl_1', function () {
                            var menus = $('.o_menu_entry_lvl_1')
                            processFindCurrentMenu(menus)
                        });
                    }, 750);


                }
            } catch (e) {
                console.log("Error")
                console.log(e)
            }
            // logan find action model of which app
            try {
                var action_res_model = action['res_model'];
                rpc.query({
                    model: 'ir.model',
                    method: 'search_read',
                    domain: [['model', '=', action_res_model]],
                    fields: ['module_name'],
                }).then(function (result) {
                    if (result != undefined && result.length > 0) {
                        document.title = 'MAS - ' + result[0]['module_name'];
                        // console.log(result[0]['module_name'])
                    }
                });
            } catch (e) {
                console.log(e)
            }
            // logan end find first action

            return this._super.apply(this, arguments).then($.proxy(this, '_hideMenusByAction', action));
        },
        _hideMenusByAction: function (action) {
            var unique_selection = '[data-action-id=' + action.id + ']';
            $(_.str.sprintf('.o_menu_apps .dropdown:has(.dropdown-menu.show:has(%s)) > a', unique_selection)).dropdown('toggle');
            $(_.str.sprintf('.o_menu_sections.show:has(%s)', unique_selection)).collapse('hide');
        },
    })

    // rpc.query({
    //     model: 'res.users',
    //     method: 'search_read',
    //     args: [[['id', '=', session.uid]], ['chatter_position']]
    // }).then(function (pos) {
    //     var position = pos[0]['chatter_position'];
    //     var clsNames = 'o_action_manager s_base_chatter_position_' + position;
    //     ActionManager.include({
    //         className: clsNames,
    //
    //         _handleAction: function (action) {
    //             return this._super.apply(this, arguments).then($.proxy(this, '_hideMenusByAction', action));
    //         },
    //         _hideMenusByAction: function (action) {
    //             var unique_selection = '[data-action-id=' + action.id + ']';
    //             $(_.str.sprintf('.o_menu_apps .dropdown:has(.dropdown-menu.show:has(%s)) > a', unique_selection)).dropdown('toggle');
    //             $(_.str.sprintf('.o_menu_sections.show:has(%s)', unique_selection)).collapse('hide');
    //         },
    //     })
    // });
})
