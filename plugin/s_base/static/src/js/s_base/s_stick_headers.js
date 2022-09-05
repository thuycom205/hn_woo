odoo.define('s_base.stick_header', function (require) {
    'use strict';
    var ListView = require('web.ListRenderer');


    ListView.include({

        s_stick_header: function () {
            var self = this
            var o_content_area = $(".o_content")[0];
            self.$el.find(".table.o_list_table").each(function () {
                $(this).stickyTableHeaders('destroy')
                $(this).stickyTableHeaders({scrollableArea: $(this), fixedOffset: 0.1});
            });
        },

        _freezeColumnWidths: function () {
            if (this.getParent().$el.hasClass("o_field_one2many") !== false || this.getParent().$el.hasClass("o_field_many2many") !== false) {
                this._super.apply(this, arguments);
            } else {
                var self = this;
                self.s_stick_header()

                // const table = this.el.getElementsByTagName('table')[0];
                function fix_body(position) {
                    $("body").css({
                        'position': position,
                    });
                }

                if (this.$el.parents('.o_field_one2many').length === 0) {
                    self.s_stick_header();
                    fix_body("fixed");
                    $(window).unbind('resize', self.s_stick_header()).bind('resize', self.s_stick_header());
                    this.$el.css("overflow-x", "visible");
                } else {
                    fix_body("relative");
                }
                $("div[class='o_sub_menu']").css("z-index", 4);
            }
        },

        _onCellClick: function (event) {
            // The special_click property explicitely allow events to bubble all
            // the way up to bootstrap's level rather than being stopped earlier.
            var $td = $(event.currentTarget);
            var $tr = $td.parent();
            var rowIndex = $tr.index();
            if (!this._isRecordEditable($tr.data('id')) || $(event.target).prop('special_click')) {
                return;
            }
            var fieldIndex = Math.max($tr.find('.o_field_cell').index($td), 0);
            this._selectCell(rowIndex, fieldIndex, {event: event});
        },

        setRowMode: function (recordID, mode) {
            var self = this;
            return this._super.apply(this, arguments).then(function () {
                var editMode = (mode === 'edit');
                var $row = self._getRow(recordID);
                self.currentRow = editMode ? $row.index() : null;
            });
        },

        // _onStartResize: function (ev) {
        //     // Only triggered by left mouse button
        //     if (ev.which !== 1) {
        //         return;
        //     }
        //     ev.preventDefault();
        //     ev.stopPropagation();
        //
        //     this.isResizing = true;
        //
        //     const table = this.el.getElementsByTagName('table')[0];
        //     const th = ev.target.closest('th');
        //     table.style.width = `${table.offsetWidth}px`;
        //     const thPosition = [...th.parentNode.children].indexOf(th);
        //     const resizingColumnElements = [...table.getElementsByTagName('tr')]
        //         .filter(tr => tr.children.length === th.parentNode.children.length)
        //         .map(tr => tr.children[thPosition]);
        //     const optionalDropdown = this.el.getElementsByClassName('o_optional_columns')[0];
        //     const initialX = ev.pageX;
        //     const initialWidth = th.offsetWidth;
        //     const initialTableWidth = table.offsetWidth;
        //     const initialDropdownX = optionalDropdown ? optionalDropdown.offsetLeft : null;
        //     const resizeStoppingEvents = [
        //         'keydown',
        //         'mousedown',
        //         'mouseup',
        //     ];
        //
        //     // Apply classes to table and selected column
        //     table.classList.add('o_resizing');
        //     resizingColumnElements.forEach(el => el.classList.add('o_column_resizing'));
        //
        //     // Mousemove event : resize header
        //     const resizeHeader = ev => {
        //         ev.preventDefault();
        //         ev.stopPropagation();
        //         const delta = ev.pageX - initialX;
        //         const newWidth = Math.max(10, initialWidth + delta);
        //         const tableDelta = newWidth - initialWidth;
        //         th.style.width = `${newWidth}px`;
        //         table.style.width = `${initialTableWidth + tableDelta}px`;
        //         if (optionalDropdown) {
        //             optionalDropdown.style.left = `${initialDropdownX + tableDelta}px`;
        //         }
        //         // start logan update header after resize column
        //         $(table).stickyTableHeaders('destroy')
        //         $(table).stickyTableHeaders({scrollableArea: $(table), fixedOffset: 0.1});
        //         // end logan update header after resize column
        //     };
        //     this._addEventListener('mousemove', window, resizeHeader);
        //
        //     // Mouse or keyboard events : stop resize
        //     const stopResize = ev => {
        //         // Ignores the initial 'left mouse button down' event in order
        //         // to not instantly remove the listener
        //         if (ev.type === 'mousedown' && ev.which === 1) {
        //             return;
        //         }
        //         ev.preventDefault();
        //         ev.stopPropagation();
        //         // We need a small timeout to not trigger a click on column header
        //         clearTimeout(this.resizeTimeout);
        //         this.resizeTimeout = setTimeout(() => {
        //             this.isResizing = false;
        //         }, 100);
        //         window.removeEventListener('mousemove', resizeHeader);
        //         table.classList.remove('o_resizing');
        //         resizingColumnElements.forEach(el => el.classList.remove('o_column_resizing'));
        //         resizeStoppingEvents.forEach(stoppingEvent => {
        //             window.removeEventListener(stoppingEvent, stopResize);
        //         });
        //
        //         // we remove the focus to make sure that the there is no focus inside
        //         // the tr.  If that is the case, there is some css to darken the whole
        //         // thead, and it looks quite weird with the small css hover effect.
        //         document.activeElement.blur();
        //     };
        //     // We have to listen to several events to properly stop the resizing function. Those are:
        //     // - mousedown (e.g. pressing right click)
        //     // - mouseup : logical flow of the resizing feature (drag & drop)
        //     // - keydown : (e.g. pressing 'Alt' + 'Tab' or 'Windows' key)
        //     resizeStoppingEvents.forEach(stoppingEvent => {
        //         this._addEventListener(stoppingEvent, window, stopResize);
        //     });
        // },
    });
});
