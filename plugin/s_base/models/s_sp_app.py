# -*- coding: utf-8 -*-
import json
from datetime import timedelta

import shopify
from werkzeug import urls

from odoo import models, fields, api

GOOGLE_AUTH_ENDPOINT = 'https://accounts.google.com/o/oauth2/auth'
GOOGLE_TOKEN_ENDPOINT = 'https://accounts.google.com/o/oauth2/token'
GOOGLE_API_BASE_URL = 'https://www.googleapis.com'
GOOGLE_SCOPE = 'https://www.googleapis.com/auth/content'
import requests
from odoo.exceptions import UserError

TIMEOUT = 20
import traceback
import logging

_logger = logging.getLogger(__name__)

###test api
import google.oauth2.credentials
import googleapiclient.discovery
from odoo import http

FIELDS = ['install_status', 'plan_name']
SCRIPT_FILE = {
    's_shopify_bought_together': {
        'key': 'af-bought-together-front.js'
    },
    's_shopify_bundle': {
        'key': 'af-bundle-front.js'
    },
    's_shopify_mobile_app': {
        'key': 'af-mobile-front.js'
    },
    's_shopify_sticky_add_to_cart': {
        'key': 'af-sticky-cart-front.js'
    },
    's_shopify_tiktok': {
        'key': 'af-tiktok-front.js'
    },
    's_shopify_whatsapp': {
        'key': 'af-whatsapp-front.js'
    },
}


