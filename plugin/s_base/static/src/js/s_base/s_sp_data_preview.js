// Trigger onchange on popup field when enter keyboard
// Define new widget
odoo.define('s.app.data.widget', function (require) {
    "use strict";

    var AbstractField = require('web.AbstractField');
    var core = require('web.core');
    var field_registry = require('web.field_registry');
    var Dialog = require('web.Dialog');

    var QWeb = core.qweb;
    var _t = core._t;

    var Pagination = AbstractField.extend({
        supportedFieldTypes: ['char'],
        events: {
            'click .s_pre_data': '_onPreDataPage',
            'click .s_next_data': '_onNextDataPage',
        },

        //--------------------------------------------------------------------------
        // Public
        //--------------------------------------------------------------------------

        /**
         * @override
         * @returns {boolean}
         */
        init: function () {
            this._super.apply(this, arguments);
        },
        _onPreDataPage: function (e) {
            e.preventDefault();
            const pages = document.getElementsByClassName('s_sp_data_page')
            // Disable when search
            var in_search = false
            const search = document.getElementsByClassName('s_sp_data_search')
            const current_page = document.getElementById('current_page')
            if (search.length > 0) {
                search[0].value != '' ? in_search = true : false
            }
            if (pages.length > 0 && !in_search) {
                var page = pages[0];
                var page_value = parseInt(page.value)
                if (page_value > 1) {
                    var pre_page = page_value - 1
                    current_page ? $(current_page).html(pre_page) : null
                    $(page).focus()
                    page.value = pre_page
                    $(page).trigger('change')
                }

            }

        },
        _onNextDataPage: function (e) {
            e.preventDefault();
            const pages = document.getElementsByClassName('s_sp_data_page')
            var in_search = false
            var has_next_page = false
            const search = document.getElementsByClassName('s_sp_data_search')
            const current_page = document.getElementById('current_page')
            const current_next_page = document.getElementsByClassName('s_sp_data_next_page')
            current_next_page ? has_next_page = current_next_page[0].firstElementChild.checked : false
            // disable in search
            if (search.length > 0) {
                search[0].value != '' ? in_search = true : false
            }
            if (pages.length > 0 && !in_search && has_next_page) {
                var page = pages[0];
                var page_value = parseInt(page.value)
                var next_page = page_value + 1
                current_page ? $(current_page).html(next_page) : null
                $(page).focus()
                page.value = next_page
                $(page).trigger('change')
                // todo
                // Prevent crazy click
                // e.currentTarget.disabled = true
                // setTimeout(() =>e.currentTarget.disabled = false, 5000);
            }
        },
        /**
         * @private
         * @override
         */
        _render: function () {
            this.$el.html(QWeb.render('s_pagination', {}));

        },

        //--------------------------------------------------------------------------
        // Handlers
        //--------------------------------------------------------------------------

    });

    var TreeImg = AbstractField.extend({
        supportedFieldTypes: ['char'],

        init: function () {
            this._super.apply(this, arguments);
        },

        _render: function () {
            this.$el.html(QWeb.render('s_tree_img', {value:this.value}));

        },
    });

    field_registry.add('s_tree_img', TreeImg);
    field_registry.add('pagination', Pagination);
    // field_registry.add('s_products_badge', SBadge);

    var DataDialog = Dialog.include({
        events: _.extend({}, Dialog.events, {
            'keyup input.s_sp_data_search': '_onkeyup_search',
            'focusout input.s_sp_data_search': '_onInputFocusout_search',
        }),

        _onkeyup_search: function (event) {
            if (event.keyCode === $.ui.keyCode.ENTER || event.keyCode === 13) {
                event.preventDefault();
                $(event.currentTarget).trigger('change')
                const pages = document.getElementsByClassName('s_sp_data_page')
                var page_value = parseInt(pages[0].value)
                const current_page = document.getElementById('current_page')
                pages[0].value = 1
                current_page ? $(current_page).html('1') : null
            }
        },
        _onInputFocusout_search: function (event) {
            event.preventDefault();
            setTimeout(function () {
                const pages = document.getElementsByClassName('s_sp_data_page')
                if (pages.length > 0) {
                    var page_value = parseInt(pages[0].value)
                    const current_page = document.getElementById('current_page')
                    current_page ? $(current_page).html(page_value) : null;
                }
            }, 500);
        },

    });

    var FieldOne2Many = require('web.relational_fields').FieldOne2Many;
    var fieldRegistry = require('web.field_registry');
    var ListRenderer = require('web.ListRenderer');
    var ShopifyFetchData = ListRenderer.extend({
        events: _.extend({}, ListRenderer.prototype.events, {}),
        init: function (parent, state, params) {
            this.record_checked = []
            this.record_checked_data = {}
            this.badges = ['badge-primary', 'badge-warning', 'badge-success', 'badge-danger']
            this._super.apply(this, arguments);
        },
        // Over ride
        _onSortColumn: function (ev) {
            //disable sort on click <th>
            // todo sh@dowalker
            return true;
        },
        /**
         * When editing a row, we want to disable all record selectors.
         *
         * @private
         */
        _renderHeader: function () {
            return '';
        },
        _renderFooter: function () {
            return ''
        },
        _renderBodyCell: function (record, node, index, options) {
            var $cell = this._super.apply(this, arguments);
            if (node.attrs.name === "media_url") {
                $cell.addClass('s_data_img');
            }
            if (node.attrs.name === "name") {
                $cell.addClass('s_data_text');
            }
            return $cell;
        },

        _renderRow: function (record) {
            // if (typeof record != 'undefined') {
            //     var self = this;
            //     var $cells = this.columns.map(function (node, index) {
            //         return self._renderBodyCell(record, node, index, {mode: 'readonly'});
            //     });
            //     var $tr = $('<tr/>', {class: 'o_data_row'})
            //         .attr('data-id', record.data.product_id)
            //         .append($cells);
            //     if (this.hasSelectors) {
            //         $tr.prepend(this._renderSelector('td', !record.res_id));
            //     }
            //     this._setDecorationClasses(record, $tr);
            //     return $tr;
            // }
            var tr = this._super.apply(this, arguments);
            tr.attr('data-id', record.data.product_id);
            return tr;
        },

        s_update_data: function (callback) {
            var self = this;
            _.each(this.state.data, function (record, index) {
                if (self.record_checked.includes(record.data.product_id)) {
                    self.record_checked_data[record.data.product_id] = record.data.data
                } else {
                    if (record.data.product_id in self.record_checked_data) {
                        delete self.record_checked_data[record.data.product_id];
                    }
                }
            })
            callback()
        },

        _onRowClicked: function (ev) {
            // Disable row click open popup record
            //todo Sh@dowalker
            const table = $(ev.currentTarget).closest('table')
            var table_empty = false
            table ? table_empty = table[0].classList.value.includes('o_empty_list') : false
            if (!table_empty) {
                const s_data_badge = document.getElementById('s_data_badge')
                var id = $(ev.currentTarget).data('id');
                if (typeof id != "undefined") {
                    id = id.toString()
                }
                var text = '';
                if (ev.currentTarget.lastChild.textContent.length > 49) {
                    text = ev.currentTarget.lastChild.textContent.substring(0, 49) + '...'
                } else {
                    text = ev.currentTarget.lastChild.textContent
                }
                var checked = false
                var mode = null
                if (this.state.data.length > 0) {
                    mode = this.state.data[0].data['mode']
                }
                var self = this;
                if (typeof mode != "undefined" && mode == 'multiple' && typeof id != "undefined") {
                    ev.currentTarget.firstChild.firstChild.firstChild != null ? checked = ev.currentTarget.firstChild.firstChild.firstChild.checked : false
                    ev.currentTarget.firstChild.firstChild.firstChild != null ? $(ev.currentTarget.firstChild.firstChild.firstChild).prop("checked", !checked) : false;
                    if (!checked && !this.record_checked.includes(id)) {
                        this.record_checked.push(id)
                        var $span = $('<div>', {
                            'class': 's_badge ' + this.badges[Math.floor(Math.random() * 4)] + ' s_badge_pill',
                            'id': id
                        });
                        $span.text(text);
                        s_data_badge ? $(s_data_badge).append($span) : false
                    }
                    if (checked) {
                        const index = this.record_checked.indexOf(id);
                        if (index > -1) {
                            this.record_checked.splice(index, 1);
                        }
                        const remove_elm = document.getElementById(id)
                        remove_elm ? $(remove_elm).remove() : false
                    }
                    this.s_update_data(function () {
                        const check_input = document.getElementsByClassName('s_record_checked')
                        if (check_input.length > 0) {
                            $(check_input[0]).focus()
                            check_input[0].value = JSON.stringify(self.record_checked_data)
                            $(check_input[0]).trigger('change')
                        }
                    })

                }
                if (typeof mode != "undefined" && mode == 'single' && typeof id != "undefined") {
                    ev.currentTarget.firstChild.firstChild.firstChild != null ? checked = ev.currentTarget.firstChild.firstChild.firstChild.checked : false
                    if (this.record_checked.length == 0) {
                        ev.currentTarget.firstChild.firstChild.firstChild != null ? $(ev.currentTarget.firstChild.firstChild.firstChild).prop("checked", !checked) : false;
                        if (!checked && !this.record_checked.includes(id)) {
                            this.record_checked.push(id)
                            var $span = $('<span>', {
                                'class': 's_badge ' + this.badges[Math.floor(Math.random() * 4)] + ' s_badge_pill',
                                'id': id
                            });
                            $span.text(text);
                            s_data_badge ? $(s_data_badge).append($span) : false
                        }

                        _.each(this.state.data, function (record) {
                            if (self.record_checked.includes(record.data.product_id)) {
                                self.record_checked_data[record.data.product_id] = record.data.data
                            }
                        })
                        const check_input = document.getElementsByClassName('s_record_checked')
                        if (check_input.length > 0) {
                            $(check_input[0]).focus()
                            check_input[0].value = JSON.stringify(this.record_checked_data)
                            $(check_input[0]).trigger('change')
                        }
                    } else {
                        if (this.record_checked.includes(id)) {
                            ev.currentTarget.firstChild.firstChild.firstChild != null ? $(ev.currentTarget.firstChild.firstChild.firstChild).prop("checked", !checked) : false;
                            const index = this.record_checked.indexOf(id);
                            if (index > -1) {
                                this.record_checked.splice(index, 1);
                            }
                            const remove_elm = document.getElementById(id)
                            remove_elm ? $(remove_elm).remove() : false
                            self.record_checked_data = {}
                        }
                        const check_input = document.getElementsByClassName('s_record_checked')
                        if (check_input.length > 0) {
                            $(check_input[0]).focus()
                            check_input[0].value = JSON.stringify(this.record_checked_data)
                            $(check_input[0]).trigger('change')
                        }

                    }

                }

            }
            // this._super.apply(this, arguments);
        },

    });

    var ShopifyOMSChannels = ListRenderer.extend({
        events: _.extend({}, ListRenderer.prototype.events, {}),
        init: function (parent, state, params) {
            this._super.apply(this, arguments);
        },
        // Over ride
        _onSortColumn: function (ev) {
            //disable sort on click <th>
            // todo sh@dowalker
            return true;
        },
        /**
         * When editing a row, we want to disable all record selectors.
         *
         * @private
         */
        _renderFooter: function () {
            return ''
        },

        _renderHeaderCell: function (node) {
            const $th = this._super.apply(this, arguments);
            var name = node.attrs.name;
            var field = this.state.fields[name];
            if(field.type === 'integer' || field.type === 'float' || field.type === 'monetary'){
                 $th.addClass("s_o_list_center");
            }
            return $th;
        },

        _renderBodyCell: function (record, node, index, options) {
            var $cell = this._super.apply(this, arguments);
            if (node.attrs.widget === "image_url") {
                $cell.addClass('s_data_img');
            }
            var name = node.attrs.name;
            var field = this.state.fields[name];
            if(field.type === 'integer' || field.type === 'float' || field.type === 'monetary'){
                $cell.addClass('s_o_list_center');
            }
            return $cell;
        },
    });


    var ShopifyFetchDataWidget = FieldOne2Many.extend({
        /**
         * We want to use our custom renderer for the list.
         *
         * @override
         */
        _getRenderer: function () {
            if (this.view.arch.tag === 'tree') {
                return ShopifyFetchData;
            }
            return this._super.apply(this, arguments);
        },
    });

    var ListView = require('web.ListView');
    var viewRegistry = require('web.view_registry');

    var ShopifyOMSChannelsWidget = ListView.extend({
        config: _.extend({}, ListView.prototype.config, {
            Renderer: ShopifyOMSChannels,
        }),

        init: function (viewInfo, params) {
            this._super.apply(this, arguments);
        }
    });

    fieldRegistry.add('s_data_preview_one2many', ShopifyFetchDataWidget);
    viewRegistry.add('s_oms_tree', ShopifyOMSChannelsWidget);


    return {
        Pagination: Pagination,
        DataDialog: DataDialog,
        ShopifyFetchDataWidget: ShopifyFetchDataWidget
    };

});

