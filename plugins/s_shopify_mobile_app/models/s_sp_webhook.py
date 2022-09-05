from odoo import models


class SSpWebHook(models.Model):
    _inherit = 's.sp.web.hook'

    def shopify_web_hook_app_uninstalled(self, app, shop, object_name, action, data):
        if app == 's_shopify_mobile_app':
            group = self.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
            current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
            current_user = self.env['res.users'].sudo().search([('login', '=', shop.base_url)], limit=1)
            if group and current_user and current_app:
                if current_user.id in group.sudo().users.ids:
                    group.sudo().users = [(3, current_user.id)]
                shop_app_info = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
                    [('s_sp_shop_id', '=', current_user.sp_shop_id.id)], limit=1)
                if shop_app_info:
                    shop_app_info.is_installed = False

            # update install_status s.sp.app
            if current_app and current_user.sp_shop_id:
                current_shop_app = self.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_user.sp_shop_id.id), ('s_app_id', '=', current_app.id)], limit=1)
                if current_shop_app:
                    current_shop_app.write({
                        'install_status': False,
                        'web_hook_ids': [(5, 0, 0)],
                        'webhook_data': ''
                    })
        return super(SSpWebHook, self).shopify_web_hook_app_uninstalled(app=app, shop=shop, object_name=object_name,
                                                                        action=action, data=data)
