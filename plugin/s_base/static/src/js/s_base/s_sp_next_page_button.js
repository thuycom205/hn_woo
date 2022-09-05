odoo.define('s.next.page.widget', function (require) {
    "use strict";

    var AbstractField = require('web.AbstractField');
    var core = require('web.core');
    var field_registry = require('web.field_registry');
    var Dialog = require('web.Dialog');

    var QWeb = core.qweb;
    var _t = core._t;

    var NextPage = AbstractField.extend({
        supportedFieldTypes: ['char'],
        events: {
            'click #s_next_page': '_onNextPage',
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
        _onNextPage: function (e) {
            e.preventDefault();
            const navs = $(e.target).closest('.o_form_sheet').find('.o_notebook');
            // const navs = document.getElementsByClassName('s_notebook')
            var nav = null
            navs.length > 0 ? nav = navs[0] : null
            if(nav != null){
                var tabs = nav.firstChild.firstChild
                var next = null
                _.each(tabs.children, function (ev, index) {
                    if ($(ev.children[0]).hasClass('active')){
                        next = tabs.children[index + 1]
                    }
                })
                next ? $(next.children[0]).click() : null
            }
        },

        /**
         * @private
         * @override
         */
        _render: function () {
            this.$el.html(QWeb.render('s_next_page', {}));

        },

        //--------------------------------------------------------------------------
        // Handlers
        //--------------------------------------------------------------------------

    });

    field_registry.add('next_page', NextPage);


    return {
        NextPage: NextPage,
    };

});