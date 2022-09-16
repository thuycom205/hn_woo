# -*- coding: utf-8 -*-
import base64
import json
import logging
import os
import random
import string
import traceback

import shopify
import werkzeug

from odoo import http
from odoo.http import request
from ...s_base.controllers.sp_controllers import SpController
from flask import  abort
import hmac
import hashlib
_logger = logging.getLogger(__name__)


class OauthTrelloController(http.Controller):

    @http.route('/strello/index', auth='public',methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def shopify_auth_s_registry(self, **kw):
        x=1

        if 'shop' in kw:
            # generate permission url
            current_app = request.env.ref('mas_trello.s_trello_app').sudo()
            version = current_app.sp_api_version
            if current_app:
                shopify.ShopifyResource.clear_session()
                shopify.Session.setup(
                    api_key=current_app.sp_api_key,
                    secret=current_app.sp_api_secret_key)
                shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                scope = [
                    "read_products",
                    "read_product_listings",
                    "read_orders",
                    "write_orders",
                ]
                redirect_uri = current_app.base_url + "/strello/auth"
                permission_url = shopify_session.create_permission_url(
                    scope, redirect_uri)
                return werkzeug.utils.redirect(permission_url)

        return "Hello, world"

    @http.route('/strello/auth', auth='public',methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def shopify_finalize_s_registry(self, **kw):
        try:
            # check neccessary param
            if 'shop' in kw:
                current_app = request.env.ref('mas_trello.s_trello_app').sudo()
                if current_app:
                    shopify.Session.setup(
                        api_key=current_app.sp_api_key,
                        secret=current_app.sp_api_secret_key)
                    shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                    token = shopify_session.request_token(kw)
                    shopify.ShopifyResource.activate_session(shopify_session)

                    # script tag and web hook
                    existing_weekhooks = shopify.Webhook.find()
                    if not existing_weekhooks:
                        # update the password

                        # order create webhook
                        # orders / cancelled, orders / create, orders / fulfilled, orders / paid, orders / partially_fulfilled, orders / updated

                        weekhooks_response = shopify.Webhook(dict(topic="orders/create",
                                                                  address=current_app.base_url + "/strello/order_paid",
                                                                  format="json")).save()

                        # checkout

                        weekhooks_response = shopify.Webhook(dict(topic="orders/paid",
                                                                  address=current_app.base_url + "/strello/order_paid",
                                                                  format="json")).save()

                        x = 1
                        # uninstall app webhook
                        weekhooks_uninstall_response = shopify.Webhook(dict(topic="app/uninstalled",
                                                                            address=current_app.base_url + "/strello/app_uninstalled",
                                                                            format="json")).save()
                        weekhooks_response = shopify.Webhook(dict(topic="shop/update",
                                                                  address=current_app.base_url + "/strello/shop/updatee",
                                                                  format="json")
                                                             ).save()


                    if token:
                        current_s_sp_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', kw['shop'])],
                                                                                   limit=1)
                        current_user = http.request.env['res.users'].sudo().search([('login', '=', kw['shop'])],
                                                                                   limit=1)
                        if not current_s_sp_shop:
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
                                                          billingAddress {
                                                              country
                                                              firstName
                                                              lastName
                                                              name
                                                          }
                                                          currencyFormats{
                                                              moneyFormat
                                                              moneyInEmailsFormat
                                                              moneyWithCurrencyFormat
                                                              moneyWithCurrencyInEmailsFormat
                                                            }
                                                        }
                                                      }
                                                  '''
                            result = client.execute(query)
                            current_shop_dict = json.loads(result)
                            # check and create s_sp_shop, res_user, res_company

                            # create company
                            current_company = http.request.env['res.company'].sudo().search([('name', '=', kw['shop'])],
                                                                                            limit=1)
                            if not current_company:
                                with open(os.path.abspath(
                                        os.path.dirname(os.path.dirname(__file__))) + '/static/src/img/favicon.png',
                                          "rb") as image_file:
                                    encoded_allfetch_image = base64.b64encode(image_file.read())
                                current_company = http.request.env['res.company'].sudo().create({
                                    'logo': False, 'currency_id': 2, 'sequence': 10,
                                    'favicon': encoded_allfetch_image,
                                    'name': kw['shop'], 'street': False, 'street2': False, 'city': False,
                                    'state_id': False,
                                    'zip': False, 'country_id': False, 'phone': False, 'email': False, 'website': False,
                                    'vat': False, 'company_registry': False, 'parent_id': False
                                })
                            # create user

                            # generate password
                            letters = string.ascii_lowercase
                            password_generate = ''.join(random.choice(letters) for i in range(30))
                            current_s_sp_shop = request.env['s.sp.shop'].sudo().create({
                                'name': current_shop_dict['data']['shop']['name'],
                                'base_url': kw['shop'],
                                'email': current_shop_dict['data']['shop']['email'],
                                'currency_code': current_shop_dict['data']['shop']['currencyCode'],
                                'currency_id': 2,
                                'password': password_generate,
                                'first_name': current_shop_dict['data']['shop']['billingAddress']['firstName'] or '',
                                'country': current_shop_dict['data']['shop']['billingAddress']['country'] or '',
                                'full_name': current_shop_dict['data']['shop']['billingAddress']['name'] or '',
                                'last_name': current_shop_dict['data']['shop']['billingAddress']['lastName'] or '',
                                'money_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                    'moneyFormat'] or '',
                                'money_email_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                          'moneyInEmailsFormat'] or '',
                                'money_with_currency_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                                  'moneyWithCurrencyFormat'] or '',
                                'money_currency_email_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                                   'moneyWithCurrencyInEmailsFormat'] or '',
                            })

                            if not current_user:
                                current_user = http.request.env['res.users'].sudo().create({
                                    'company_ids': [[6, False, [current_company.sudo().id]]],
                                    'company_id': current_company.sudo().id,
                                    'active': True,
                                    'lang': 'en_US', 'tz': 'Europe/Brussels',
                                    'image_1920': False, '__last_update': False,
                                    'name': kw['shop'], 'email': current_shop_dict['data']['shop']['email'],
                                    'login': kw['shop'],
                                    'password': password_generate,
                                    'is_client': True,
                                    'action_id': False,
                                    'sp_shop_id': current_s_sp_shop.sudo().id
                                })


                        else:
                            # todo active shop
                            current_s_sp_shop.status = True


                            ## update shop infomation
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
                                                                     currencyFormats{
                                                                        moneyFormat
                                                                        moneyInEmailsFormat
                                                                        moneyWithCurrencyFormat
                                                                        moneyWithCurrencyInEmailsFormat
                                                                    }
                                                                   }
                                                                 }
                                                             '''
                            result = client.execute(query)
                            current_shop_dict = json.loads(result)
                            current_s_sp_shop.sudo().write({
                                'name': current_shop_dict['data']['shop']['name'],
                                'base_url': kw['shop'],
                                'email': current_shop_dict['data']['shop']['email'],
                                'currency_code': current_shop_dict['data']['shop']['currencyCode'],
                                'first_name': current_shop_dict['data']['shop']['billingAddress']['firstName'] or '',
                                'country': current_shop_dict['data']['shop']['billingAddress']['country'] or '',
                                'full_name': current_shop_dict['data']['shop']['billingAddress']['name'] or '',
                                'last_name': current_shop_dict['data']['shop']['billingAddress']['lastName'] or '',
                                'money_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                    'moneyFormat'] or '',
                                'money_email_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                          'moneyInEmailsFormat'] or '',
                                'money_with_currency_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                                  'moneyWithCurrencyFormat'] or '',
                                'money_currency_email_format': current_shop_dict['data']['shop']['currencyFormats'][
                                                                   'moneyWithCurrencyInEmailsFormat'] or '',
                            })


                            #     request.env['shopify.google.feed.currencies'].sudo().create(main_currency_values)
                        # Get Shop Owner
                        if current_s_sp_shop:
                            if not current_s_sp_shop.shop_owner:
                                s_current_shop = shopify.Shop.current()
                                current_s_sp_shop.shop_owner = s_current_shop.attributes['shop_owner']
                        # check and create s_sp_app
                        current_s_sp_app = http.request.env['s.sp.app'].sudo().search(
                            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)],
                            limit=1)
                        if not current_s_sp_app:
                            # todo update shop plan
                            current_s_sp_app = http.request.env['s.sp.app'].sudo().create({
                                'sp_shop_id': current_s_sp_shop.sudo().id,
                                's_app_id': current_app.id,
                                'status': True,
                                'token': token,
                                's_plan_id': None
                            })

                        else:
                            current_s_sp_app.sudo().write({
                                'status': True,
                                'install_status': True,
                                'token': token,
                                'is_force_update_webhook': False
                            })

                        # add user group bought together
                        group = request.env.ref('mas_trello.shopify_trello_data_group')
                        if current_user and group and current_s_sp_app:
                            if current_user.sudo().id not in group.sudo().users.ids:
                                group.sudo().users = [(4, current_user.sudo().id)]
                        # add user group plan
                        group_plan_bought_together = request.env.ref(
                            'mas_trello.shopify_trello_data_group_plan')
                        if current_user and group_plan_bought_together:
                            if current_user.sudo().id not in group_plan_bought_together.sudo().users.ids:
                                group_plan_bought_together.sudo().users = [(4, current_user.sudo().id)]
                        # create shop bought together plan submission
                        current_shop_submission = http.request.env[
                            'sp.trello.plan'].sudo().search(
                            [('s_sp_shop_id', '=', current_s_sp_shop.sudo().id)],
                            limit=1)
                        if not current_shop_submission:
                            current_shop_submission = http.request.env[
                                'sp.trello.plan'].sudo().create({
                                's_sp_shop_id': current_s_sp_shop.sudo().id,
                                's_sp_app_id': current_s_sp_app.sudo().id,
                            })

                        # check if is_first_product_data_action is False then action add queue
                        current_shop_global_setting = http.request.env['s.shopify.data.global.setting'].sudo().search(
                            [('sp_shop_id', '=', current_s_sp_shop.sudo().id),
                             ('sp_app_id', '=', current_s_sp_app.sudo().id)],
                            limit=1)
                        if not current_shop_global_setting:
                            current_shop_global_setting = http.request.env[
                                's.shopify.data.global.setting'].sudo().create({
                                'sp_shop_id': current_s_sp_shop.sudo().id,
                                'sp_app_id': current_s_sp_app.sudo().id,
                            })

                        # # action auto login
                        db = http.request.env.cr.dbname
                        request.env.cr.commit()
                        uid = request.session.authenticate(db, kw['shop'], current_s_sp_shop.password)

                        # redirectUrl = "https://thuysaas.com/blog/wp-login.php?trello_shop_name=%s?XDEBUG_SESSION_START"%( kw['shop'])
                        redirectUrl = current_app.base_url + '/strello/index2'
                        return werkzeug.utils.redirect(redirectUrl)



        except Exception as ex:
            _logger.error(traceback.format_exc())
            return werkzeug.utils.redirect('https://google.com/')

        return werkzeug.utils.redirect('https://shopify.com/')



    @http.route('/strello/af_customers_redact', type='json', auth="public", csrf=False, save_session=False)
    def registry_af_customers_redact(self):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data =  http.request.httprequest.data

        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        return 'Done'



    @http.route('/strello/af_customers_data_request', type='json', auth="public", csrf=False, save_session=False)
    def registry_af_customers_data_request(self):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data =  http.request.httprequest.data

        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.headers.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        return 'Done'

    @http.route('/strello/af_shop_redact', type='json', auth="public", csrf=False, save_session=False)
    def registry_af_shop_redact(self):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data = http.request.httprequest.data

        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.headers.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        return 'Done'


    @http.route('/strello/app_uninstalled', type='json', auth="public", csrf=False, save_session=False)
    def app_uninstalled_hook(self):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data = http.request.httprequest.data
        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.headers.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        return 'Done'
    @http.route('/strello/shop/updatee', type='json', auth="public", csrf=False, save_session=False)
    def shop_update_hook(self):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data = http.request.httprequest.data
        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.headers.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        if verified:
            x=1
