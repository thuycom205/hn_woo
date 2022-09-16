# -*- coding: utf-8 -*-

from odoo import models, fields, api
from odoo.modules.module import get_module_resource
import traceback
import shopify
import logging
import datetime
_logger = logging.getLogger(__name__)

# key is name of file on cdn

SCRIPT_FILE = {
    's_shopify_bought_together': {
        'source': 'static/src/js',
        'file': 's_shopify_bought_together_recommend_product_detail.js',
        'key': 'assets/af-bought-together-front.js'
    },
    's_shopify_bundle': {
        'source': 'static/src/js/s_shop_storefront',
        'file': 'af-bundle-storefront.js',
        'key': 'assets/af-bundle-front.js'
    },
    's_shopify_mobile_app': {
        'source': 'static/src/js',
        'file': 'mobile.js',
        'key': 'assets/af-mobile-front.js'
    },
    's_shopify_sticky_add_to_cart': {
        'source': 'static/src/js',
        'file': 'sticky_add_to_cart.js',
        'key': 'assets/af-sticky-cart-front.js'
    },
    's_shopify_tiktok': {
        'source': 'static/src/js',
        'file': 'af_tiktok_script.js',
        'key': 'assets/af-tiktok-front.js'
    },
    's_shopify_whatsapp': {
        'source': 'static/src/js/basic_app_wsap_chat_shopify_show',
        'file': 'wsap_chat_shopify_chat.js',
        'key': 'assets/af-whatsapp-front.js'
    },
}

CDN_SHOP = 'luuthuy205.myshopify.com'
CDN_SHOP_TOKEN = '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'
CDN_SHOP_CLIENT_KEY = '9cb39e0f9916c0168cad9e2ad5eda1e3'
CDN_SHOP_SECRET_KEY = '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'
CDN_SHOP_THEME_ID = '101426561190'

class SApp(models.Model):
    _name = 's.app'
    _description = 'Shopify App'
    _rec_name = 'name'

    name = fields.Char(index=True)
    sp_api_key = fields.Char()
    sp_api_secret_key = fields.Char()
    sp_api_version = fields.Char()
    gg_api_client_id = fields.Char()
    gg_api_client_secret = fields.Char()
    base_url = fields.Char()
    webhook_base_url = fields.Char()
    default_menu = fields.Many2one('ir.ui.menu')

    gg_scope = fields.Char()
    gg_service = fields.Char()
    gg_api_version = fields.Char()
    gg_from_url = fields.Char()

    sp_env = fields.Selection([('sandbox', 'Sandbox'), ('production', 'Production')], default='production')

    ###customerIO
    customer_io_site_id = fields.Char("CustomerIO site ID")
    customer_io_api_key = fields.Char("CustomerIO API key")

    # fake image
    fake_shopify_always_hide = fields.Boolean()
    fake_shopify_url = fields.Char()
    fake_shopify_app_name = fields.Char(default='fake_shopify_app_name')
    fake_icon = fields.Binary(string='Web Icon Image', attachment=True)
    cdn_script_tag = fields.Char(string='CDN Script Tag')
    cdn_script_tag_status = fields.Char(string='CDN Script Tag Status')

    web_hook_ids = fields.Many2many('s.sp.web.hook')
    notifications = fields.One2many('s.app.notifications', 'app_id')

    # script version
    script_version = fields.Integer(default=2021)

    #for dev environment
    base_url_dev = fields.Char()
    sp_api_key_dev = fields.Char()
    sp_api_secret_key_dev = fields.Char()



    def get_module_name(self):
        xml_ids = models.Model._get_external_ids(self)
        for model in self:
            module_names = [xml_id.split('.')[0] for xml_id in xml_ids[model.id]]
            if len(module_names) > 0:
                module_name = module_names[0]
                return module_name
        return False

    # def change_cdn_script_tag(self):
    #     try:
    #         config_parameter = self.env['ir.config_parameter'].sudo().get_param('s_base.update_cdn_script')
    #         if config_parameter:
    #             module_name = self.get_module_name()
    #             content = open(
    #                 get_module_resource(module_name, SCRIPT_FILE[module_name]['source'], SCRIPT_FILE[module_name]['file']),
    #                 'rb').read().decode('utf-8')
    #             try:
    #                 if module_name:
    #                     module_name = str(module_name)
    #                     shopify.Session.setup(
    #                         api_key=CDN_SHOP_CLIENT_KEY,
    #                         secret=CDN_SHOP_SECRET_KEY)
    #                     shopify_session = shopify.Session(CDN_SHOP, version='2020-10', token=CDN_SHOP_TOKEN)
    #                     shopify.ShopifyResource.activate_session(shopify_session)
    #                     filters = {
    #                         'theme_id ': int(CDN_SHOP_THEME_ID),
    #                         'key': SCRIPT_FILE[module_name]['key']
    #                     }
    #                     asset = shopify.Asset.find(filters['key'], theme_id=filters['theme_id'])
    #                     if asset:
    #                         asset.attributes.update({
    #                             'value': content
    #                         })
    #                         asset.save()
    #                         self.cdn_script_tag = asset.attributes.get('public_url')
    #                         self.cdn_script_tag_status = 'Success Update!'
    #                         # Update script status
    #                         old_scripts = self.env['s.sp.app'].search([('install_status', '=', True), ('has_change_script', '=', True), ('s_app_id', '=', self.id)])
    #                         old_scripts.write({
    #                             'has_change_script': False
    #                         })
    #                         return
    #             except Exception as e:
    #                 assets = shopify.Asset.create({
    #                     'theme_id': int(CDN_SHOP_THEME_ID),
    #                     'key': SCRIPT_FILE[module_name]['key'],
    #                     'value': content
    #                 })
    #             self.cdn_script_tag = assets.attributes.get('public_url')
    #             self.cdn_script_tag_status = 'Success Create!'
    #             shopify.ShopifyResource.clear_session()
    #             return
    #     except Exception as e:
    #         self.cdn_script_tag_status = traceback.format_exc()
    #         _logger.error(traceback.format_exc())
    #         shopify.ShopifyResource.clear_session()
    #     return False

    def change_cdn_script_tag(self):
        try:
            config_parameter = self.env['ir.config_parameter'].sudo().get_param('s_base.update_cdn_script')
            if config_parameter and self.base_url:
                base_url = self.base_url
                # script_version = self.script_version + 1
                timestamp = str(datetime.datetime.utcnow().timestamp())
                module_name = self.get_module_name()
                module_name = str(module_name)
                cdn_script_tag = base_url + '/' + module_name + '/' + SCRIPT_FILE[module_name]['source'] + '/' + SCRIPT_FILE[module_name]['file']
                cdn_script_tag = cdn_script_tag + '?v=' + timestamp
                # Update script status
                old_scripts = self.env['s.sp.app'].sudo().search([('install_status', '=', True), ('has_change_script', '=', True), ('s_app_id', '=', self.id)])
                old_scripts.sudo().write({
                    'has_change_script': False
                })

                self.cdn_script_tag = cdn_script_tag
                self.cdn_script_tag_status = 'Success Update! ' + module_name
                return True
        except Exception as e:
            self.cdn_script_tag_status = traceback.format_exc()
            _logger.error(traceback.format_exc())
        return False


class SAppNotifications(models.Model):
    _name = 's.app.notifications'
    _order = "priority desc"

    name = fields.Char('Title')
    content = fields.Html('Content')
    app_id = fields.Many2one('s.app')
    active = fields.Boolean(default=True)
    is_public = fields.Boolean(default=False)
    priority = fields.Integer()

