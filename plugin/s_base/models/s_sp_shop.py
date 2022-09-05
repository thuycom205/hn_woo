# -*- coding: utf-8 -*-
import json

from odoo import models, fields

FIELDS = ['country', 'email']
import traceback
import logging

_logger = logging.getLogger(__name__)
import shopify


class SSpShop(models.Model):
    _name = 's.sp.shop'
    _rec_name = 'name'

    name = fields.Char()
    base_url = fields.Char(index=True)
    base_url_2 = fields.Char(string="Base url 2", index=True)
    password = fields.Char(groups="base.group_system")
    email = fields.Char()
    status = fields.Boolean()
    currency_code = fields.Char()
    currency_id = fields.Many2one('res.currency')
    json_data = fields.Char()
    current_webhook_json_data = fields.Char()
    user_id = fields.One2many('res.users', 'sp_shop_id')
    s_sp_app_ids = fields.One2many('s.sp.app', 'sp_shop_id')
    last_fetch_product = fields.Datetime()

    last_name = fields.Char()
    country = fields.Char()
    first_name = fields.Char()
    full_name = fields.Char()
    shop_owner = fields.Char()
    # shop_address = fields.Char()

    # shopify currency format
    money_format = fields.Char(string='HTML without currency')
    money_email_format = fields.Char(string='Email without currency')
    money_with_currency_format = fields.Char(string='HTML with currency')
    money_currency_email_format = fields.Char(string='Email with currency')
    is_core_shop = fields.Boolean(default=False)
    is_web_hook_need = fields.Boolean(default=False)
    is_insert_collection_theme = fields.Boolean(
        string='Product collection')
    is_lock_product_data_queue = fields.Boolean(default=False)

    has_notify = fields.Boolean(default=False)
    is_webhook_updated = fields.Boolean(default=False)
    is_removed = fields.Boolean(default=False)

    timezone = fields.Char()

    def write(self, value):
        res = super(SSpShop, self).write(value)
        try:
            # check uninstall or change plan
            has_change_queue = False
            for field in FIELDS:
                if field in value:
                    has_change_queue = True
                    break
            if has_change_queue:
                for rec in self:
                    existed_queue = self.env['s.customer.io.queue'].sudo().search(
                        [('shop_url', '=', rec.sudo().base_url)])
                    if existed_queue:
                        existed_queue.sudo().write(
                            {
                                'country': rec.country,
                                'email': rec.email,
                                'state': 'pending',
                            }
                        )
        except Exception as e:
            _logger.error(traceback.format_exc())
        return res

    def force_update_webhook_setting(self):
        # todo chua xu ly duoc truong hop webhook chay ngay luc minh doi thong tin setting webhook
        for rec in self:
            try:
                # get current webhook id for shop
                current_webhooks = []
                current_webhooks_ids = []
                for app in rec.s_sp_app_ids:
                    if app.install_status:
                        for web_hook in app.s_app_id.web_hook_ids:
                            if web_hook.id not in current_webhooks_ids:
                                current_webhooks_ids.append(web_hook.id)
                                current_webhooks.append(web_hook)

                # init new list and create, delete old webhook

                # create list shop app need update web hook settings
                need_update_web_hook_app = []

                inserted_webhooks = []
                for app in rec.s_sp_app_ids:
                    if app.install_status:
                        current_app_web_hook_ids = app.web_hook_ids.ids
                        current_app_new_web_hook_ids = []
                        for web_hook in app.s_app_id.web_hook_ids:
                            if not web_hook.is_singleton:
                                current_app_new_web_hook_ids.append(web_hook.id)
                            else:
                                if web_hook.id not in inserted_webhooks:
                                    current_app_new_web_hook_ids.append(web_hook.id)
                                    inserted_webhooks.append(web_hook.id)
                        is_need_update_web_hook = True
                        if len(current_app_web_hook_ids) == len(current_app_new_web_hook_ids):
                            is_need_update_web_hook = False
                            for e in current_app_web_hook_ids:
                                if e not in current_app_new_web_hook_ids:
                                    is_need_update_web_hook = True
                        if is_need_update_web_hook:
                            app.write({
                                'web_hook_ids': [(6, False, current_app_new_web_hook_ids)]
                            })
                            need_update_web_hook_app.append(app)
                # update webhook setting to shopify
                for app in need_update_web_hook_app:
                    session = shopify.Session(rec.base_url, app.s_app_id.sp_api_version, app.token)
                    shopify.ShopifyResource.activate_session(session)
                    existing_webhooks = shopify.Webhook.find()
                    # delete all existing webhook
                    for webhook in existing_webhooks:
                        if webhook.id and 'shopify_data/webhook' in webhook.attributes['address']:
                            shopify.Webhook.find(webhook.id).destroy()

                    # webhook product
                    for web_hook_setting in app.web_hook_ids:
                        if web_hook_setting.topic == 'app/uninstalled':
                            webhooks_response = shopify.Webhook(dict(topic=web_hook_setting.topic,
                                                                     address=app.s_app_id.webhook_base_url + "/shopify_data/webhook/" + web_hook_setting.topic + '/' + app.s_app_id.name + '/' + str(app.sp_shop_id.id),
                                                                     format="json")
                                                                ).save()
                        else:
                            webhooks_response = shopify.Webhook(dict(topic=web_hook_setting.topic,
                                                                     address=app.s_app_id.webhook_base_url + "/shopify_data/webhook/" + str(app.sp_shop_id.id) + '/' + web_hook_setting.topic,
                                                                     format="json")
                                                                ).save()
                    existing_webhooks = shopify.Webhook.find()
                    if existing_webhooks:
                        existing_webhooks_list = []
                        for webhook in existing_webhooks:
                            if type(webhook) is not dict:
                                webhook = webhook.to_dict()
                            existing_webhooks_list.append(webhook)
                        app.webhook_data = json.dumps(existing_webhooks_list)
            except Exception as ex:
                # _logger.error(traceback.format_exc())
                e = 0

    def force_update_fresh_webhook_setting(self):
        for rec in self:
            try:
                for app in rec.s_sp_app_ids:
                    if app.install_status:
                        session = shopify.Session(rec.base_url, app.s_app_id.sp_api_version, app.token)
                        shopify.ShopifyResource.activate_session(session)
                        existing_webhooks = shopify.Webhook.find()
                        # delete all existing webhook
                        for webhook in existing_webhooks:
                            if webhook.id and 'shopify_data/webhook' in webhook.attributes['address']:
                                shopify.Webhook.find(webhook.id).destroy()

                        # webhook product
                        for web_hook_setting in app.web_hook_ids:
                            if web_hook_setting.topic == 'app/uninstalled':
                                webhooks_response = shopify.Webhook(dict(topic=web_hook_setting.topic,
                                                                         address=app.s_app_id.webhook_base_url + "/shopify_data/webhook/" + web_hook_setting.topic + '/' + app.s_app_id.name + '/' + str(app.sp_shop_id.id),
                                                                         format="json")
                                                                    ).save()
                            else:
                                webhooks_response = shopify.Webhook(dict(topic=web_hook_setting.topic,
                                                                         address=app.s_app_id.webhook_base_url + "/shopify_data/webhook/" + str(app.sp_shop_id.id) + '/' + web_hook_setting.topic,
                                                                         format="json")
                                                                    ).save()
                        existing_webhooks = shopify.Webhook.find()
                        if existing_webhooks:
                            existing_webhooks_list = []
                            for webhook in existing_webhooks:
                                if type(webhook) is not dict:
                                    webhook = webhook.to_dict()
                                existing_webhooks_list.append(webhook)
                            app.webhook_data = json.dumps(existing_webhooks_list)
                rec.is_webhook_updated = True
            except Exception as ex:
                rec.is_removed = True
                # _logger.error(traceback.format_exc())
                e = 0