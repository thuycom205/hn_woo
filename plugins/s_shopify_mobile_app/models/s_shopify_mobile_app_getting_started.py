from odoo import fields, models


class MobileAppGettingStarted(models.TransientModel):
    _name = 's.shopify.mobile.app.getting.started'
    _rec_name = 'name'
    _description = 'Getting Started'
    name = fields.Char(default='Getting Started')

