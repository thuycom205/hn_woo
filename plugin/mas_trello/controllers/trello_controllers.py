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
import requests

from odoo import http
from odoo.http import request
from ...s_base.controllers.sp_controllers import SpController
from flask import abort
import hmac
import hashlib
_logger = logging.getLogger(__name__)


class WebHookTrelloController(http.Controller):
    @http.route('/strello/log', auth='user')
    def trello_log(self, **kw):
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()

        trelloLogMenu = http.request.env['ir.ui.menu'].sudo().search(
            [('name', '=', 'Trello sync log')])

        if trelloLogMenu:
            redirectUrl = current_app.base_url + '/web?#menu_id=' + str(
                trelloLogMenu.id)
            return werkzeug.utils.redirect(redirectUrl)

    @http.route('/strello/index2', auth='user')
    def trello_index2(self,**kw):
        header = [  ('Content-Type', 'text/html')]
        if request.session.uid:
            user = request.env['res.users'].sudo().browse(request.session.uid)
            if user.sp_shop_id:
                if user.sp_shop_id.base_url:
                    shopify_url = user.sp_shop_id.base_url
                    frameAncestor = 'frame-ancestors https://%s https://admin.shopify.com' % (
                        shopify_url)
                    frameTub = ('Content-Security-Policy',frameAncestor)
                    header.append(frameTub)
        shop_url = http.request.env.user.sp_shop_id.base_url
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        base_url = current_app.base_url
        sp_env = current_app.sp_env
        base_url_dev = current_app.base_url_dev

        frame = base_url + '/blog/wp-login.php?trello_shop_name=' + shop_url

        if sp_env == 'sandbox':
            frame = base_url_dev + '/blog/wp-login.php?trello_shop_name=' + shop_url

        body='''
        <html>
        <iframe src="%s" style="position:fixed; top:0; left:0; bottom:0; right:0; width:%s; height:%s; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
        </html>
       ''' %(frame,'100%','100%')
        response = request.make_response(body, header)
        return response
    @http.route('/strello/order_paid', type='json', auth="public", csrf=False, save_session=False)
    def orders_paid(self):
        x = 1
        current_app = request.env.ref('mas_trello.s_trello_app').sudo()
        secret = current_app.sp_api_secret_key
        data = http.request.httprequest.data

        digest = hmac.new(secret.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        verified = hmac.compare_digest(computed_hmac,
                                       http.request.httprequest.headers.get('X-Shopify-Hmac-SHA256').encode('utf-8'))
        if not verified:
            abort(401)
        encoding = 'utf-8'
        paypload = str(data, encoding)
        jsonDataShop = json.loads(paypload)
        shopDomain = http.request.httprequest.headers.get('X-Shopify-Shop-Domain').encode('utf-8')

        customerName = jsonDataShop['customer']['first_name'] + ' ' +  jsonDataShop['customer']['last_name']
        billingAddress = 'Name : %s \n Phone : %s \n Address: %s  \n city: %s \n province:  %s Country: %s' \
                         %(jsonDataShop['billing_address']['name'],
                           jsonDataShop['billing_address']['phone'],
                           jsonDataShop['billing_address']['address1'] + ' '+  jsonDataShop['billing_address']['address2'],
                           jsonDataShop['billing_address']['city'],
                           jsonDataShop['billing_address']['province'],
                           jsonDataShop['billing_address']['country'],
                           )
        shippingAddress = 'Name : %s \n Phone : %s \n Address: %s  \n city: %s \n province: %s Country: %s' \
                         %(jsonDataShop['shipping_address']['name'],
                           jsonDataShop['shipping_address']['phone'],
                           jsonDataShop['shipping_address']['address1'] + ' '+  jsonDataShop['shipping_address']['address2'],
                           jsonDataShop['shipping_address']['city'],
                           jsonDataShop['shipping_address']['province'],
                           jsonDataShop['shipping_address']['country'],
                           )
        paymentMethod = jsonDataShop['payment_gateway_names'][0]
        orderTotal = jsonDataShop['total_price'] +  ' ' +  jsonDataShop['currency']
        orderNumber  = jsonDataShop['order_number']
        val = {
            'customerName': customerName,
            'billingAddress' :billingAddress,
            'shippingAddress' :shippingAddress,
            'paymentMethod' :paymentMethod,
            'orderTotal' :orderTotal,
            'shopDomain' :shopDomain,
            'orderNumber' :orderNumber
        }
        GOOGLE_TOKEN_ENDPOINT ='https://thuysaas.com/blog/wp-admin/admin-ajax.php?action=trello_sync_card'
        #GOOGLE_TOKEN_ENDPOINT =current_app.base_url + '/blog/wp-admin/admin-ajax.php?action=trello_sync_card'
        headers = {"Content-type": "application/x-www-form-urlencoded" ,"X-Shopify-Shop-Domain" : shopDomain}

        try:
            log = http.request.env['sp.trello.order'].sudo().search([('g_order_id','=', jsonDataShop['id'])],limit=1)
            if not log:
            # if True:
                req = requests.post(GOOGLE_TOKEN_ENDPOINT, data=val,json=jsonDataShop,headers=headers,verify=False)
                req.raise_for_status()
                response = req.json()
                card_url = response['url']
                http.request.env['sp.trello.order'].sudo().create({
                    'order_id': jsonDataShop['name'],
                    'customer_name': customerName,
                    'order_url': jsonDataShop['order_status_url'],
                    'g_order_id': jsonDataShop['id'],
                    'shop_domain': shopDomain,
                    'card_url': card_url
                })
        except requests.HTTPError:
            x = 1

        return 'Done'