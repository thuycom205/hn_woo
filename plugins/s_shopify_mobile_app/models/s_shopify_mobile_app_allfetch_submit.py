from odoo import fields, models


class AllfetchSubmitAccount(models.Model):
    _name = 's.shopify.mobile.app.allfetch.submit'
    _description = "Allfetch Submit Account"
    _rec_name = 'allfetch_submit_id'

    allfetch_submit_id = fields.Many2one('s.shopify.mobile.app.custom.design', string="Allfetch Submit Record")
    s_sp_shop_id = fields.Many2one('s.sp.shop')
    shop_email = fields.Char(string="Shop Email")
    user_note_gg_account = fields.Char(string="User Note GG Account")
    user_note_apple_account = fields.Char(string="User Note apple Account")
    user_note_allfetch_account = fields.Char(string="User Note Allfetch Account")
    # status_submit = fields.Boolean(string="Status Submit")
    apple_status_submit = fields.Selection(string='Apple Submit Status',
                                     selection=[('in_progress', 'In Progress'), ('done', 'Done')],
                                     default='in_progress')
    google_status_submit = fields.Selection(string='Google Submit Status',
                                     selection=[('in_progress', 'In Progress'), ('done', 'Done')],
                                     default='in_progress')
    date_submit = fields.Date(string="Date Submit")
