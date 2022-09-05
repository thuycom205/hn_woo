from odoo import fields, models, api


class SGGMerchant(models.Model):
    _name = 's.gg.merchant'
    _description = 'Description'
    _rec_name = 'name'

    name = fields.Char()
    s_sp_app_id = fields.Many2one('s.sp.app')
    s_gg_account_id = fields.Many2one('s.gg.account')