odoo.define('s_base.force_form_controller_edit', function (require) {
    "use strict";
    var FormController = require('web.FormController');
    FormController.include({
        init: function (viewInfo, params) {
            this._super.apply(this, arguments);
            //start logan
            this.mode = 'edit';
            //end logan
        },
        willRestore: function () {
            this.mode = 'edit';
        },
        update: function (params, options) {
            var result = this._super(params, options);
            this.mode = 'edit';
            return result;
        },
        _confirmSave: function (id) {
            if (id === this.handle) {
                if (this.mode === 'readonly') {
                    return this.reload();
                } else {
                    // start logan
                    return this._setMode('edit');
                    // end logan
                }
            } else {
                // A subrecord has changed, so update the corresponding relational field
                // i.e. the one whose value is a record with the given id or a list
                // having a record with the given id in its data
                var record = this.model.get(this.handle);

                // Callback function which returns true
                // if a value recursively contains a record with the given id.
                // This will be used to determine the list of fields to reload.
                var containsChangedRecord = function (value) {
                    return _.isObject(value) &&
                        (value.id === id || _.find(value.data, containsChangedRecord));
                };
                var changedFields = _.findKey(record.data, containsChangedRecord);
                return this.renderer.confirmChange(record, record.id, [changedFields]);
            }
        },
        _updateSidebar: function () {
            if (this.sidebar) {
                this.sidebar.do_toggle(this.mode === 'edit');
                // Hide/Show Archive/Unarchive dropdown items
                // We could have toggled the o_hidden class on the
                // item theirselves, but the items are redrawed
                // at each update, based on the initial definition
                var archive_item = _.find(this.sidebar.items.other, function (item) {
                    return item.classname && item.classname.includes('o_sidebar_item_archive')
                })
                var unarchive_item = _.find(this.sidebar.items.other, function (item) {
                    return item.classname && item.classname.includes('o_sidebar_item_unarchive')
                })
                if (archive_item && unarchive_item) {
                    if (this.renderer.state.data.active) {
                        archive_item.classname = 'o_sidebar_item_archive';
                        unarchive_item.classname = 'o_sidebar_item_unarchive o_hidden';
                    } else {
                        archive_item.classname = 'o_sidebar_item_archive o_hidden';
                        unarchive_item.classname = 'o_sidebar_item_unarchive';
                    }
                }
            }
        },
    });
    return FormController
});

odoo.define('s_base.force_form_view_edit', function (require) {
    "use strict";
    var FormView = require('web.FormView');
    FormView.include({
        init: function (viewInfo, params) {
            this._super.apply(this, arguments);
            //start logan
            this.controllerParams.mode = 'edit';
            this.rendererParams.mode = 'edit';
            //end logan
        },
        _extractParamsFromAction: function (action) {
            var params = this._super.apply(this, arguments);
            var inDialog = action.target === 'new';
            var inline = action.target === 'inline';
            var fullscreen = action.target === 'fullscreen';
            params.withControlPanel = !(inDialog || inline);
            params.footerToButtons = inDialog;
            params.hasSearchView = inDialog ? false : params.hasSearchView;
            params.hasSidebar = !inDialog && !inline;
            params.searchMenuTypes = inDialog ? [] : params.searchMenuTypes;
            //start logan
            // if (inDialog || inline || fullscreen) {
            //     params.mode = 'edit';
            // } else if (action.context && action.context.form_view_initial_mode) {
            //     params.mode = action.context.form_view_initial_mode;
            // }
            //start logan
            params.mode = 'edit'
            return params;
        },
    })
    return FormView;
});


odoo.define('s_base.force_form_renderer_edit', function (require) {
    "use strict";
    var FormRendererView = require('web.FormRenderer');
    FormRendererView.include({
        init: function (viewInfo, params) {
            this._super.apply(this, arguments);
            //start logan
            this.mode = 'edit';
            //end logan
        },
        updateState: function (state, params) {
            if (params && 'mode' in params) {
                params['mode'] = 'edit';
            }
            return this._super.apply(this, [state, params]);
        },
    })
    return FormRendererView;
});