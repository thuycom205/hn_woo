from odoo import fields, models, api
import base64
import io
import logging
import pyotp
import pyqrcode
import png

_logger = logging.getLogger(__name__)


class SShopifyMobileAppPreviewApp(models.Model):
    _name = 's.shopify.mobile.app.preview.app'
    # _description = 'Preview'

    name = fields.Char(default="Preview App")
    s_sp_shop_id = fields.Many2one('s.sp.shop')
    s_sp_app_id = fields.Many2one('s.sp.app')

    custom_design_id = fields.Many2one('s.shopify.mobile.app.custom.design', compute='_get_custom_design_shop_id')
    link_access = fields.Text(string="Link Access", readonly=True, compute="_get_link_access_token")
    otp_qrcode = fields.Binary(compute="_compute_otp_qrcode")
    user_note_gg_account = fields.Text("Note")
    user_note_allfetch_account = fields.Text("Note")

    def _get_custom_design_shop_id(self):
        current_shop_id = self.env.user.sp_shop_id.id
        custom_design_shop_id = self.env['s.shopify.mobile.app.custom.design'].sudo().search([('s_sp_shop_id', '=', current_shop_id)])
        if custom_design_shop_id:
            self.custom_design_id = custom_design_shop_id.id
        else:
            self.custom_design_id = None

    @api.model
    def _open_preview_app(self):
        current_shop_id = self.env.user.sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)],
            limit=1).id
        view_id = self.env.ref('s_shopify_mobile_app.open_s_shopify_mobile_app_preview_app').id

        if self.user_has_groups('base.group_system'):
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'tree,form',
                'views': [[False, "tree"], [view_id, "form"]],
                'view_id': False,
                'res_model': 's.shopify.mobile.app.preview.app',
            }
        elif current_shop_id:
            rec_exist = self.env['s.shopify.mobile.app.preview.app'].sudo().search([('s_sp_shop_id', '=', current_shop_id)], limit=1)
            if rec_exist:
                res_id = rec_exist.id
            else:
                record = self.env['s.shopify.mobile.app.preview.app'].sudo().create({
                    's_sp_shop_id': current_shop_id,
                    'name': "Preview App",
                    's_sp_app_id': s_sp_app_id,
                })
                res_id = record.id
            return {
                'name': 'Preview App',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                # 'views': [(view_id, 'form')],
                'res_id': res_id,
                'view_type': 'form',
                'res_model': 's.shopify.mobile.app.preview.app',
                'context': {
                    'active_id': res_id,
                    'active_model': 's.shopify.mobile.app.preview.app',
                    'create': False
                },
            }

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
        link_access = 'https://mobile.allfetch.com' + "/" + str(access_token)
        self.link_access = link_access

        return link_access

    def create_shop_gg_account(self):
        for rec in self:
            if rec.user_note_gg_account is not False:
                vals = {
                    "user_note_gg_account": "User submit GG Account: " + str(rec.user_note_gg_account),
                    "user_note_allfetch_account": "",
                    "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            else:
                vals = {
                    "user_note_gg_account": "User submit GG Account",
                    "user_note_allfetch_account": "",
                    "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
                    "allfetch_submit_id": rec.custom_design_id.id,
                    "shop_email": rec.sudo().custom_design_id.s_sp_shop_id.email
                }
            self.env['s.shopify.mobile.app.allfetch.submit'].create(vals)

    def create_shop_allfetch_account(self):
        for rec in self:
            if rec.user_note_allfetch_account is not False:
                vals = {
                    "user_note_gg_account": "",
                    "user_note_allfetch_account": "User submit Allfetch Account: " + str(
                        rec.user_note_allfetch_account),
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

    def open_customize_bar_form(self):
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        if current_shop_id:
            customize_record_exist = self.sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)], limit=1)
            if customize_record_exist:
                res_id = customize_record_exist.sudo().id
            else:
                record = self.sudo().create({'name': 'Customization'})
                res_id = record.id
            view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_dashboard_form_2').id
            return {
                # 'name': 'Customization',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'views': [(view_id, 'form')],
                'view_id': view_id,
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'target': 'main',
                'context': {
                    'form_view_initial_mode': 'edit'
                },
            }
