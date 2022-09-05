from odoo import fields, models, api


class MobileAppNotificationLog(models.Model):
    _name = 's.shopify.mobile.app.notification.log'
    _description = "Notification log"
    _rec_name = 's_sp_app_id'

    s_sp_app_id = fields.Many2one('s.sp.app')
    user_id = fields.Many2one('res.users')
    response_json = fields.Char()
    success = fields.Integer()
    failure = fields.Integer()
