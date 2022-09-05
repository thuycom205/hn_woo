# -*- coding: utf-8 -*-

from odoo import api, fields, models
import base64
import io
import logging
import pyotp
import pyqrcode
import png

_logger = logging.getLogger(__name__)


class MobileAppLinkAccessToken(models.TransientModel):
    _name = 'mobile.app.link.access.token'

    custom_design_id = fields.Many2one('s.shopify.mobile.app.custom.design')

    link_access = fields.Text(string="Link Access", readonly=True, compute="_get_link_access_token")
    otp_qrcode = fields.Binary(compute="_compute_otp_qrcode")
    user_note_gg_account = fields.Text("Note")
    user_note_allfetch_account = fields.Text("Note")

    @api.model
    def create_qr_code(self, uri):
        buffer = io.BytesIO()
        qr = pyqrcode.create(uri)
        qr.png(buffer, scale=3)
        return base64.b64encode(buffer.getvalue()).decode()

    @api.depends('link_access')
    def _compute_otp_qrcode(self):
        for record in self:
            record.otp_qrcode = record.create_qr_code(record.link_access)

    @api.depends('custom_design_id')
    def _get_link_access_token(self):
        access_token = self.custom_design_id.sudo().access_token
        # current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
        # base_url = current_app.sudo().base_url
        link_access = 'https://mobile.allfetch.com' + "/" + str(access_token)
        self.link_access = link_access

        return link_access

    def create_shop_gg_account(self):
        for rec in self:
            if rec.user_note_gg_account is not False:
                vals = {
                    "user_note_gg_account": "User submit GG Account: " + str(rec.user_note_gg_account),
                    "user_note_allfetch_account": "",
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            else:
                vals = {
                    "user_note_gg_account": "User submit GG Account",
                    "user_note_allfetch_account": "",
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            self.env['s.shopify.mobile.app.allfetch.submit'].create(vals)

    def create_shop_allfetch_account(self):
        for rec in self:
            if rec.user_note_allfetch_account is not False:
                vals = {
                    "user_note_gg_account": "",
                    "user_note_allfetch_account": "User submit Allfetch Account: " + str(rec.user_note_allfetch_account),
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            else:
                vals = {
                    "user_note_gg_account": "",
                    "user_note_allfetch_account": "User submit Allfetch Account",
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            self.env['s.shopify.mobile.app.allfetch.submit'].create(vals)
