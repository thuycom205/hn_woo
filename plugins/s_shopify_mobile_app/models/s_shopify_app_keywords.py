from odoo import fields, models


class MobileAppKeywords(models.Model):
    _name = 's.shopify.app.keywords'
    _description = "Keywords"
    _rec_name = 'keywords'

    keywords = fields.Char(string="Keywords", size=100)

    def _get_default_s_sp_app_id(self):
        shop_id = self.env.user.sp_shop_id.id
        app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search([('sp_shop_id', '=', shop_id), ('s_app_id', '=', app_id)],
                                                         limit=1).id
        return s_sp_app_id

    s_sp_app_id = fields.Many2one('s.sp.app', default=_get_default_s_sp_app_id)