# -*- coding: utf-8 -*-

from odoo import models, fields, api


class ResUsers(models.Model):
    _inherit = 'res.users'

    is_client = fields.Boolean(default=True)
    sp_shop_id = fields.Many2one('s.sp.shop')

    @api.model
    def get_not_install_app(self):
        menu_template = """<a class="dropdown-item s_o_app" href="s_app_href" target="_blank"><div class="o-app-icon-download-wrap"><img class="o-app-icon-download" src="/s_base/static/src/img/download.png"></img></div><img class="o-app-icon" src="data:image/png;base64,s_app_image"/><span class="o-app-name">s_app_name</span></a>"""
        result = ""
        all_apps = self.env['s.app'].sudo().search([('fake_shopify_always_hide', '=', False)])
        current_user_shop_app = self.env.user.sp_shop_id.s_sp_app_ids
        current_user_app_ids = []
        for e in current_user_shop_app:
            current_user_app_ids.append(e.s_app_id.id)
        for e in all_apps:
            if e.id not in current_user_app_ids:
                if e.fake_shopify_app_name:
                    result_item = menu_template.replace('s_app_name', e.fake_shopify_app_name)
                else:
                    result_item = menu_template.replace('s_app_name', 'fake_shopify_app_name')
                if e.fake_shopify_url:
                    result_item = result_item.replace('s_app_href', e.fake_shopify_url)
                if e.fake_icon:
                    result_item = result_item.replace('s_app_image', e.fake_icon.decode("utf-8"))
                result += result_item
        return result
