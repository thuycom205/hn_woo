# -*- coding: utf-8 -*-
{
    'name': "s_base",

    'summary': """
        Short (1 phrase/line) summary of the module's purpose, used as
        subtitle on modules listing or apps.openerp.com""",

    'description': """
        Long description of module's purpose
    """,

    'author': "Magenest",
    'website': "http://www.yourcompany.com",

    # Categories can be used to filter modules in modules listing
    # Check https://github.com/odoo/odoo/blob/13.0/odoo/addons/base/data/ir_module_category_data.xml
    # for the full list
    'category': 'Uncategorized',
    'version': '0.1',

    # any module necessary for this one to work correctly
    'depends': ['base', 'mail','sale','web'],

    # always loaded
    'data': [
        'security/ir.model.access.csv',
        'data/base_data.xml',
        'data/web_hook_data.xml',
        # 'data/customer_io_create_customer_cron.xml',
        'views/views.xml',
        'views/client_theme.xml',
        'views/increase_auto_search_limit.xml',
        'views/show_all_tour.xml',
        # 'views/force_form_edit.xml',
        'views/force_loading.xml',
        'views/force_hide_filter_group_by.xml',
        'views/s_data_preview.xml',
        'views/ir_module_module_views.xml',
        'views/af_related_apps_template.xml',
    ],
    "qweb": [
        "static/src/xml/*.xml",
    ],
}
