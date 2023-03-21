import json
import re
import csv
import os
from werkzeug.utils import redirect

from odoo import http
from odoo.http import request

from odoo.http import request
import traceback

import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)

# https://stackoverflow.com/questions/4307409/copying-css-to-inline-using-jquery-or-retaining-formatting-when-copying-stuff-f
class ServiceController(http.Controller):
    @http.route('/init/country', auth='public', type='http', methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def init_country(self, *kw):
        try:
            #http.request.env['s_shopify_registry.country'].sudo().init_country()
            return 'okay'
        except Exception as ex:
            return  (type(ex))

    @http.route('/gr_search/country', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def gr_search_country(self, *kw):
        output = http.request.env['s_shopify_registry.country'].sudo().get_country()
        return output

    @http.route('/init/countryx', auth='public',type='http', methods=['POST', 'GET', 'OPTIONS'],csrf=False, cors='*')
    def init_countryx(self,*kw):
        shop_domain ='hanetest2.myshopify.com'
        current_app = request.env.ref('s_shopify_registry.s_shopify_registry_app').sudo()
        current_s_sp_shop = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shop_domain)], limit=1)
        app = http.request.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)])

        # s.sp.app token
        # token = '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'
        session = shopify.Session(shop_domain, current_app.sp_api_version, app.token)
        # session = shopify.Session(shop_domain, current_app.sp_api_version, token)
        shopify.ShopifyResource.activate_session(session)

        countries = shopify.Country.find()

        x = 1
    @http.route('/test/a', auth='public',type='http', methods=['POST', 'GET', 'OPTIONS'],csrf=False, cors='*')
    def get_registry_list(self,*kw):
        k= http.request.httprequest.data

        notex = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search([('id','=',500)])

        if notex == None:
            x = 1
        if not notex:
            x = 2