class SSpApp(models.Model):
    _name = 's.sp.app'
    _rec_name = 'sp_shop_id'

    sp_shop_id = fields.Many2one('s.sp.shop')
    s_app_id = fields.Many2one('s.app')
    status = fields.Boolean()
    token = fields.Char()
    s_plan_id = fields.Many2one('s.plan')
    is_force_update_webhook = fields.Boolean(default=False)
    webhook_data = fields.Text()
    ### google information
    gg_access_token = fields.Text(string='Google access token')
    gg_refresh_token = fields.Text(string='Google refresh token')
    gg_email = fields.Char(string='Google email')
    s_gg_account_ids = fields.One2many('s.gg.account', 's_sp_app_id')
    shopify_session_singleton = None
    # gg_redirect_uri = fields.Char(string='gg redirect uri', compute='compute_gg_redirect_uri')
    install_status = fields.Boolean(
        string='Install status',
        default=True)

    # charge
    s_charge_id = fields.Char('Charge ID')

    # sync product ready status
    sync_product_ready_status = fields.Boolean(
        string='Product sync ready?',
        default=True)

    web_hook_ids = fields.Many2many('s.sp.web.hook')

    shop_url = fields.Char(related="sp_shop_id.base_url")
    shop_email = fields.Char(related="sp_shop_id.email")

    # script change
    has_change_script = fields.Boolean(default=True)
    # plan
    plan_name = fields.Char("Plan Detail")
    next_bill = fields.Date()

    def schedule_change_script(self):
        shops = self.sudo().search([('install_status', '=', True), ('has_change_script', '=', False)], limit=100,
                                   order="write_date asc")
        for shop in shops:
            # _logger.error(str(shop.id))
            try:
                shop.add_script_to_shop()
            except Exception as e:
                print(str(e))
                # continue
        return

    def get_key(self, module_name):
        return SCRIPT_FILE[module_name]['key']

    def add_script_to_shop(self, has_session=None):
        for rec in self:
            try:
                if has_session is None:
                    try:
                        rec.get_shopify_session()
                    except Exception as e:
                        rec.has_change_script = True
                        _logger.error('Start Session Fail')
                script_src_asset_luuthuy = rec.s_app_id.cdn_script_tag
                # if not script_src_asset_luuthuy:
                #     script_src_asset_luuthuy = ''
                if script_src_asset_luuthuy and script_src_asset_luuthuy != '':
                    module_name = rec.s_app_id.get_module_name()
                    existedScriptTags_luuthuy = shopify.ScriptTag.find(src=script_src_asset_luuthuy)
                    if existedScriptTags_luuthuy:
                        rec.has_change_script = True
                        scriptTag_id = ''
                        for scriptTag in existedScriptTags_luuthuy:
                            scriptTag_id = scriptTag.id
                        return scriptTag_id
                    if module_name:
                        if not existedScriptTags_luuthuy:
                            existedScriptTags = shopify.ScriptTag.find(limit=100)
                            if existedScriptTags:
                                key = self.get_key(module_name)
                                for scriptTag in existedScriptTags:
                                    if module_name in scriptTag.attributes.get(
                                            'src') or key in scriptTag.attributes.get('src'):
                                        shopify.ScriptTag.find(scriptTag.id).destroy()
                        scriptTag = shopify.ScriptTag.create({
                            "event": "onload",
                            "src": script_src_asset_luuthuy
                        })
                        rec.has_change_script = True
                        return scriptTag.id
            except Exception as e:
                _logger.error('Change Script Tag Fail')
                _logger.error(traceback.format_exc())
                rec.has_change_script = False
            shopify.ShopifyResource.clear_session()
            # return
        return

    def get_shopify_session(self):
        # if not self.shopify_session_singleton:
        #     return True
        shopify.Session.setup(
            api_key=self.s_app_id.sp_api_key,
            secret=self.s_app_id.sp_api_secret_key
        )
        shopify_session_singleton = shopify.Session(self.sp_shop_id.base_url, version=self.s_app_id.sp_api_version,
                                                    token=self.token)
        shopify.ShopifyResource.activate_session(shopify_session_singleton)
        return shopify_session_singleton

    def remove_script_tag_and_webhook(self):
        for rec in self:
            try:
                if rec.token:
                    rec.get_shopify_session()
                    existedScriptTags = shopify.ScriptTag.find()
                    if existedScriptTags:
                        for e in existedScriptTags:
                            if 'https://apps1.allfetch.com' in e.src:
                                shopify.ScriptTag.find(e.id).destroy()
                    existing_webhooks = shopify.Webhook.find()
                    if existing_webhooks:
                        for webhook in existing_webhooks:
                            if webhook.id and 'https://apps1.allfetch.com' in webhook.attributes['address']:
                                shopify.Webhook.find(webhook.id).destroy()
                    rec.install_status = False
            except Exception as e:
                _logger.error('Start Session Fail')
        return

    def activate_plan(self, charge_id, plan_name=None):
        session = self.get_shopify_session()
        charge = shopify.RecurringApplicationCharge.find(charge_id)
        charge.activate()
        if charge.status != 'active':
            raise Exception('Could not activate your plan. Please try again!')
        self.s_charge_id = charge_id
        if charge.trial_days and plan_name:
            if charge.trial_days > 0:
                if self.plan_name != 'trial_' + plan_name.lower():
                    self.plan_name = 'trial_' + plan_name.lower()
            else:
                if self.plan_name != 'paid_' + plan_name.lower():
                    self.plan_name = 'paid_' + plan_name.lower()
        else:
            self.plan_name = plan_name
        now = fields.Datetime.now()
        date_now = fields.Datetime.now().date()
        if not self.next_bill or self.next_bill <= date_now:
            self.next_bill = (now + timedelta(days=30)).date()
        shopify.ShopifyResource.clear_session()
        return charge

    def find_current_plan(self):
        session = self.get_shopify_session()
        current_plan = shopify.RecurringApplicationCharge.current()
        if not current_plan:
            if self.plan_name != 'Free':
                self.plan_name = 'Free'
            return False
        shopify.ShopifyResource.clear_session()
        return current_plan

    def create_usage_charge(self, usage_charge, env, terms):
        session = self.get_shopify_session()
        current_plan = shopify.RecurringApplicationCharge.current()
        use_charge = shopify.UsageCharge({
            'description': terms,
            'price': usage_charge,
            'test': env,
            'recurring_application_charge_id': current_plan.id
        })
        new_charge = use_charge.save()
        shopify.ShopifyResource.clear_session()
        return new_charge

    def force_update_webhook_setting(self):
        for rec in self:
            session = shopify.Session(rec.sp_shop_id.base_url, rec.s_app_id.sp_api_version, rec.token)
            shopify.ShopifyResource.activate_session(session)
            existing_webhooks = shopify.Webhook.find()
            # delete all existing webhook
            for webhook in existing_webhooks:
                if webhook.id and 'shopify_data/webhook' in webhook.attributes['address']:
                    shopify.Webhook.find(webhook.id).destroy()

            # webhook product
            for web_hook_setting in rec.sp_shop_id.web_hook_ids:
                webhooks_response = shopify.Webhook(dict(topic=web_hook_setting.topic,
                                                         address=rec.s_app_id.webhook_base_url + "/shopify_data/webhook/" + rec.sp_shop_id.base_url + '/' + web_hook_setting.topic,
                                                         format="json")
                                                    ).save()
            existing_webhooks = shopify.Webhook.find()
            if existing_webhooks:
                existing_webhooks_list = []
                for webhook in existing_webhooks:
                    if type(webhook) is not dict:
                        webhook = webhook.to_dict()
                    existing_webhooks_list.append(webhook)
                rec.webhook_data = json.dumps(existing_webhooks_list)

    # TODO from url
    def action_google_sign_in(self):
        from_url = self.sudo().s_app_id.gg_from_url
        url = self.sudo()._get_authorize_uri(from_url=from_url)
        return {
            'type': 'ir.actions.act_url',
            'target': 'self',
            'url': url,
        }

    def _get_authorize_uri(self, from_url, model=None, id=None):
        """ This method return the url needed to allow this instance of Odoo to access to the scope
            of gmail specified as parameters
        """
        # get_param = self.env['ir.config_parameter'].sudo().get_param
        # base_url = get_param('web.base.url', default='http://www.odoo.com?NoBaseUrl')
        base_url = self.sudo().s_app_id.base_url
        client_id = self.sudo().s_app_id.gg_api_client_id
        client_secret = self.sudo().s_app_id.gg_api_client_secret
        scope = self.sudo().s_app_id.gg_scope
        app_name = self.sudo().s_app_id.name

        state = {
            'f': from_url,
            'n': app_name,
            'm': model,
            'i': id
        }

        encoded_params = urls.url_encode({
            'response_type': 'code',
            'client_id': client_id,
            'state': json.dumps(state),
            'scope': scope,
            'redirect_uri': base_url + '/ggf/authentication',
            'approval_prompt': 'force',
            'access_type': 'offline'
        })
        return "%s?%s" % (GOOGLE_AUTH_ENDPOINT, encoded_params)

    def get_google_token_json(self, authorize_code, current_model, current_id):
        """ Call Google API to exchange authorization code against token, with POST request, to
            not be redirected.
        """
        base_url = self.s_app_id.base_url
        client_id = self.s_app_id.gg_api_client_id
        client_secret = self.s_app_id.gg_api_client_secret

        headers = {"content-type": "application/x-www-form-urlencoded"}
        data = {
            'code': authorize_code,
            'client_id': client_id,
            'client_secret': client_secret,
            'grant_type': 'authorization_code',
            'redirect_uri': base_url + '/ggf/authentication'
        }
        try:
            response = requests.request('post', GOOGLE_TOKEN_ENDPOINT, data=data, headers=headers, timeout=TIMEOUT)
            token = response.json()
            access_token = token['access_token']
            refresh_token = token['refresh_token']
            email = self.sudo().get_google_email(access_token, refresh_token)
            existed_account = False
            s_gg_account = None
            for account in self.sudo().s_gg_account_ids:
                if account.email == email and account.sudo().s_sp_app_id.id == self.sudo().id:
                    s_gg_account = account
                    existed_account = True
                    account.sudo().access_token = access_token
                    account.sudo().refresh_token = refresh_token
                    account.sudo().create_merchant()
                    break
            if not existed_account:
                s_gg_account = self.env['s.gg.account'].sudo().create(
                    {
                        'access_token': access_token,
                        'refresh_token': refresh_token,
                        'email': email,
                        's_sp_app_id': self.id,
                    }
                )
                s_gg_account.sudo().create_merchant()
            if s_gg_account and current_model and current_id:
                current_object = self.env[current_model].sudo().browse(current_id)
                if hasattr(current_object, 'call_back_connect_google'):
                    method = getattr(current_object, 'call_back_connect_google')
                    method(s_gg_account=s_gg_account)

            # self.sudo().gg_access_token = token['access_token']
            # self.sudo().gg_refresh_token = token['refresh_token']
            # print(token)
            # ## get email
            # self.sudo().gg_email = email

            ## merchant_ids
            # merchant_ids = self.sudo().get_merchant_ids()
            # if len(merchant_ids) > 0:
            #     for merchant in merchant_ids:
            #         self.env['s.gg.merchant'].sudo().create({
            #             'name' : merchant['merchantId']
            #         })
            return response
        except requests.HTTPError:
            raise UserError(("Something wrong with Google authenticate, please try again!!!"))

    def refresh_google_token_json(self):  # exchange_AUTHORIZATION vs Token
        client_id = self.sudo().s_app_id.gg_api_client_id
        client_secret = self.sudo().s_app_id.gg_api_client_secret
        refresh_token = self.sudo().gg_refresh_token
        if not client_id or not client_secret:
            raise UserError(("The account for the Google service is not configured."))

        headers = {"content-type": "application/x-www-form-urlencoded"}
        data = {
            'refresh_token': refresh_token,
            'client_id': client_id,
            'client_secret': client_secret,
            'grant_type': 'refresh_token',
        }

        try:
            response = requests.request('post', GOOGLE_TOKEN_ENDPOINT, data=data, headers=headers, timeout=TIMEOUT)
            token = response.json()
            self.sudo().gg_access_token = token['access_token']
            self.sudo().gg_refresh_token = token['refresh_token']
            return response.json
        except requests.HTTPError as error:
            if error.response.status_code == 400:
                self.sudo().gg_access_token = False
                self.sudo().gg_refresh_token = False
                return

    def get_credential(self, access_token, refresh_token):
        # TODO check if none raise error
        credential = {
            'token': access_token,
            'refresh_token': refresh_token,
            'token_uri': 'https://oauth2.googleapis.com/token',
            'client_id': self.sudo().s_app_id.gg_api_client_id,
            'client_secret': self.sudo().s_app_id.gg_api_client_secret,
            'scopes': ['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/content']
        }
        return credential

    def prepare_credentials(self, access_token, refresh_token):
        if 'credentials' not in http.request.httprequest.session:
            credential = self.get_credential(access_token, refresh_token)
            credentials = google.oauth2.credentials.Credentials(
                **credential)
        else:
            credentials = google.oauth2.credentials.Credentials(
                **http.request.httprequest.session.credentials)
        return credentials

    ## test call api bang thu vien
    def button_test_api(self):
        if 'credentials' not in http.request.httprequest.session:
            credential = self.get_credential()
            credentials = google.oauth2.credentials.Credentials(
                **credential)
        else:
            credentials = google.oauth2.credentials.Credentials(
                **http.request.httprequest.session.credentials)
        service = self.sudo().s_app_id.gg_service
        api_version = self.sudo().s_app_id.gg_api_version
        resource = googleapiclient.discovery.build(
            service, api_version, credentials=credentials)
        request = resource.products()
        result = request.list(merchantId='275380900').execute()
        products = result.get('resources')
        print(products)

    def get_merchant_ids(self, access_token, refresh_token):
        service = self.sudo().s_app_id.gg_service
        api_version = self.sudo().s_app_id.gg_api_version
        credentials = self.prepare_credentials(access_token, refresh_token)
        resource = googleapiclient.discovery.build(
            service, api_version, credentials=credentials)
        res = resource.accounts().authinfo().execute()
        if 'accountIdentifiers' in res:
            return res['accountIdentifiers']
        else:
            return []

    def get_google_email(self, access_token, refresh_token):
        service = 'oauth2'
        api_version = 'v2'
        credentials = self.prepare_credentials(access_token, refresh_token)
        user_info_service = googleapiclient.discovery.build(
            service, api_version, credentials=credentials)
        try:
            user_info = user_info_service.userinfo().get().execute()
            if 'email' in user_info:
                return user_info['email']
        except:
            print(1)
            # raise UserError(("Something wrong with Google authenticate, please try again!!!"))

    def need_resign_in(self):
        if self.sudo().gg_access_token and self.sudo().gg_refresh_token:
            return True
        else:
            return False

    def sign_out_google(self):
        self.sudo().gg_access_token = False
        self.sudo().gg_refresh_token = False
        self.sudo().gg_email = False
        url = self.sudo().s_app_id.gg_from_url
        return {
            'type': 'ir.actions.act_url',
            'target': 'self',
            'url': url,
        }

    @api.model
    def create(self, value):
        res = super(SSpApp, self).create(value)
        try:
            if res:
                self.env['s.customer.io.queue'].sudo().create({
                    'shop_url': res.sudo().sp_shop_id.base_url or '',
                    's_app_id': res.sudo().s_app_id.id or '',
                    'plan': res.sudo().plan_name or 'Free',
                    'shop_name': res.sudo().sp_shop_id.name or '',
                    'state': 'pending',
                    'email': res.sudo().sp_shop_id.email or '',
                    'country': res.sudo().sp_shop_id.country,
                    'shop_create_date': res.create_date,
                })
        except Exception as e:
            _logger.error(traceback.format_exc())
        try:
            if res:
                res.sp_shop_id.force_update_webhook_setting()
        except Exception as e:
            _logger.error(traceback.format_exc())
        return res

    def unlink(self):
        # todo chua xu ly truong hop xoa nhieu shop app cua cac shop khac nhau
        current_shop = None
        for rec in self:
            current_shop = rec.sp_shop_id
        res = super(SSpApp, self).unlink()
        try:
            if res:
                current_shop.force_update_webhook_setting()
        except Exception as e:
            _logger.error(traceback.format_exc())
        return res

    def write(self, value):
        res = super(SSpApp, self).write(value)
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
                        [('s_app_id', '=', rec.s_app_id.id), ('shop_url', '=', rec.sudo().sp_shop_id.base_url)],
                        limit=1)
                    if existed_queue:
                        existed_queue.sudo().write({
                            'shop_url': rec.sudo().sp_shop_id.base_url or '',
                            's_app_id': rec.s_app_id.id,
                            'plan': rec.sudo().plan_name or 'Free',
                            'shop_name': rec.sudo().sp_shop_id.name,
                            'state': 'pending',
                            'email': rec.sudo().sp_shop_id.email or '',
                            'country': rec.sudo().sp_shop_id.country or '',
                            'shop_create_date': rec.create_date,
                            'uninstall': False if rec.install_status else True,
                        })
                    else:
                        self.env['s.customer.io.queue'].sudo().create({
                            'shop_url': rec.sudo().sp_shop_id.base_url or '',
                            's_app_id': rec.s_app_id.id,
                            'plan': rec.sudo().s_plan_id.customer_io_plan_name or 'Free',
                            'shop_name': rec.sudo().sp_shop_id.name,
                            'state': 'pending',
                            'email': rec.sudo().sp_shop_id.email or '',
                            'country': rec.sudo().sp_shop_id.country or '',
                            'shop_create_date': rec.create_date,
                            'uninstall': False if rec.install_status else True,
                        })
        except Exception as e:
            _logger.error(traceback.format_exc())
        # update webhook settings
        try:
            if 'install_status' in value:
                for rec in self:
                    rec.sp_shop_id.force_update_webhook_setting()
        except Exception as e:
            _logger.error(traceback.format_exc())
        return res

    def try_get_store_info(self):
        for rec in self:
            session = shopify.Session(rec.sp_shop_id.base_url, rec.s_app_id.sp_api_version, rec.token)
            shopify.ShopifyResource.activate_session(session)
            client = shopify.GraphQL()
            query = '''
                                                  {
                                                    shop {
                                                      id
                                                      name
                                                      email
                                                      myshopifyDomain
                                                      contactEmail
                                                      currencyCode
                                                      enabledPresentmentCurrencies
                                                      billingAddress {
                                                          country
                                                          firstName
                                                          lastName
                                                          name
                                                      }
                                                      primaryDomain {
                                                          url
                                                      }
                                                    }
                                                  }
                                              '''
            result = client.execute(query)
            current_shop_dict = json.loads(result)
            raise UserError(json.dumps(current_shop_dict))

    def check_shop_app_uninstall(self):
        for rec in self:
            session = shopify.Session(rec.sp_shop_id.base_url, rec.s_app_id.sp_api_version, rec.token)
            shopify.ShopifyResource.activate_session(session)
            try:
                shop = shopify.Shop.current()
                current_plan = shopify.RecurringApplicationCharge.current()
                if not current_plan:
                    rec.s_plan_id = False
                if not rec.sp_shop_id.country:
                    rec.sp_shop_id.country = shop.attributes['country_name']
            except Exception as e:
                if e.code == 401:
                    rec.sudo().write({
                        'install_status': False,
                        's_plan_id': False
                    })
