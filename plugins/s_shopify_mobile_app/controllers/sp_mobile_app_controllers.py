# -*- coding: utf-8 -*-
import base64
import json
import logging
import os
import random
import ssl
import string
import traceback

import shopify
import werkzeug

import odoo
from odoo import http, tools
from odoo.http import request
from ...s_base.controllers.sp_controllers import SpController

ssl._create_default_https_context = ssl._create_unverified_context

_logger = logging.getLogger(__name__)

from odoo.tools import image_process
from odoo.modules import get_resource_path


class SpMobileAppController(SpController):
    def shopify_auth_s_shopify_mobile_app(self, **kw):
        # check neccessary param
        # todo validate hmac
        # todo validate shop_url
        if 'shop' in kw:
            # generate permission url
            current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo()
            if current_app:
                shopify.ShopifyResource.clear_session()
                shopify.Session.setup(
                    api_key=current_app.sp_api_key,
                    secret=current_app.sp_api_secret_key)
                shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                scope = [
                    # "read_products",
                    # "read_product_listings",
                    # "read_orders",
                    "write_themes",
                    "write_script_tags",
                ]
                redirect_uri = current_app.base_url + "/shopify/finalize/s_shopify_mobile_app"
                permission_url = shopify_session.create_permission_url(
                    scope, redirect_uri)
                return werkzeug.utils.redirect(permission_url)

        return "Hello, world"

    def shopify_finalize_s_shopify_mobile_app(self, **kw):
        try:
            # check neccessary param
            # todo validate hmac
            # todo validate shop_url
            if 'shop' in kw:
                current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo()
                if current_app:
                    shopify.Session.setup(
                        api_key=current_app.sp_api_key,
                        secret=current_app.sp_api_secret_key)
                    shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                    token = shopify_session.request_token(kw)
                    shopify.ShopifyResource.activate_session(shopify_session)
                    if token:
                        # todo check active, unactive shop
                        current_s_sp_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', kw['shop'])],
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
                                                          ianaTimezone
                                                          billingAddress {
                                                              country
                                                              firstName
                                                              lastName
                                                              name
                                                          }
                                                          domains {
                                                              url
                                                            }
                                                          primaryDomain
                                                          {
                                                              url
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
                                'base_url_2': current_shop_dict['data']['shop']['primaryDomain']['url'] or '',
                            })
                            current_user = http.request.env['res.users'].sudo().search([('login', '=', kw['shop'])],
                                                                                       limit=1)
                            if not current_user:
                                current_user = http.request.env['res.users'].sudo().create({
                                    'company_ids': [[6, False, [current_company.id]]], 'company_id': current_company.id,
                                    'active': True,
                                    'lang': 'en_US',
                                    'tz': current_shop_dict['data']['shop']['ianaTimezone'],
                                    'image_1920': False, '__last_update': False,
                                    'name': kw['shop'], 'email': current_shop_dict['data']['shop']['email'],
                                    'login': kw['shop'],
                                    'password': password_generate,
                                    'is_client': True,
                                    'action_id': False,
                                    'sp_shop_id': current_s_sp_shop.id
                                })
                            # todo add user to app group
                            # group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group_plan')
                            group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
                            if group:
                                if current_user.id not in group.sudo().users.ids:
                                    group.sudo().users = [(4, current_user.id)]
                        else:
                            # todo active shop
                            current_s_sp_shop.status = True
                            current_user = http.request.env['res.users'].sudo().search([('login', '=', kw['shop'])],
                                                                                       limit=1)
                            # todo add user to app group
                            # group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group_plan')
                            group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
                            if group:
                                if current_user.id not in group.sudo().users.ids:
                                    group.sudo().users = [(4, current_user.id)]

                            ## update shop infomation
                            client = shopify.GraphQL()
                            query = '''
                                      {
                                        shop {
                                          id
                                          name
                                          email
                                          myshopifyDomain
                                          ianaTimezone
                                          contactEmail
                                          currencyCode
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
                            current_s_sp_shop.sudo().write({
                                'name': current_shop_dict['data']['shop']['name'],
                                'base_url': kw['shop'],
                                'email': current_shop_dict['data']['shop']['email'],
                                'currency_code': current_shop_dict['data']['shop']['currencyCode'],
                                'first_name': current_shop_dict['data']['shop']['billingAddress']['firstName'] or '',
                                'country': current_shop_dict['data']['shop']['billingAddress']['country'] or '',
                                'full_name': current_shop_dict['data']['shop']['billingAddress']['name'] or '',
                                'last_name': current_shop_dict['data']['shop']['billingAddress']['lastName'] or '',
                                'base_url_2': current_shop_dict['data']['shop']['primaryDomain']['url'] or '',
                            })
                            current_user.sudo().write(
                                {
                                    'tz': current_shop_dict['data']['shop']['ianaTimezone']
                                }
                            )
                        # Get Shop Owner
                        if current_s_sp_shop and not current_s_sp_shop.shop_owner:
                            s_current_shop = shopify.Shop.current()
                            current_s_sp_shop.shop_owner = s_current_shop.attributes['shop_owner']
                        # check and create s_sp_app
                        current_s_sp_app = http.request.env['s.sp.app'].sudo().search(
                            [('sp_shop_id', '=', current_s_sp_shop.id), ('s_app_id', '=', current_app.id)], limit=1)
                        if not current_s_sp_app:
                            # todo update shop plan
                            current_s_sp_app = http.request.env['s.sp.app'].sudo().create({
                                'sp_shop_id': current_s_sp_shop.id,
                                's_app_id': current_app.id,
                                'status': True,
                                'token': token,
                                's_plan_id': None
                            })
                        else:
                            current_s_sp_app.write({
                                'status': True,
                                'install_status': True,
                                'token': token,
                                'is_force_update_webhook': False
                            })

                        # create shop mobile app plan submission
                        current_shop_submission = http.request.env['s.shopify.mobile.app.plan'].sudo().search(
                            [('sp_shop_id', '=', current_s_sp_shop.id)],
                            limit=1)
                        if not current_shop_submission:
                            current_shop_submission = http.request.env['s.shopify.mobile.app.plan'].sudo().create({
                                'sp_shop_id': current_s_sp_shop.id,
                                'sp_app_id': current_s_sp_app.id,
                            })
                        # check plan
                        current_plan = shopify.RecurringApplicationCharge.current()
                        if not current_plan:
                            if current_shop_submission and current_shop_submission.current_plan and current_shop_submission.current_plan.sp_price != 0.0:
                                free_plan = http.request.env['s.shopify.mobile.app.plan'].sudo().find_plan_by_price(0.0)
                                if free_plan:
                                    current_shop_submission.current_plan = free_plan.id

                        # existing_webhooks = shopify.Webhook.find()
                        # if not existing_webhooks or current_s_sp_app.is_force_update_webhook:
                        # script_src = current_app.base_url + "/s_shopify_mobile_app/static/src/js/mobile.js"
                        # scriptTag = shopify.ScriptTag.find(src=script_src)
                        # if not scriptTag:
                        #     script = shopify.ScriptTag(
                        #         dict(event='onload',
                        #              src=script_src)).save()
                        # add script
                        current_s_sp_app.add_script_to_shop(has_session=True)
                        # start check sales channel

                        # delete all existing webhook
                        # for webhook in existing_webhooks:
                        #     if webhook.id and 'shopify_data/webhook' in webhook.attributes[
                        #         'address'] and 's_shopify_mobile_app' in webhook.attributes['address']:
                        #         shopify.Webhook.find(webhook.id).destroy()
                        #
                        # webhooks_uninstall_response = shopify.Webhook(dict(topic="app/uninstalled",
                        #                                                    address=current_app.webhook_base_url + "/shopify_data/webhook/app/uninstalled/s_shopify_mobile_app/" +
                        #                                                            kw['shop'],
                        #                                                    format="json")).save()
                        # current_s_sp_app.is_force_update_webhook = False
                        # save web hook data

                        db = http.request.env.cr.dbname
                        request.env.cr.commit()
                        request.session.logout(keep_db=True)
                        uid = request.session.authenticate(db, kw['shop'], current_s_sp_shop.password)

                        # Resolve
                        mobileAppMenuSettingsMenu = request.env.ref(
                            's_shopify_mobile_app.menu_shopify_mobile_app_root').id
                        redirectUrl = current_app.base_url + '/web?#menu_id=' + str(
                            mobileAppMenuSettingsMenu)

                        # try:
                        #     http_sec_fetch_dest = request.httprequest.headers.environ['HTTP_SEC_FETCH_DEST']
                        #     # print(http_sec_fetch_dest)
                        #     if http_sec_fetch_dest != 'iframe':
                        #         # redirectUrl = 'https://' + kw['shop'] + '/admin/apps/s_mobile_app'
                        #         redirectUrl = 'https://' + kw['shop'] + '/admin/apps/' + current_app.sp_api_key
                        #         # print(redirectUrl)
                        #         # redirectUrl = 'https://store4-blog-integration.myshopify.com/admin/apps/s_mobile_app'
                        #         # print(redirectUrl)
                        # except Exception as ex:
                        #     a = 0
                        redirectUrl =current_app.base_url + '/mobile_app_builder/dashboard';

                        return werkzeug.utils.redirect(redirectUrl)

        except Exception as ex:
            _logger.error(traceback.format_exc())
            return werkzeug.utils.redirect('https://google.com/')

        return werkzeug.utils.redirect('https://google.com/')

        # generate permission URL
    #/lookbook/userguide
    @http.route('/mobile_app_builder/dashboard', auth='user')
    def lookbook_userguide(self,**kw):
        # body = """
        # user_guide
        # """
        current_app = http.request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')

        shop_url = http.request.env.user.sp_shop_id.base_url
        frame = current_app.sudo().base_url + '/blog/wp-login.php?mobile_shop_name=' + shop_url
        body = '''
             <html>
             <iframe src="%s" style="position:fixed; top:0; left:0; bottom:0; right:0; width:%s; height:%s; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
             </html>
            ''' % (frame, '100%', '100%')
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'text/html')
        ])
        return response
    # @http.route('/shopify_data/webhook/<string:shop>/<string:app>/<string:object_name>/<string:action>', type='json', auth='public')
    # def shopify_data_web_hook_data(self, shop, app, object_name, action, **kw):
    #     if shop and app and object and action:
    #         current_shop_app = request.env['s.sp.app'].sudo().search([('sp_shop_id.base_url', '=', shop), ('s_app_id.name', '=', 's_shopify_mobile_app')], limit=1)
    #         if current_shop_app:
    #             if hasattr(self, 'shopify_' + action + '_' + object_name + '_' + app):
    #                 method = getattr(self, 'shopify_' + action + '_' + object_name + '_' + app)
    #                 return method(**kw)
    #     return "Hello, world"

    def shopify_uninstalled_app_s_shopify_mobile_app(self, shop, app, object_name, action, **kw):
        # todo removed user group
        group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
        current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
        current_user = http.request.env['res.users'].sudo().search([('login', '=', shop)], limit=1)
        if group and current_user and current_app:
            if current_user.id in group.sudo().users.ids:
                group.sudo().users = [(3, current_user.id)]

        # update install_status s.sp.app
        if current_app and current_user.sp_shop_id:
            current_shop_app = request.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_user.sp_shop_id.id), ('s_app_id', '=', current_app.id)], limit=1)
            if current_shop_app:
                current_shop_app.install_status = False

    @http.route('/mobile_app/af_customers_redact', type='json', auth="public", csrf=False, save_session=False)
    def mobile_app_customers_redact(self):
        return 'Done'

    @http.route('/mobile_app/af_customers_data_request', type='json', auth="public", csrf=False, save_session=False)
    def mobile_app_customers_data_redact(self):
        return 'Done'

    @http.route('/mobile_app/af_shop_redact', type='json', auth="public", csrf=False, save_session=False)
    def mobile_app_shop_redact(self):
        return 'Done'


class Binary(http.Controller):

    def placeholder(self, image='placeholder.png'):
        with tools.file_open(get_resource_path('web', 'static/src/img', image), 'rb') as fd:
            return fd.read()

    @http.route('/allfetch/image2/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_2(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=0, height=0, crop=False, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/image3/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_3(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=0, height=0, crop=False, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.notification', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/icon_resize/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_4(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=512, height=512, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/feature_graphic/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_5(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=1024, height=500, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/phone_screenshot/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_6(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=320, height=180, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/phone_screenshots_2/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_7(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=180, height=320, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/table_7inch/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_8(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=320, height=180, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    @http.route('/allfetch/table_10inch/<string:field>/<string:shop>/<int:id>', type='http', auth="public")
    def content_image_9(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                        filename_field='name', unique=None, filename=None, mimetype=None,
                        download=None, width=180, height=320, crop=True, access_token=None,
                        **kwargs):
        # other kwargs are ignored on purpose
        return self._content_image_2(xmlid=xmlid, model='s.shopify.mobile.app.custom.design', id=id, field=field,
                                     filename_field=filename_field, unique=unique, filename=filename, mimetype=mimetype,
                                     download=download, width=width, height=height, crop=crop,
                                     quality=int(kwargs.get('quality', 0)), access_token=access_token)

    def _content_image_2(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                         filename_field='name', unique=None, filename=None, mimetype=None,
                         download=None, width=0, height=0, crop=False, quality=0, access_token=None,
                         placeholder='placeholder.png', **kwargs):
        status, headers, image_base64 = request.env['ir.http'].sudo().binary_content(
            xmlid=xmlid, model=model, id=id, field=field, unique=unique, filename=filename,
            filename_field=filename_field, download=download, mimetype=mimetype,
            default_mimetype='image/png', access_token=access_token)

        if status in [301, 304] or (status != 200 and download):
            return request.env['ir.http'].sudo()._response_by_status(status, headers, image_base64)
        if not image_base64:
            # Since we set a placeholder for any missing image, the status must be 200. In case one
            # wants to configure a specific 404 page (e.g. though nginx), a 404 status will cause
            # troubles.
            status = 200
            image_base64 = base64.b64encode(self.placeholder(image=placeholder))
            if not (width or height):
                width, height = odoo.tools.image_guess_size_from_field_name(field)

        image_base64 = image_process(image_base64, size=(int(width), int(height)), crop=crop, quality=int(quality))

        content = base64.b64decode(image_base64)
        headers = http.set_safe_image_headers(headers, content)
        response = request.make_response(content, headers)
        response.status_code = status
        return response
