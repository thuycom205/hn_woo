from odoo import fields, models


class MobileAppMenuType(models.Model):
    _name = 's.shopify.mobile.app.menu.type'
    _description = "MenuType"
    _rec_name = 'menu_type'

    menu_type = fields.Char("Menu Type")
    icon_ids = fields.One2many("s.shopify.mobile.app.icon", "menu_type_id")

