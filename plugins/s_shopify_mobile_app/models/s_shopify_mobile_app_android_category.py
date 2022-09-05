from odoo import fields, models


class MobileAppAndroidCategory(models.Model):
    _name = 's.shopify.mobile.app.android.category'
    _description = "Android Category"
    _rec_name = 'name'

    name = fields.Char(string="Name")
