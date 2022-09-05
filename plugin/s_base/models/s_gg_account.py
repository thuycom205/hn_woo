from odoo import fields, models, api
from odoo import http
import google.oauth2.credentials
import googleapiclient.discovery


class SGGACCOUNT(models.Model):
    _name = 's.gg.account'
    _description = 'Description'
    _rec_name = 'email'

    # name = fields.Char()
    email = fields.Char()
    access_token = fields.Char()
    refresh_token = fields.Char()
    s_sp_app_id = fields.Many2one('s.sp.app')
    s_merchant_ids = fields.One2many('s.gg.merchant', 's_gg_account_id')

    def create_merchant(self):
        merchant_ids = self.sudo().s_sp_app_id.get_merchant_ids(access_token=self.sudo().access_token,
                                                                refresh_token=self.sudo().refresh_token)
        for merchant in merchant_ids:
            if 'merchantId' in merchant:
                name = merchant['merchantId']
                existed_merchant = self.env['s.gg.merchant'].sudo().search([('name', '=', name), ('s_sp_app_id', '=', self.sudo().s_sp_app_id.id), ('s_gg_account_id', '=', self.sudo().id)])
                if len(existed_merchant) == 0:
                    self.env['s.gg.merchant'].sudo().create({
                        'name': name,
                        's_sp_app_id': self.sudo().s_sp_app_id.id,
                        's_gg_account_id': self.sudo().id,
                    })

    def get_credential(self):
        # TODO check if none raise error
        credential = {
            'token': self.access_token,
            'refresh_token': self.refresh_token,
            'token_uri': 'https://oauth2.googleapis.com/token',
            'client_id': self.sudo().s_sp_app_id.s_app_id.gg_api_client_id,
            'client_secret': self.sudo().s_sp_app_id.s_app_id.gg_api_client_secret,
            'scopes': ['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/content']
        }
        return credential

    def prepare_credentials(self, cron=False):
        if cron:
            credential = self.get_credential()
            credentials = google.oauth2.credentials.Credentials(**credential)
            return credentials
        else:
            if 'credentials' not in http.request.httprequest.session:
                credential = self.get_credential()
                credentials = google.oauth2.credentials.Credentials(**credential)
            else:
                credentials = google.oauth2.credentials.Credentials(
                    **http.request.httprequest.session.credentials)
        return credentials
