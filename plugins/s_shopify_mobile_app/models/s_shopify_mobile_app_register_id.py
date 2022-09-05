from odoo import fields, models, api


class SShopifyMobileAppRegisterId(models.Model):
    _name = 's.shopify.mobile.app.register.id'
    _description = 'Register ids'

    name = fields.Char()
    s_sp_app_id = fields.Many2one('s.sp.app')