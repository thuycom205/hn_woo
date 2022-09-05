# -*- coding: utf-8 -*-
import json

from werkzeug.utils import redirect

from odoo import http
from odoo.http import request
import traceback

GOOGLE_AUTH_ENDPOINT = 'https://accounts.google.com/o/oauth2/auth'
GOOGLE_TOKEN_ENDPOINT = 'https://accounts.google.com/o/oauth2/token'
GOOGLE_API_BASE_URL = 'https://www.googleapis.com'
GOOGLE_SCOPE = 'https://www.googleapis.com/auth/content'
import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)


class SpController(http.Controller):

    def is_hmac_validate(self, hmac):
        return True

    # generate permission URL
    @http.route('/shopify/auth/<string:name>', auth='public')
    def shopify_auth_name(self, name, **kw):
        if hasattr(self, 'shopify_auth_' + name):
            method = getattr(self, 'shopify_auth_' + name)
            return method(**kw)
        return "Hello, world"

    # generate token
    @http.route('/shopify/finalize/<string:name>', auth='public')
    def shopify_finalize_name(self, name, **kw):
        if hasattr(self, 'shopify_finalize_' + name):
            self.check_and_update_install_affiliate_queue(**kw)
            method = getattr(self, 'shopify_finalize_' + name)
            return method(**kw)
        return "Hello, world"

    # uri call back authen google
    @http.route('/ggf/authentication', type='http', auth="user")
    def oauth2callback(self, **kw):
        """ This route/function is called by Google when user Accept/Refuse the consent of Google """
        state = json.loads(kw['state'])
        url_return = state.get('f')
        app = state.get('n')
        app_id = request.env['s.app'].sudo().search([('name', '=', app)], limit=1).id
        user = request.env.user
        sp_shop_id = user.sudo().sp_shop_id.id
        # sp_shop_id = 1
        ##TODO fix lai duong link tra ve khi loi ( hoac raise error hay gi do )
        if kw.get('code'):
            if app_id > 0 and sp_shop_id > 0:
                s_sp_app = request.env['s.sp.app'].sudo().search([('s_app_id', '=', app_id), ('sp_shop_id', '=', sp_shop_id)],
                                                                 limit=1)
                if s_sp_app:
                    s_sp_app.sudo().get_google_token_json(authorize_code=kw['code'], current_model=state.get('m'), current_id=state.get('i'))
                    # Todo update current opening form to use newest google account

                    return redirect(url_return)
                else:
                    return redirect("%s%s" % (url_return, "?error=Unknown_error"))
            else:
                return redirect("%s%s" % (url_return, "?error=Unknown_error"))
        elif kw.get('error'):
            return redirect("%s%s%s" % (url_return, "?error=", kw['error']))
        else:
            return redirect("%s%s" % (url_return, "?error=Unknown_error"))

    # generate permission URL
    # @http.route('/shopify_data/webhook/<string:shop>/<string:app>/<string:object_name>/<string:action>', type='json', auth='public')
    # def shopify_data_single_web_hook_data(self, shop, app, object_name, action, **kw):
    #     if shop and app and object_name and action:
    #         current_shop_app = request.env['s.sp.app'].sudo().search([('sp_shop_id.base_url', '=', shop), ('s_app_id.name', '=', app)], limit=1)
    #         if current_shop_app:
    #             if hasattr(self, 'shopify_' + action + '_' + object_name + '_' + app):
    #                 method = getattr(self, 'shopify_' + action + '_' + object_name + '_' + app)
    #                 # kw['shop'] = shop
    #                 return method(shop=shop, app=app, object_name=object_name, action=action, **kw)
    #     return "Hello, world"

    def is_shopify_data_valid_web_hook(self, shop, object_name, action):
        result = False
        environ = request.httprequest.headers.environ
        if 'HTTP_X_SHOPIFY_SHOP_DOMAIN' in environ and 'HTTP_X_SHOPIFY_TOPIC' in environ:
            # if environ['HTTP_X_SHOPIFY_SHOP_DOMAIN'] == shop and object_name + '/' + action == environ['HTTP_X_SHOPIFY_TOPIC']:
            if object_name + '/' + action == environ['HTTP_X_SHOPIFY_TOPIC']:
                result = True
        return result

    @http.route('/shopify_data/webhook/<string:shop>/<string:object_name>/<string:action>', type='json', auth='public', save_session=False)
    def shopify_data_web_hook_data(self, shop, object_name, action, **kw):
        if shop and object_name and action:
            if self.is_shopify_data_valid_web_hook(shop=shop, object_name=object_name, action=action):
                # current_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', shop)], limit=1)
                current_shop = request.env['s.sp.shop'].sudo().search([('id', '=', shop)], limit=1)
                if current_shop:
                    web_hook_data = json.loads(str(http.request.httprequest.data, 'utf-8'))
                    if current_shop.is_web_hook_need:
                        request.env['s.sp.web.hook.log'].sudo().create({
                            'shop_id': current_shop.id,
                            'object_name': object_name,
                            'action': action,
                            'data': json.dumps(web_hook_data)
                        })
                    web_hook_model = request.env['s.sp.web.hook'].sudo()
                    if hasattr(web_hook_model, 'shopify_web_hook_' + object_name + '_' + action):
                        method = getattr(web_hook_model, 'shopify_web_hook_' + object_name + '_' + action)
                        return method(shop=current_shop, object_name=object_name, action=action, data=web_hook_data)
        return "Hello, world"

    @http.route('/shopify_data/webhook/app/uninstalled/<string:app>/<string:shop>', type='json', auth='public', save_session=False)
    def shopify_data_web_hook_data_per_app(self, app, shop, **kw):
        if shop:
            if self.is_shopify_data_valid_web_hook(shop=shop, object_name='app', action='uninstalled'):
                # current_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', shop)], limit=1)
                current_shop = request.env['s.sp.shop'].sudo().search([('id', '=', shop)], limit=1)
                if current_shop:
                    web_hook_data = json.loads(str(http.request.httprequest.data, 'utf-8'))
                    if current_shop.is_web_hook_need:
                        request.env['s.sp.web.hook.log'].sudo().create({
                            'shop_id': current_shop.id,
                            'object_name': 'app',
                            'action': 'uninstalled',
                            'data': json.dumps(web_hook_data)
                        })
                    web_hook_model = request.env['s.sp.web.hook'].sudo()
                    if hasattr(web_hook_model, 'shopify_web_hook_app_uninstalled'):
                        method = getattr(web_hook_model, 'shopify_web_hook_app_uninstalled')
                        self.check_and_update_uninstalled_affiliate_queue(shop=shop, app=app)
                        return method(shop=current_shop, object_name='app', action='uninstalled', data=web_hook_data, app=app)
        return "Hello, world"

    def check_and_update_install_affiliate_queue(self, **kw):
        try:
            # check module s_shopify_affiliate_queue installed
            affiliate_queue_module_installed = request.env['ir.module.module'].sudo().search([('name', '=', 's_shopify_affiliate_queue'), ('state', '=', 'installed')])
            if affiliate_queue_module_installed:
                s_affiliate_queue_apps = request.env['s.affiliate.queue.app'].sudo().search([])
                if s_affiliate_queue_apps:
                    for s_affiliate_queue_app in s_affiliate_queue_apps:
                        if request.httprequest.cookies and request.httprequest.cookies.get('mgn_affiliate_' + str(s_affiliate_queue_app.name)):
                            ref_code = request.httprequest.cookies.get('mgn_affiliate_' + str(s_affiliate_queue_app.name))
                            affiliate_existed = request.env['s.affiliate.queue'].sudo().search([('shop', '=', kw['shop']), ('app', '=', s_affiliate_queue_app.name)], limit=1)
                            if not affiliate_existed:
                                # get api key, secret key, shop token
                                # current_app = request.env.ref(str(s_affiliate_queue_app.module_name) + "." + str(s_affiliate_queue_app.s_app_id)).sudo()
                                current_app = s_affiliate_queue_app.s_app_id
                                if current_app:
                                    # shopify.Session.setup(
                                    #     api_key=current_app.sp_api_key,
                                    #     secret=current_app.sp_api_secret_key)
                                    # shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                                    # token = shopify_session.request_token(kw)
                                    # shopify.ShopifyResource.clear_session()
                                    # if not affiliate_existed:
                                    affiliate_existed = request.env['s.affiliate.queue'].sudo().create({
                                        'ref_code': ref_code,
                                        'shop': kw['shop'],
                                        'app': s_affiliate_queue_app.name,
                                        'is_installed': True,
                                        'token': False,
                                        's_api_key': current_app.sp_api_key,
                                        's_secret_key': current_app.sp_api_secret_key,
                                        's_api_version': current_app.sp_api_version,
                                        'is_transferred': False,
                                        'kwargs': json.dumps(kw),
                                    })
                            else:
                                current_app = s_affiliate_queue_app.s_app_id
                                if current_app:
                                    # shopify.Session.setup(
                                    #     api_key=current_app.sp_api_key,
                                    #     secret=current_app.sp_api_secret_key)
                                    # shopify_session = shopify.Session(kw['shop'], current_app.sp_api_version)
                                    # token = shopify_session.request_token(kw)
                                    # shopify.ShopifyResource.clear_session()
                                    # if not affiliate_existed:
                                    affiliate_existed = request.env['s.affiliate.queue'].sudo().write({
                                        'ref_code': ref_code,
                                        'shop': kw['shop'],
                                        'app': s_affiliate_queue_app.name,
                                        'is_installed': True,
                                        'token': False,
                                        's_api_key': current_app.sp_api_key,
                                        's_secret_key': current_app.sp_api_secret_key,
                                        's_api_version': current_app.sp_api_version,
                                        'is_transferred': False,
                                        'kwargs': json.dumps(kw),
                                    })
        except Exception as ex:
            _logger.error(traceback.format_exc())

    def check_and_update_uninstalled_affiliate_queue(self, shop, app):
        try:
            # check module s_shopify_affiliate_queue installed
            affiliate_queue_module_installed = request.env['ir.module.module'].sudo().search([('name', '=', 's_shopify_affiliate_queue'), ('state', '=', 'installed')])
            if affiliate_queue_module_installed:
                affiliate_existed = request.env['s.affiliate.queue'].sudo().search([('shop', '=', shop), ('app', '=', app)], limit=1)
                if affiliate_existed:
                    affiliate_existed.is_installed = False
                    affiliate_existed.is_transferred = False
        except Exception as ex:
            _logger.error(traceback.format_exc())

    # Render relate app
    @http.route('/af/related_apps_preview', type='http', auth="public")
    def add_bundle_button_preview(self):
        return request.render('s_base.af_related_apps')

