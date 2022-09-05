from odoo import fields, models


class MobileAppIcon(models.Model):
    _name = 's.shopify.mobile.app.icon'
    _description = "Icon"

    name = fields.Char("Name")
    menu_type_id = fields.Many2one('s.shopify.mobile.app.menu.type', string="Menu Type")
    icon_img = fields.Binary()
    svg_img = fields.Char("Svg Image")

