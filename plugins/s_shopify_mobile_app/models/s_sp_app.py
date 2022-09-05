from odoo import fields, models, api
import shopify
import traceback
import logging

_logger = logging.getLogger(__name__)


class SSpApp(models.Model):
    _inherit = 's.sp.app'

    def _get_default_mobile_app_ios_name(self):
        current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app', raise_if_not_found=False)
        if current_app:
            return current_app.sudo().preview_ios_app_name
        return ''

    def _get_default_mobile_app_android_name(self):
        current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app', raise_if_not_found=False)
        if current_app:
            return current_app.sudo().preview_andoid_app_name
        return ''

    def _get_default_mobile_app_firebase_key(self):
        current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app', raise_if_not_found=False)
        if current_app:
            return current_app.sudo().preview_app_firebase_server_key
        return ''

    mobile_app_ios_name = fields.Char(default=_get_default_mobile_app_ios_name)
    mobile_app_android_name = fields.Char(default=_get_default_mobile_app_android_name)
    mobile_app_firebase_key = fields.Char(default=_get_default_mobile_app_firebase_key)
    register_ids = fields.One2many('s.shopify.mobile.app.register.id', 's_sp_app_id')

    mobile_app_shopify_theme_id = fields.Char("Mobile app shopify theme id")
    mobile_app_shopify_theme_graphql_api_id = fields.Char("Mobile app shopify theme id")

    def schedule_check_mobile_app_plan(self):
        app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo().id
        sp_apps = self.env['s.sp.app'].sudo().search([('s_app_id', '=', app_id), ('token', '!=', False)])
        _logger.info('Start checking plan Mobile App Shopify')
        try:
            for sp_app in sp_apps:
                mobile_app_data_group = self.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
                if not mobile_app_data_group:
                    raise Exception('Could not mobile app data group')
                user = sp_app.sp_shop_id.user_id
                if not user:
                    raise Exception('Could not find user')

                session = sp_app.get_shopify_session()
                current_plan = shopify.RecurringApplicationCharge.current()
                if not current_plan:
                    sp_app.s_plan_id = False
                    sp_app.s_charge_id = False
                    if user.id in mobile_app_data_group.sudo().users.ids:
                        mobile_app_data_group.sudo().users = [(3, user.id)]
                else:
                    if not sp_app.s_charge_id or current_plan.id != int(sp_app.s_charge_id):
                        sp_app.s_charge_id = current_plan.id
                    if user.id not in mobile_app_data_group.sudo().users.ids:
                        mobile_app_data_group.sudo().users = [(4, user.id)]
                if session:
                    shopify.ShopifyResource.clear_session()
        except Exception as e:
            _logger.error(traceback.format_exc())
        _logger.info('Stop checking plan Mobile App Shopify')