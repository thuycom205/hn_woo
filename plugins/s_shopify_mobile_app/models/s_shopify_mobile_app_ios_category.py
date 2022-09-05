from odoo import fields, models


class MobileAppIosCategory(models.Model):
    _name = 's.shopify.mobile.app.ios.category'
    _description = "Ios Category"
    _rec_name = 'name'

    name = fields.Char(string="Name")
