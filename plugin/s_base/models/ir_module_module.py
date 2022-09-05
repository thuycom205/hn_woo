from odoo import fields, models, api


class Module(models.Model):
    _inherit = 'ir.module.module'

    s_shopify_app_name = fields.Char('Shopify App Name')
