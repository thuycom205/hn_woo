import datetime
import traceback

import werkzeug
from dateutil.relativedelta import relativedelta

from odoo import http
import json
import logging
from odoo.http import request
import requests
from datetime import date

_logger = logging.getLogger(__name__)


class MobileApp(http.Controller):

    @http.route('/mobile_apps/data/<string:access_token>', auth="public", type="http", csrf=False, cors='*')
    def get_data_theme(self, access_token):
        try:
            rec_access_token = http.request.env['s.shopify.mobile.app.custom.design'].sudo().search(
                [('access_token', '=', access_token)])
            if rec_access_token:
                if rec_access_token.setting_public_url:
                    return rec_access_token.setting_public_url
                else:
                    return None

        except Exception as e:
            logging.exception('Error loading data shop ' + str(e))

    @http.route('/mobile_apps/<string:shop_url>', auth="public", type="http", csrf=False, cors='*', save_session=False)
    def get_data_web_mobile(self, shop_url):
        shop_id = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shop_url)])
        if shop_id:
            custom_design = http.request.env['s.shopify.mobile.app.custom.design'].sudo().search(
                [('s_sp_shop_id', '=', shop_id.id)], limit=1)
            menu = {
                'custom_js': custom_design.custom_js or '',
                'custom_css': custom_design.custom_css or '',
            }
            return json.dumps(menu)

    @http.route('/mobile_apps/add_device', type='json', csrf=False, auth="none")
    def add_device(self, **kw):
        try:
            device_id = kw['device_id']
            application = kw['application']
            base_url = kw['base_url']
            platform = kw['platform']
            current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo().id
            current_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', base_url)], limit=1)
            if platform and base_url:
                s_sp_app = request.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_shop.sudo().id),
                                                                  ('s_app_id', '=', current_app)],
                                                                 limit=1)
                if s_sp_app:
                    server_key = s_sp_app.sudo().mobile_app_firebase_key
                    url = "https://iid.googleapis.com/iid/info/" + str(device_id)
                    payload = {}
                    headers = {
                        'Authorization': 'key=' + server_key
                    }
                    response = requests.request("GET", url, headers=headers, data=payload)
                    try:
                        if not 'error' in response.json():
                            device = request.env['s.shopify.mobile.app.register.id'].sudo().search(
                                [('name', '=', device_id), ('s_sp_app_id', '=', s_sp_app.id)], limit=1)
                            if len(device) > 0:
                                pass
                            else:
                                request.env['s.shopify.mobile.app.register.id'].sudo().create({
                                    'name': device_id,
                                    's_sp_app_id': s_sp_app.id
                                })
                            return {
                                'success': True,
                                'message': 'Success'
                            }
                        else:
                            return {'success': False,
                                    'message': 'Get response error : ' + str(json.dumps(response.json()))}
                    except Exception as ex:
                        return {'success': False, 'message': {
                            'traceback': str(traceback.format_exc()),
                            'request_url': url,
                            'request_headers': json.dumps(headers),
                            'response_status': str(response.status_code),
                            'response_text': str(response.text),
                            'response_content': str(response.content)

                        }}
                else:
                    return {'success': False, 'message': 'Can not find s_sp_app'}
            else:
                return {'success': False, 'message': 'Can not get platform and base_url'}
        except Exception as ex:
            return {'success': False, 'message': str(traceback.format_exc())}

    @http.route('/mobile_apps/delete_device', type='json', csrf=False, auth="none")
    def delete_device(self, **kw):
        try:
            device_id = kw['device_id']
            application = kw['application']
            platform = kw['platform']
            base_url = kw['base_url']
            current_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', base_url)], limit=1)
            current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo().id
            if platform and base_url:
                s_sp_app = request.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_shop.sudo().id),
                                                                  ('s_app_id', '=', current_app)],
                                                                 limit=1)
                if s_sp_app:
                    request.env['s.shopify.mobile.app.register.id'].sudo().search(
                        [('name', '=', device_id), ('s_sp_app_id', '=', s_sp_app.id)], limit=1).unlink()
                    return {
                        'success': True,
                        'message': 'Success'
                    }
                else:
                    return {'success': False, 'message': 'Failed'}
            else:
                return {'success': False, 'message': 'Failed'}
        except Exception as ex:
            return {'success': False, 'message': str(traceback.format_exc())}

    @http.route('/mobile_app/plan/accept/<int:shop_app_id>/<int:plan_id>/<int:current_display_plan_id>', type='http',
                auth='public', csrf=False, save_session=False)
    def mobile_app_plan_accept(self, shop_app_id=None, plan_id=None, current_display_plan_id=None):
        shop = request.params['shop'] if 'shop' in request.params else ''
        shopify_admin = 'https://' + shop + '/admin' if shop != '' else 'https://shopify.com/'
        try:
            # if not 'charge_id' in request.params:
            #     raise Exception('Missing Charge ID. Please try again')
            if not plan_id:
                raise Exception('Missing Plan Parameter. Please try again')
            if not shop_app_id:
                raise Exception('Missing Current Shop. Please try again')
            # shop = request.session['shop_url']
            shop_app = request.env['s.sp.app'].sudo().browse(shop_app_id)
            plan = request.env['s.mobile.app.plan'].sudo().browse(plan_id)
            current_display_plan = request.env['s.shopify.mobile.app.plan'].sudo().browse(current_display_plan_id)
            if shop_app and plan:
                charge = shop_app.activate_plan(request.params['charge_id'], plan_name=plan.sp_name)
                # todo add user to app group
                current_app = request.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                if not current_app:
                    raise Exception('Could not find s_app.')
                current_user = request.env['res.users'].sudo().search([('login', '=', shop)], limit=1)
                if not current_user:
                    raise Exception('Could not find Current user.')
                current_s_sp_app = http.request.env['s.sp.app'].sudo().search(
                    [('sp_shop_id', '=', current_user.sp_shop_id.id), ('s_app_id', '=', current_app.id)], limit=1)
                if not current_s_sp_app:
                    raise Exception('Could not find Shop App')
                group = request.env.ref('s_shopify_mobile_app.shopify_mobile_app_data_group')
                if not group:
                    raise Exception('Could not find bundle data group.')
                if current_user and group and current_s_sp_app and current_s_sp_app:
                    if current_user.id not in group.sudo().users.ids:
                        group.sudo().users = [(4, current_user.id)]
                    current_display_plan.current_plan = plan_id
                if not current_display_plan.start_trial_date:
                    current_display_plan.start_trial_date = date.today()
                # BundleAccountMenu = request.env.ref('s_shopify_bundle.menu_root_client_shopify_bundle_shop_plan').id
                # BundleAccountAction = request.env.ref('s_shopify_bundle.sp_shop_bundle_product_plan_action_server_form').id
                # redirectUrl = current_app.base_url + '/web?#menu_id=' + str(
                #     BundleAccountMenu) + '&id=' + str(current_display_plan.id) + '&model=s.shopify.product.bundle.plan&view_type=form'
                # redirectUrl = current_app.base_url + '/web?#id=' + str(current_display_plan.id) + '&model=s.shopify.product.bundle.plan&view_type=form' + '&menu_id=' + str(
                #     BundleAccountMenu) + '&cids=3'
                # print(redirectUrl)
                # RootMenu = request.env.ref('s_shopify_mobile_app.menu_shopify_mobile_app_root').id
                # redirectUrl = current_app.sudo().base_url + '/web?#menu_id=' + str(
                #     RootMenu)
                # return werkzeug.utils.redirect(redirectUrl)
                if shop != '':
                    redirectUrl = 'https://' + shop + '/admin/apps/' + str(current_app.sp_api_key)
                else:
                    redirectUrl = shopify_admin
                return werkzeug.utils.redirect(redirectUrl)
        except Exception as e:
            _logger.error(traceback.format_exc())
        return werkzeug.utils.redirect(shopify_admin)

    @http.route('/shopify/mobile/redirect', type='http', csrf=False, auth="none")
    def force_top_redirect(self):
        url = request.params['url']
        return request.render('s_shopify_mobile_app.redirect_top', {
            'redirect_url': url
        })
