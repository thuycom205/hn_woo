# -*- coding: utf-8 -*-

from odoo import models, fields


class SSpPlan(models.Model):
    _name = 's.plan'
    _rec_name = 'sp_name'

    s_app_id = fields.Many2one('s.app')
    sp_name = fields.Char()
    sp_price = fields.Float()
    default_setting = fields.Char()
    customer_io_plan_name = fields.Char()
