from odoo import fields, models


class MobileAppMenuList(models.Model):
    _name = 's.shopify.mobile.app.menu.list'
    _description = "MenuList"
    _rec_name = 'name'

    sequence = fields.Integer(string="Sequence")
    custom_design_id = fields.Many2one('s.shopify.mobile.app.custom.design')
    menu_type_id = fields.Many2one('s.shopify.mobile.app.menu.type', string="Menu Type")
    icon_id = fields.Many2one('s.shopify.mobile.app.icon', string="Icon")
    icon_img = fields.Binary(related="icon_id.icon_img")
    svg_img = fields.Char(related="icon_id.svg_img")
    title = fields.Char(string="Title")
    url = fields.Char(string="URL")
    name = fields.Char(string="Name")
