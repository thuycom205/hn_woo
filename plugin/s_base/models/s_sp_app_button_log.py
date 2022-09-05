from odoo import fields, models, api


class SSpAppButtonLog(models.Model):
    _name = 's.sp.app.button.log'
    _description = 'Log button'

    name = fields.Char()
    s_sp_app_id = fields.Many2one('s.sp.app')
    date_time = fields.Datetime()
    user_id = fields.Many2one('res.users')
    locked = fields.Boolean(default=False)