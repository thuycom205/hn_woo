import json

from werkzeug.utils import redirect

from odoo import http
from odoo.http import request
import traceback

import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)


class SpController(http.Controller):
    @http.route('/gift-registry/checkout', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def gift_registry_view(self,*kw):
        x = 1
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))
        registry_id_input = result['params']['registry_id']
        product_id = str(result['params']['product_id'])
        variant_id = str(result['params']['variant_id'])
        shop_domain = str(result['params']['shop_domain'])
        try:
            qty = int(result['params']['qty'])
        except Exception as e:
            qty = 1

        # registry_id = int(registry_id_input)
        registry_id = registry_id_input

        item = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)
        itemx = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search(
            [('registry_id', '=', registry_id), ('variant_id', '=', variant_id)],limit=1)

        if not item:
            return
        if not itemx:
            return

        current_app = request.env.ref('s_shopify_registry.s_shopify_registry_app').sudo()
        current_s_sp_shop = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shop_domain)], limit=1)
        app = http.request.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)])

        # s.sp.app token
        # token = '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'
        session = shopify.Session(shop_domain, current_app.sp_api_version, app.token)
        # session = shopify.Session(shop_domain, current_app.sp_api_version, token)
        shopify.ShopifyResource.activate_session(session)

        address1 = item.sa_street
        # company = item.sa_company
        # if company == False:
        #     company = ''
        company = ''
        country = item.sa_country
        sa_country_code = item.sa_country_code
        sa_first_name = item.sa_first_name
        sa_last_name = item.sa_last_name

        sa_phone= item.sa_phone
        sa_city = item.sa_city
        sa_zip = item.sa_zip

        sa_province = item.sa_province
        sa_province_code = item.sa_province_code

        # sa_city_code= item.sa_city_code
        name = '%s %s' %(sa_first_name,sa_last_name)

        vals = {}

        vals['note_attributes'] = [{
            "name": "ap_registry",
            "value": str(registry_id)
        }]

        vals['note'] = 'Gift Registry'

        vals['shipping_address'] = {}
        vals['shipping_address'] = {
              "address1": address1,
              "address2": "",
              "city": sa_city,
              "country":country,
              "country_code": sa_country_code,
              "first_name": sa_first_name,
              "last_name": sa_last_name,
              "phone": sa_phone,
              "zip": sa_zip,
              "name": name,

              "province": sa_province,
              "province_code": sa_province_code
            }
        # vals['shipping_address'] = {
        #       "address1": address1,
        #       "address2": "",
        #       "city": 'Hanoi',
        #       "company":company,
        #       "country":'Canada',
        #       "first_name": sa_first_name,
        #       "last_name": sa_last_name,
        #       "phone": sa_phone,
        #       "province": 'Ontario',
        #       "zip": 'K2P0V6',
        #       "name": name,
        #       "country_code":'CA',
        #        "province_code": "ON"
        #
        #     # "province_code": sa_city_code
        #     }

        line_items = []
        item = {
            'variant_id': int(variant_id),
            'quantity': qty
        }
        line_items.append(item)
        vals['line_items'] = line_items


        vals['note'] = 'Gift Registry'

        checkout = shopify.DraftOrder.create(vals)
        order_id = checkout.attributes['id']

        registryObj = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().search([('id','=',registry_id)],limit=1)

        vals ={
            'registry_id' : registry_id,
            'order_id':order_id,
            'note' :'Gift Registry Order',

        }
        http.request.env['s_shopify_registry.s_shopify_registry_order'].sudo().create(vals)
        return {'checkout': checkout.attributes}


