#/apps/gift-registry
import json
import re

from werkzeug.utils import redirect
import ssl
from odoo import http
from odoo.http import request
import traceback
import urllib.request

import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)


class LookbookController(http.Controller):
    #/lookbook/userguide
    @http.route('/lookbook/userguide', auth='public')
    def lookbook_userguide(self,**kw):
        # body = """
        # user_guide
        # """
        shop_url = http.request.env.user.sp_shop_id.base_url
        frame = 'https://app.thexseed.com/blog/wp-login.php?shop_name=' + shop_url
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

    @http.route('/lookbook/index2', auth='user')
    def lookbook_index2(self,**kw):
        shop_url = http.request.env.user.sp_shop_id.base_url
        frame = 'https://app.thexseed.com/blog/wp-login.php?shop_name=' + shop_url

        body='''
        <html>
        <iframe src="%s" style="position:fixed; top:0; left:0; bottom:0; right:0; width:%s; height:%s; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
        </html>
       ''' %(frame,'100%','100%')
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'text/html')
        ])
        return response
    @http.route('/lookbook/view/<string:id>', auth='public')
    def lookbook_view(self,id,**kw):
        context = ssl._create_unverified_context()
        url = "https://app.thexseed.com/blog/wp-admin/admin-ajax.php?action=wlb_get_lookbook_saas&id=%s" %(id)
        fp = urllib.request.urlopen(url,context=context)
        mybytes = fp.read()

        mystr = mybytes.decode("utf8")
        fp.close()
        script = ''' 
        < script
        type = "text/javascript" >

        window.customerId = "{{ customer.id }}";
        window.lcShopdomain = "{{ shop.domain }}";

           < / script >
    '''
        body = mystr + script
        # body="""
        # <html>
        # <iframe src="http://wp.local/wp-login.php?shop_name=hanetest2.myshopify.com" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
        # </html>
        # """
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'application/liquid')
        ])
        return response

    @http.route('/lookbook/search_product', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def search_product(self, *kw):
        x = 1
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))


        user = request.env.user
        username =  user.name
        user_id = request.session.uid
        shop = request.env.user.sp_shop_id
        user = request.env['res.users'].sudo().browse(
            request.session.uid)
        shopify_url = user.sp_shop_id.base_url
        # shopify_url='hanetest2.myshopify.com'

        result = json.loads(str(http.request.httprequest.data, 'utf-8'))
        pr = result['param']
        pr = pr['q']
        # registry_id = result['params']['registry_id']
        # todo : get the shopify url
        current_app = request.env.ref('mas_lookbook.s_shopify_lookbook_app').sudo()
        current_s_sp_shop = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shopify_url)], limit=1)
        app = http.request.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)])

        # s.sp.app token
        session = shopify.Session(shopify_url, current_app.sp_api_version, app.token)
        shopify.ShopifyResource.activate_session(session)
        # existing_webhooks = shopify.Product.find()

        client = shopify.GraphQL()
        query = '''
            {
              products(first: 20, query: "title:%s*") {
                  edges {
                      node {
                          id
                          title
                          description
                          handle
                      }
                  }
              }    
          } 
          ''' % pr

        output = []
        product_ids = []
        result = client.execute(query)
        seo_data = json.loads(result)
        edges = seo_data['data']['products']['edges']
        for node in edges:
            id = node['node']['id']
            temp = re.findall(r'\d+', id)
            res = list(map(int, temp))
            refined_id = res[0]
            title = node['node']['title']
            handle = node['node']['handle']
            output.append({'title': title, 'id': refined_id, 'handle':handle})

            productId = int(refined_id)
            product_ids.append(productId)

        # sproducts = shopify.Product.find(ids=product_ids)
        # # sproducts = shopify.Product.find(limit=200, **{'ids': '6999291003047,6999291363495'})
        #
        # for sproduct in sproducts:
        #     variants = sproduct.attributes['variants']
        #
        #     if len(variants) > 0:
        #         x = 1
        #     else:
        #         x = 2
        #     for variant in variants:
        #         price = variant.attributes['price']
        #         variant_id = variant.attributes['id']
        return output

