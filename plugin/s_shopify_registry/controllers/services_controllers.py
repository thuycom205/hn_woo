import json
import re

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
    @http.route('/get-gift-registry/customer', auth='public',type='json', methods=['POST', 'GET', 'OPTIONS'],csrf=False, cors='*')
    def get_registry_list(self,*kw):
        k= http.request.httprequest.data
        form= http.request.httprequest.form
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))
        customer_id = result['params']['customer_id']
        shop_domain = result['params']['shop_domain']

        collection = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().search([('customer_id', '=', customer_id)])
        output = []
        if len(collection)> 0:

            result = {}

            for item in collection:
                output.append({
                    'id': item.id,
                    'title': item.title,
                    'customer_email': item.customer_email,
                    'customer_id': item.customer_id,
                    'status': item.status,
                    'public_message': item.public_message,
                    'registrant_first_name': item.registrant_first_name,
                    'registrant_last_name': item.registrant_last_name,
                    'registrant_email': item.registrant_email,
                    'event_date': item.event_date,
                    'event_location': item.event_location,
                    'is_public': item.is_public,
                    'password': item.password,
                    'sa_first_name': item.sa_first_name,
                    'sa_last_name': item.sa_last_name,
                    'sa_phone': item.sa_phone,
                    'sa_city': item.sa_city,
                    'sa_street': item.sa_street,
                    'sa_zip': item.sa_zip,
                })
            return output
        else:
            return output.append({'status' : 'empty'})
    @http.route('/get-gift-registry/by_id', auth='public',type='json', methods=['POST', 'GET', 'OPTIONS'],csrf=False, cors='*')
    def get_registry_by_id(self, *kw):
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))
        registry_id_input = result['params']['registry_id']
        registry_id = int(registry_id_input)

        output = []
        result = {}
        item = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)
        itemx = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search([('registry_id' ,'=', registry_id)])
        orders = http.request.env['s_shopify_registry.s_shopify_registry_order'].sudo().search([('registry_id' ,'=', registry_id)])
        arr_registry_item = []
        arr_order_item = []


        if True :
            for registry_item in itemx :
                arr_registry_item.append(
                    {
                     'name':registry_item.name,
                     'qty': registry_item.qty,
                     'product_img_url':registry_item. product_img_url,
                     'priority':registry_item. priority,
                     'price':registry_item. price,
                     'status':registry_item. status,
                     'id':registry_item. id,
                     'product_id': registry_item.product_id,
                     'variant_id': registry_item.variant_id,
                     'variant_title' : registry_item.variant_title,
                     'product_type': registry_item.product_type,
                      'option': registry_item.option

                    }
                )

        if True :
            for order_item in arr_order_item :
                arr_order_item.append(
                    {
                     'name' :order_item.name,
                     'order_id': order_item.order_id,
                     'create_date': order_item.create_date,
                     'note': order_item.note,
                     'id': order_item.id,
                    }
                )

        if (True):
            result['registry'] = {
                'id': item.id,
                'title': item.title,
                'customer_email': item.customer_email,
                'customer_id': item.customer_id,
                'status': item.status,
                'public_message': item.public_message,
                'registrant_first_name': item.registrant_first_name,
                'registrant_last_name': item.registrant_last_name,
                'registrant_email': item.registrant_email,
                'event_date': item.event_date,
                'event_location': item.event_location,
                'is_public': item.is_public,
                'password': item.password,
                'sa_first_name': item.sa_first_name,
                'sa_last_name': item.sa_last_name,
                'sa_phone': item.sa_phone,
                'sa_country': item.sa_country,
                'sa_country_code': item.sa_country_code,
                'sa_city': item.sa_city,
                'sa_city_code': item.sa_city_code,
                'sa_street': item.sa_street,
                'sa_zip': item.sa_zip,
                'sa_province': item.sa_province,
                'sa_province_code': item.sa_province_code,
            }
            result['items']  = arr_registry_item
            result['orders']  = arr_order_item

            return result

        else:
            return output.append({'result': 'empty'})

    @http.route('/giftregistry/search_product', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def search_product(self, *kw):
        x = 1
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))

        shopify_url = result['shop_domain']

        pr = result['param']
        pr = pr['query']
        # registry_id = result['params']['registry_id']
        #todo : get the shopify url
        current_app = request.env.ref('s_shopify_registry.s_shopify_registry_app').sudo()
        current_s_sp_shop = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shopify_url)], limit=1)
        app = http.request.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_s_sp_shop.sudo().id) ,('s_app_id', '=', current_app.id)])

         #s.sp.app token
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
                    }
                }
            }    
        } 
        '''% pr

        output = []
        product_ids = []
        result = client.execute(query)
        seo_data = json.loads(result)
        edges = seo_data['data']['products']['edges']
        for node in edges:
            id =  node['node']['id']
            temp = re.findall(r'\d+', id)
            res = list(map(int, temp))
            refined_id =res[0]
            title = node['node']['title']
            output.append({'title':title, 'id' :refined_id })

            productId = int(refined_id)
            product_ids.append(productId)

        # sproducts = shopify.Product.find(ids=product_ids)
        sproducts = shopify.Product.find(limit=200, **{'ids': '6999291003047,6999291363495'})


        for sproduct in sproducts:
            variants = sproduct.attributes['variants']

            if len(variants) > 0:
                x = 1
            else:
                x = 2
            for variant in variants:
                price = variant.attributes['price']
                variant_id = variant.attributes['id']
        return output



    # output['existed_single_product'] =[{'product_id':'1', 'variant_id' :'2', 'price' : '10', 'product_img':'' },{} ,{}]
    # output['existed_variant_product'] =[{'product_id':'1', 'variant_ids' :['2', '3']},{} ,{}]
    # output['existed_variant_product'] =[{'product_id':'1', 'variant_ids' :[{'variant_id':'2', 'price' : '10', 'variant_tile' : 'T-shirt'},{'variant_id':'2', 'price' : '10', 'variant_tile' : 'T-shirt'}]}]
    # output['new_variant_product']
    # output['new_single_variant_product']

    # output['existed_variant_product'] = [{'product_id': '1', 'variant_ids': [{'variant_id'} ,{}]}]
    # output['new_variant_product']
    @http.route('/giftregistry/save_gift_registry_item', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def save_gift_registry_item(self,*kw):

        payloadRaw = json.loads(str(http.request.httprequest.data, 'utf-8'))
        products = payloadRaw['params']['products']
        shop_domain = payloadRaw['params']['shop_domain']
        customer_id = payloadRaw['params']['customer_id']
        registry_id = payloadRaw['params']['registry_id']
        product_ids = []
        for item in products:
            product_ids.append(str(item['id']))


        #todo
        # shop_domain = 'shop_domain'
        # registry_id = 23



        x=1
        current_app = request.env.ref('s_shopify_registry.s_shopify_registry_app').sudo()
        current_s_sp_shop = http.request.env['s.sp.shop'].sudo().search([('base_url', '=', shop_domain)], limit=1)
        app = http.request.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)])

        # s.sp.app token
        # token = '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'
        session = shopify.Session(shop_domain, current_app.sp_api_version, app.token)
        shopify.ShopifyResource.activate_session(session)

        # session = shopify.Session(shop_domain, current_app.sp_api_version, token)
        # sproducts = shopify.Product.find(ids=product_ids)
        joined_string = ",".join(product_ids)
        joined_str = str(joined_string)
        # sproducts = shopify.Product.find(limit=200, **{'ids': '6999291003047,6999291363495'})

        # sproducts = shopify.Product.find(limit=200, **{'ids': str('6999291003047,6999291363495')})


        sproducts = shopify.Product.find(limit=200, **{'ids': joined_str})

        output = {}
        existed_single_product = []
        existed_variant_product= []
        new_variant_product = []
        new_single_product = []


        for sproduct in sproducts:
            productDict = {}

            s_product_id = sproduct.attributes['id']

            productDict['product_id'] = s_product_id
            images = sproduct.attributes['images']
            image_f = images[0]
            src = image_f.attributes['src']
            productDict['product_img_url'] = src

            variants =  sproduct.attributes['variants']



            if len(variants) == 1:
                variantOnly = variants[0]
                variant_id = variantOnly.attributes['id']
                productDict['price'] = variantOnly.attributes['price']
                productDict['name'] = sproduct.attributes['title']

                #whether the variant id already exist in the database
                existing_item = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search([('id', '=', registry_id) ,('product_id', '=', registry_id) ,('variant_id', '=', variant_id) ])
                productDict['variant_id'] = variant_id
                if not existing_item:
                    new_single_product.append(productDict)
                else:
                    existed_single_product.append(productDict)

            else:
                productDict['variant_ids'] = []
                new_list = []
                exist_list = []
                for variant in variants:
                    varianDic = {}
                    price = variant.attributes['price']
                    variant_id = variant.attributes['id']
                    variant_title = variant.attributes['title']
                    varianDic['variant_id' ]= variant_id
                    varianDic['price'] = price
                    varianDic['variant_title'] = variant_title

                    existing_item = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search([('id', '=', registry_id) ,('product_id', '=', registry_id) ,('variant_id', '=', variant_id) ])
                    if not existing_item:
                        varianDic['variant_new'] = True
                    else :
                        varianDic['variant_new'] = False
                    productDict['variant_ids'].append(varianDic)
                #end of for

                for item in productDict['variant_ids']:
                    if (item['variant_new']) :
                        new_list.append(item)
                    else:
                        exist_list.append(item)
                #p
                #process to clasify the variant product
                if len(new_list) > 0:
                    new_variant_product.append({'product_id':s_product_id,'product_img_url':src ,'name' : sproduct.attributes['title'], 'variant_ids': new_list})
                else:
                    existed_variant_product.append({'product_id':s_product_id,'product_img_url':src, 'name' : sproduct.attributes['title'],'variant_ids': exist_list})

        output['existed_single_product'] = existed_single_product

        # output['new_variant_product'] =new_variant_product
        output['existed_variant_product'] = existed_variant_product

        vals = []
        if len(new_variant_product) > 0:
            for item in new_variant_product:
                vals.append({
                    'name': item['name'],
                    'qty' : 1,
                    'priority': '1',
                    'product_img_url': item['product_img_url'],
                    'product_type': 'variant',
                    'status': 'not_finish',
                    'registry_id': registry_id,
                    'product_id': item['product_id'],
                    'option': json.dumps(item['variant_ids'])
                })
            try :
                registry_items = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().create(vals)
                added_variant_product = []
                for item in registry_items:
                    added_variant_product.append(
                        {
                            'title': item.name,
                            'name': item.name,
                            'qty': item.qty,
                            'priority': item.priority,
                            'id': item.id,
                            'product_img_url': item.product_img_url,
                            'variant_id': item.product_img_url,
                            'status': 'not_finish',
                            'option': item.option,
                            'product_type' : item.product_type
                        }
                    )
                output['new_variant_product'] = added_variant_product
            except Exception as ex:
                print(type(ex))



        vals=[]
        if len(new_single_product) > 0:
            for item in new_single_product:
                vals.append({
                    'registry_id' : registry_id,
                    'name': item['name'],
                    'product_id': item['product_id'],
                    'qty':1,
                    'variant_id' : item['variant_id'],
                    'price': item['price'],
                    'priority': '1',
                    'status': 'active',
                    'product_img_url' : item['product_img_url'],
                    'product_type':'simple'
                })

            registry_items = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().create(vals)
            added_single_product = []
            for item in registry_items:
                added_single_product.append(
                    {
                        'title': item.name,
                        'name': item.name,
                        'qty': item.qty,
                        'priority': item.priority,
                        'id': item.id,
                        'price': item.price,
                        'product_img_url': item.product_img_url,
                        'variant_id': item.variant_id,
                        'status': item.status ,
                        'product_type' : item.product_type
                    }
                )
            output['new_single_product'] = added_single_product

        return output

    @http.route('/gift-registry/edit_item', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def edit_item(self,*kw):
        try:
            payloadRaw = json.loads(str(http.request.httprequest.data, 'utf-8'))
            item_id = payloadRaw['params']['item_id']
            qty = payloadRaw['params']['qty']
            priority = payloadRaw['params']['priority']
            product_type = payloadRaw['params']['product_type']


            if product_type =='single':
                item = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().browse(int(item_id))
                item.write({
                    'qty': qty,
                    'priority' : priority
                })

            if product_type =='variant':
                variant_id = payloadRaw['params']['variant_id']
                item = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().browse(int(item_id))

                if not item:
                    return
                for i in item:
                    option = i.sudo().option
                    optionList = json.loads(option)
                    for variant in optionList:
                        if (int(variant['variant_id']) ==  int(variant_id)):
                            x = 1
                            editItem = i.sudo().write({
                                'qty':qty,
                                'priority':priority,
                                'variant_id':variant_id,
                                'variant_title' : variant['variant_title'],
                                'price' : variant['price'],
                                'status': 'active'
                            } )
            return 'success'
        except Exception as exeption:
            print(type(exeption))
            return 'exception'



    @http.route('/delete-gift-registry/by_id', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def delete_gift_registry(self, *kw):
        payloadRaw = json.loads(str(http.request.httprequest.data, 'utf-8'))
        registry_id = int(payloadRaw['params']['registry_id'])
        customer_id = payloadRaw['params']['customer_id']
        customer_idStr= str(customer_id)

        registry = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().search([('customer_id','=',customer_idStr),('id','=',registry_id)],limit=1)

        if registry:
            registry.unlink()

    @http.route('/giftregistry/delete_item', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'],
                csrf=False, cors='*')
    def giftregistry_delete_item(self, *kw):
        try:
            payloadRaw = json.loads(str(http.request.httprequest.data, 'utf-8'))
            item_id = int(payloadRaw['params']['item_id'])
            customer_id = payloadRaw['params']['customer_id']
            customer_idStr= str(customer_id)

            item = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search(
                [ ('id', '=', item_id)], limit=1)

            if item:
                item.unlink()

        except Exception as ex:
            print(type(ex))

    @http.route('/get-gift-registry-public/by_id', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'], csrf=False,
                cors='*')
    def get_registry_public_by_id(self, *kw):
        result = json.loads(str(http.request.httprequest.data, 'utf-8'))
        registry_id_input = result['params']['registry_id']
        registry_id = int(registry_id_input)

        output = []
        result = {}
        item = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)
        itemx = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search(
            [('registry_id', '=', registry_id),('status','=','active')])
        orders = http.request.env['s_shopify_registry.s_shopify_registry_order'].sudo().search(
            [('registry_id', '=', registry_id)])
        arr_registry_item = []
        arr_order_item = []

        if True:
            for registry_item in itemx:
                arr_registry_item.append(
                    {
                        'name': registry_item.name,
                        'qty': registry_item.qty,
                        'product_img_url': registry_item.product_img_url,
                        'priority': registry_item.priority,
                        'price': registry_item.price,
                        'status': registry_item.status,
                        'id': registry_item.id,
                        'product_id': registry_item.product_id,
                        'variant_id': registry_item.variant_id,
                        'variant_title': registry_item.variant_title,
                        'product_type': registry_item.product_type,
                        'option': registry_item.option

                    }
                )

        if True:
            for order_item in arr_order_item:
                arr_order_item.append(
                    {
                        'name': order_item.name,
                        'order_id': order_item.order_id,
                        'create_date': order_item.create_date,
                        'note': order_item.note,
                        'id': order_item.id,
                    }
                )

        if (True):
            result['registry'] = {
                'id': item.id,
                'title': item.title,
                'customer_email': item.customer_email,
                'customer_id': item.customer_id,
                'status': item.status,
                'public_message': item.public_message,
                'registrant_first_name': item.registrant_first_name,
                'registrant_last_name': item.registrant_last_name,
                'registrant_email': item.registrant_email,
                'event_date': item.event_date,
                'event_location': item.event_location,
                'is_public': item.is_public,
                'password': item.password,
                'sa_first_name': item.sa_first_name,
                'sa_last_name': item.sa_last_name,
                'sa_phone': item.sa_phone,
                'sa_city': item.sa_city,
                'sa_street': item.sa_street,
                'sa_zip': item.sa_zip,
            }
            result['items'] = arr_registry_item
            result['orders'] = arr_order_item

            return result

        else:
            return output.append({'result': 'empty'})
    @http.route('/get-gift-registry-public/by_id_public_view', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'], csrf=False,
                cors='*')
    def get_registry_public_by_id_public_view(self, *kw):
        try:
            result = json.loads(str(http.request.httprequest.data, 'utf-8'))
            registry_id_input = result['params']['registry_id']
            registry_id = int(registry_id_input)

            output = []
            result = {}
            item = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)

            if item.is_public == False and item.password:
                result['registry'] = {
                    'is_public' : False
                }

                return  result

            itemx = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search(
                [('registry_id', '=', registry_id),('status','=','active')])
            orders = http.request.env['s_shopify_registry.s_shopify_registry_order'].sudo().search(
                [('registry_id', '=', registry_id)])
            arr_registry_item = []
            arr_order_item = []

            if True:
                for registry_item in itemx:
                    arr_registry_item.append(
                        {
                            'name': registry_item.name,
                            'qty': registry_item.qty,
                            'product_img_url': registry_item.product_img_url,
                            'priority': registry_item.priority,
                            'price': registry_item.price,
                            'status': registry_item.status,
                            'id': registry_item.id,
                            'product_id': registry_item.product_id,
                            'variant_id': registry_item.variant_id,
                            'variant_title': registry_item.variant_title,
                            'product_type': registry_item.product_type,
                            'option': registry_item.option

                        }
                    )

            if True:
                for order_item in arr_order_item:
                    arr_order_item.append(
                        {
                            'name': order_item.name,
                            'order_id': order_item.order_id,
                            'create_date': order_item.create_date,
                            'note': order_item.note,
                            'id': order_item.id,
                        }
                    )

            if (True):
                result['registry'] = {
                    'id': item.id,
                    'title': item.title,
                    'customer_email': item.customer_email,
                    'customer_id': item.customer_id,
                    'status': item.status,
                    'public_message': item.public_message,
                    'registrant_first_name': item.registrant_first_name,
                    'registrant_last_name': item.registrant_last_name,
                    'registrant_email': item.registrant_email,
                    'event_date': item.event_date,
                    'event_location': item.event_location,
                    'is_public': item.is_public,
                    'password': item.password,
                    'sa_first_name': item.sa_first_name,
                    'sa_last_name': item.sa_last_name,
                    'sa_phone': item.sa_phone,
                    'sa_city': item.sa_city,
                    'sa_street': item.sa_street,
                    'sa_zip': item.sa_zip,
                }
                result['items'] = arr_registry_item
                result['orders'] = arr_order_item

                return result

            else:
                return output.append({'result': 'empty'})
        except Exception as e:
            return output.append({'message':'error happened'})    @http.route('/get-gift-registry-public/by_id_public_view', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'], csrf=False,
                cors='*')

    @http.route('/get-gift-registry-public/unlock', auth='public', type='json',
                methods=['POST', 'GET', 'OPTIONS'], csrf=False,
                cors='*')
    def get_registry_public_by_id_unlock(self, *kw):
        try:
            result = json.loads(str(http.request.httprequest.data, 'utf-8'))
            registry_id_input = result['params']['registry_id']
            password = result['params']['password']
            registry_id = int(registry_id_input)

            output = []
            result = {}
            is_show_result = False
            item = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)

            if item.is_public == False and item.password:
                if item.password == password:
                    is_show_result = True
                else :
                    is_show_result = False
            else:
                is_show_result = True

            if is_show_result:
                itemx = http.request.env['s_shopify_registry.s_shopify_registry_item'].sudo().search(
                    [('registry_id', '=', registry_id),('status','=','active')])
                orders = http.request.env['s_shopify_registry.s_shopify_registry_order'].sudo().search(
                    [('registry_id', '=', registry_id)])
                arr_registry_item = []
                arr_order_item = []

                if True:
                    for registry_item in itemx:
                        arr_registry_item.append(
                            {
                                'name': registry_item.name,
                                'qty': registry_item.qty,
                                'product_img_url': registry_item.product_img_url,
                                'priority': registry_item.priority,
                                'price': registry_item.price,
                                'status': registry_item.status,
                                'id': registry_item.id,
                                'product_id': registry_item.product_id,
                                'variant_id': registry_item.variant_id,
                                'variant_title': registry_item.variant_title,
                                'product_type': registry_item.product_type,
                                'option': registry_item.option

                            }
                        )

                if True:
                    for order_item in arr_order_item:
                        arr_order_item.append(
                            {
                                'name': order_item.name,
                                'order_id': order_item.order_id,
                                'create_date': order_item.create_date,
                                'note': order_item.note,
                                'id': order_item.id,
                            }
                        )

                if (True):
                    result['registry'] = {
                        'id': item.id,
                        'title': item.title,
                        'customer_email': item.customer_email,
                        'customer_id': item.customer_id,
                        'status': item.status,
                        'public_message': item.public_message,
                        'registrant_first_name': item.registrant_first_name,
                        'registrant_last_name': item.registrant_last_name,
                        'registrant_email': item.registrant_email,
                        'event_date': item.event_date,
                        'event_location': item.event_location,
                        'is_public': item.is_public,
                        'password': item.password,
                        'sa_first_name': item.sa_first_name,
                        'sa_last_name': item.sa_last_name,
                        'sa_phone': item.sa_phone,
                        'sa_city': item.sa_city,
                        'sa_street': item.sa_street,
                        'sa_zip': item.sa_zip,
                    }
                    result['items'] = arr_registry_item
                    result['orders'] = arr_order_item

                    return result

                else:
                    return output.append({'result': 'empty'})
            else:
                x = 1
                result['registry'] ={
                    'status': '403'
                }
                return  result

        except Exception as e:
            return output.append({'message':'error happened'})

    @http.route('/gift-registryx/save', auth='public', type='json', methods=['POST', 'GET', 'OPTIONS'], csrf=False,
                cors='*')
    def save_gift_registry(self, *kw):
        h = http.request.httprequest
        data = h.data
        form = json.loads(str(http.request.httprequest.data, 'utf-8'))

        # form = h.form
        headers = request.httprequest.headers
        # shop_domain = headers['origin']
        # base_url = shop_domain.replace("https://", "")

        registry_id = form['registry_id']
        customer_id = form['customer_id']
        base_url = form['shop_domain']

        registrant_first_name = form['registrant_first_name']
        registrant_last_name = form['registrant_last_name']
        registrant_email = form['registrant_email']
        # title = 'Title'
        title = form['event_title']
        event_date = form['event_date']
        public_message = form['public_message']
        event_location = form['event_location']
        is_public_input = form['is_public']
        password = form['password']
        # password = ''

        sa_first_name = form['sa_first_name']
        sa_last_name = form['sa_last_name']
        sa_phone = form['sa_phone']

        #this is sa_country code
        sa_country = form['sa_country']

        country_name =''
        country = request.env['s_shopify_registry.country'].sudo().search([('code', '=', sa_country)],
                                               limit=1)

        if country:
            country_name = country.name

        sa_city = form['sa_city']
        sa_street = form['sa_street']
        sa_zip = form['sa_zip']

        sa_province = form['sa_province']
        sa_province_code = form['sa_province_code']

        y = 1
        is_public = True
        if is_public_input == 1 or is_public_input =='1':
            is_public = True
        else:
            is_public = False

        current_app = request.env.ref('s_shopify_registry.s_shopify_registry_app').sudo()

        current_s_sp_shop = request.env['s.sp.shop'].sudo().search([('base_url', '=', base_url)],
                                                                   limit=1)
        current_s_sp_app = http.request.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_s_sp_shop.sudo().id), ('s_app_id', '=', current_app.id)],
            limit=1)
        id = current_app.id
        val = {
            'event_id': id,
            'sp_shop_id': current_s_sp_shop.id,
            'sp_app_id': current_s_sp_app.id,
            'customer_id': customer_id,
            'registrant_first_name': registrant_first_name,
            'registrant_last_name': registrant_last_name,
            'registrant_email': registrant_email,
            'title': title,
            'event_date': event_date,
            'event_location': event_location,
            'public_message':public_message ,
            'is_public': is_public,
            'password': password,
            'sa_first_name': sa_first_name,
            'sa_last_name': sa_last_name,
            'sa_phone': sa_phone,
            'sa_country_code': sa_country,
            'sa_country': country_name,
            'sa_city': sa_city,
            'sa_street': sa_street,
            'sa_zip': sa_zip,
            'status':'active',
            'sa_province':sa_province,
            'sa_province_code':sa_province_code
        }
        try:

            if registry_id > 0:
                registry = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().browse(registry_id)
                if registry:
                    out = []
                    registry.write(val)

                    out.append({'id': registry.id, 'status': registry.status})
                    return out
            else:
                registry = http.request.env['s_shopify_registry.s_shopify_registry'].sudo().create(val)
                if registry:
                    out = []
                    # todo : change status to selection fields
                    out.append({'id': registry.id, 'status': registry.status})
                    return out

        except Exception as ex:
            out = []
            out.append({'status': 'not-sucess'})
            return out

    @http.route('/gift-registry/get_store_status', auth='public',  type='json',methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def get_store_status(self, *kw):
        try:
            result = json.loads(str(http.request.httprequest.data, 'utf-8'))
            shop_domain = result['params']['shop_domain']
            status = request.env['s_shopify_registry.setting'].sudo().get_shop_status_by_shop_domain(shop_domain = shop_domain)
            out = []
            out.append({'status': status})
            return out
        except Exception as e:
            _logger.error(traceback.format_exc())
            out = []
            out.append({'status': True})
            return out






