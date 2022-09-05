from odoo import fields, models


class CustomSetting(models.Model):
    _name = 's.shopify.mobile.app.custom.setting'
    _description = "Custom Setting"
    _rec_name = 'name'
    #
    sequence = fields.Integer(string="Sequence")
    name = fields.Char(string="Name")
    url = fields.Char(string='URL')
    title = fields.Char(string='Title')
    custom_setting_id = fields.Many2one('s.shopify.mobile.app.custom.design')
    # s_sp_app_id = fields.Many2one('s.sp.app', related='custom_setting_id.s_sp_app_id')
