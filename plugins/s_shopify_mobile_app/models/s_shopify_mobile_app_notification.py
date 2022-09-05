from odoo import fields, models, api
import shopify
import logging
from random import randint
from datetime import datetime
import json
import time
_logger = logging.getLogger(__name__)
import requests
import pytz


class MobileAppNotification(models.Model):
    _name = 's.shopify.mobile.app.notification'
    _description = "Notification"
    _rec_name = 'title'

    shopify_theme_id = fields.Char("shopify theme id")
    shopify_theme_graphql_notification_api_id = fields.Char("shopify theme id")
    notification_attach_public_url = fields.Char("Notification attach public url")
    notification_img_url = fields.Char()
    title = fields.Char(string='Title', default='')
    message = fields.Text(string='Message', default='')
    attach_product = fields.Binary(string="Attach an image to message(optional)")
    send_date = fields.Datetime(default=datetime.now())
    bool_send_date = fields.Boolean(string="Send at a time")
    status = fields.Selection([
        ('draft', 'Draft'),
        ('scheduled', 'Scheduled'),
        ('delivered', 'Delivered')
    ], default='draft', store=True)
    img_url = fields.Char("Img URL", compute='compute_url_img')

    @api.depends('send_date')
    def _depends_status(self):
        """
        Change status of notification: draft, scheduled, delivered
        """
        self.status = 'draft'
        for rec in self:
            if rec.status == 'draft' and rec.send_date is not False:
                if rec.send_date >= datetime.now():
                    rec.status = 'scheduled'

    def _default_icon_url(self):
        shop_id = self.env.user.sp_shop_id.id
        icon_url = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
            [('s_sp_shop_id', '=', shop_id)],
            limit=1).img_url
        if icon_url:
            return icon_url

    app_icon_url = fields.Char("App Url", default=_default_icon_url)

    def _get_default_s_sp_app_id(self):
        shop_id = self.env.user.sp_shop_id.id
        app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search([('sp_shop_id', '=', shop_id), ('s_app_id', '=', app_id)],
                                                         limit=1).id
        return s_sp_app_id

    s_sp_app_id = fields.Many2one('s.sp.app', default=_get_default_s_sp_app_id)

    def _get_default_s_sp_shop_id(self):
        shop_id = self.env.user.sp_shop_id.id
        return shop_id

    s_sp_shop_id = fields.Many2one('s.sp.shop', default=_get_default_s_sp_shop_id)

    @api.depends('attach_product')
    def compute_url_img(self):
        for rec in self:
            if rec.attach_product:
                current_app_url = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo().base_url
                rec.img_url = f"{current_app_url}/web/image?model=s.shopify.mobile.app.notification&id=" + \
                              str(self.id) + "&field=attach_product"
            else:
                rec.img_url = "/s_shopify_mobile_app/static/src/img/shopify.png"

    def push_img_notification_shopify(self):
        try:
            s_sp_app = self.sudo().s_sp_app_id
            session = shopify.Session(s_sp_app.sudo().sp_shop_id.base_url, s_sp_app.sudo().s_app_id.sp_api_version,
                                      s_sp_app.sudo().token)
            shopify.ShopifyResource.activate_session(session)

            if s_sp_app.mobile_app_shopify_theme_id:
                try:
                    theme = shopify.Theme.find()
                    list_theme = []
                    for rec in theme:
                        list_theme.append(rec.id)
                    # theme = shopify.Theme.find(s_sp_app.mobile_app_shopify_theme_id)
                    if not int(s_sp_app.mobile_app_shopify_theme_id) in list_theme:
                        theme = shopify.Theme.create({
                            "name": "All fetch mobile app",
                            "body": {"test": "222", }
                        })
                        if theme.id:
                            s_sp_app.mobile_app_shopify_theme_id = theme.id
                            s_sp_app.mobile_app_shopify_theme_graphql_notification_api_id = theme.admin_graphql_api_id
                            print(1)
                        else:
                            #Todo raise user error maybe? No shopify error
                            x = 1
                except Exception as e:
                    logging.exception('Error loading data shop ' + str(e))
            else:
                try:
                    theme = shopify.Theme.create({
                        "name": "All fetch mobile app",
                        "body": {"test": "111", }
                    })
                    if theme.id:
                        s_sp_app.mobile_app_shopify_theme_id = theme.id
                        s_sp_app.mobile_app_shopify_theme_graphql_notification_api_id = theme.admin_graphql_api_id
                    else:
                        ##Todo raise user error maybe?
                        x = 1
                except Exception as e:
                    logging.exception('Error loading data shop ' + str(e))
            current_app_url = self.env['ir.config_parameter'].sudo().get_param('web.base.url')
            self.notification_img_url = current_app_url + '/allfetch/image3/attach_product/' + str(
                randint(100, 999)) + '/' + str(self.sudo().id)
            notification_attach = shopify.Asset.create(
                {"theme_id": s_sp_app.mobile_app_shopify_theme_id, "key": "assets/notification_img_" + str(self.id) + "." + self._compute_notification_attach_key(),
                 "src": self.notification_img_url})
            if 'public_url' in notification_attach.attributes:
                self.notification_attach_public_url = notification_attach.public_url
                try:
                    response = requests.request("GET", self.notification_attach_public_url, headers={}, data={})
                except Exception as e:
                    logging.exception('Error loading data shop ' + str(e))
                time.sleep(2)

        except Exception as e:
            logging.exception('Error loading data shop ' + str(e))

    def _compute_notification_attach_key(self):
        mimetype = ''
        if self.attach_product:
            rec = self.sudo().env['ir.attachment'].search(
                [('res_model', '=', 's.shopify.mobile.app.notification'),
                 ('res_field', '=', 'attach_product'),
                 ('res_id', '=', self.id)], limit=1)
            if rec:
                mimetype = rec.mimetype.replace('image/', '')
        return mimetype

    def compute_notification_img_url(self):
        for rec in self:
            rec.notification_img_url = ''
            if rec.attach_product:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.notification_img_url = base_url + '/allfetch/image3/attach_product/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    def send_notification(self):
        try:
            self.push_img_notification_shopify()
            for rec in self:
                rec.status = 'delivered'

            if self.sudo().s_sp_app_id:
                url = "https://fcm.googleapis.com/fcm/send"
                headers = {
                    'Content-Type': 'application/json',
                    'Authorization': 'key=' + str(self.sudo().s_sp_app_id.mobile_app_firebase_key)
                }

                register_ids = self.sudo().s_sp_app_id.register_ids
                ### firebase limit toi da 1000 register ids 1 lan gui
                ### chat list nhieu ban ghi thanh nhieu list nho chua 1000 id
                register_ids_list = [register_ids[i:i + 999] for i in range(0, len(register_ids), 999)]
                for list in register_ids_list:
                    registration_ids_values = []
                    for rec in list:
                        registration_ids_values.append(rec.name)
                    if self.sudo().attach_product:
                        payload = {
                            "priority": "HIGH",
                            "data": {
                            },
                            "notification": {
                                "title": self.sudo().title,
                                "body": self.sudo().message,
                                "sound": "default",
                                "image": self.sudo().notification_attach_public_url
                            },
                            "registration_ids": registration_ids_values
                        }
                    else:
                        payload = {
                            "priority": "HIGH",
                            "data": {
                            },
                            "notification": {
                                "title": self.sudo().title,
                                "body": self.sudo().message,
                                "sound": "default",
                            },
                            "registration_ids": registration_ids_values
                        }
                    response = requests.request("POST", url, headers=headers, data=json.dumps(payload))
                    self.env['s.shopify.mobile.app.notification.log'].sudo().create(
                        {
                            's_sp_app_id': self.sudo().s_sp_app_id.id,
                            'response_json': str(response.json()),
                            'success': response.json().get('success') or 0,
                            'failure': response.json().get('failure') or 0,
                            'user_id': self.env.uid
                        }
                    )
                    x=1
        except Exception as e:
            logging.exception('Error loading data shop ' + str(e))

    def schedule_notification(self):
        try:
            self.push_img_notification_shopify()
            for rec in self:
                rec.status = 'scheduled'
        except Exception as e:
            logging.exception('Error loading data shop ' + str(e))

    def send_notification_cron(self):
        now = datetime.now()
        now_utc = pytz.utc.localize(now)
        print(now, now_utc)
        records = self.env['s.shopify.mobile.app.notification'].sudo().search([('status', '=', 'scheduled'), ('send_date', '<', now_utc)])
        for rec in records:
            rec.sudo().send_notification()
        return True

    def action_duplicate_notify(self):
        self.sudo().create({
            'title': self.title,
            'message': self.message,
            'attach_product': self.attach_product,
            'bool_send_date': self.bool_send_date,
            'send_date': self.send_date,
        })

    def action_delete_notify(self):
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_delete_notification_view_form').id
        return {
            'name': 'Mobile App Warning',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'context': {
                'default_message_id': self.sudo().id,
            },
            'target': 'new',
        }