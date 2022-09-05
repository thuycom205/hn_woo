# -*- coding: utf-8 -*-

from odoo import models, fields


class SApp(models.Model):
    _inherit = 's.app'
    _description = 'Shopify App'
    _rec_name = 'name'

    preview_andoid_app_name = fields.Char()
    preview_ios_app_name = fields.Char()
    preview_app_firebase_server_key = fields.Char()
