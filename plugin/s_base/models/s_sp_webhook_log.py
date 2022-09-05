from odoo import models, fields


class SSpWebHooklog(models.Model):
    _name = 's.sp.web.hook.log'
    _rec_name = 'shop_id'
    _order = 'id desc'

    shop_id = fields.Many2one('s.sp.shop')
    object_name = fields.Char()
    action = fields.Char()
    data = fields.Text()
