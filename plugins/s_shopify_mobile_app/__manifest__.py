# -*- coding: utf-8 -*-
{
    'name': "Magenest Shopify Mobile APP",

    'summary': """
        Short (1 phrase/line) summary of the module's purpose, used as
        subtitle on modules listing or apps.openerp.com""",

    'description': """
        Long description of module's purpose
    """,

    'author': "My Company",
    'website': "http://www.yourcompany.com",

    # Categories can be used to filter modules in modules listing
    # Check https://github.com/odoo/odoo/blob/13.0/odoo/addons/base/data/ir_module_category_data.xml
    # for the full list
    'category': 'Uncategorized',
    'version': '0.1',

    # any module necessary for this one to work correctly
    'depends': ['base', 's_base'],

    # always loaded
    'data': [
        'data/app_data.xml',
        'data/group_data.xml',
        'data/plan_data.xml',
        'security/ir.model.access.csv',
        'wizards/mobile_app_link_access_token.xml',
        'wizards/mobile_app_publish_notify.xml',
        'views/s_shopify_mobile_app_store_listing.xml',
        'views/s_shopify_mobile_app_custom_design.xml',
        'views/s_shopify_mobile_app_notification.xml',
        'views/s_shopify_mobile_app_plan.xml',
        'views/s_shopify_mobile_keywords.xml',
        'views/onboarding_lib.xml',
        'views/s_shopify_mobile_app_notification_log_view.xml',
        'views/s_shopify_mobile_app_allfetch_submit.xml',
        'views/s_shopify_mobile_app_getting_started.xml',
        'views/s_shopify_mobile_about.xml',
        'views/s_shopify_mobile_app_preview_app.xml',
        'views/s_shopify_mobile_app_publish_process.xml',
    ],
    # only loaded in demonstration mode
    'demo': [
        'demo/demo.xml',
    ],
}
