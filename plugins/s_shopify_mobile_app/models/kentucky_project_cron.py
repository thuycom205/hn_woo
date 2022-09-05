import json

import requests

from odoo import models


class KentuckyProjectCron(models.Model):
    _name = 'kentucky.project.cron'

    def update_stock_location_file(self, api_base_url, theme_id):
        if api_base_url:
            try:
                a = []
                list_product = []
                list_location = []
                info_location_levels = []
                data_need_save = []
                # get all product
                page_info = ""
                param_request = '?limit=250&status=active'
                while page_info != -1:
                    product_api_url = api_base_url + "/admin/api/2021-10/products.json" + param_request
                    response = requests.request("GET", product_api_url, headers={}, data={})
                    data = response.json()
                    if 'products' in data:
                        product_data = data['products']
                        if len(product_data) > 0:
                            list_product += product_data
                        link = response.headers.get('Link')
                        if not link or not isinstance(link, str):
                            break
                        else:
                            if link.find('next') > 0:
                                for page_link in link.split(','):
                                    if page_link.find('next') > 0:
                                        page_info = page_link.split(';')[0].strip('<>').split('page_info=')[1]
                                        param_request = '?limit=250&page_info=' + page_info
                            else:
                                page_info = -1
                                break
                if len(list_product) > 0:
                    # get all location id
                    location_api_url = api_base_url + "/admin/api/2021-10/locations.json?limit=250"
                    response = requests.request("GET", location_api_url, headers={}, data={})
                    data = response.json()
                    if 'locations' in data:
                        location_id_data = data['locations']
                        if len(location_id_data) > 0:
                            for location in location_id_data:
                                list_location.append(str(location['id']))
                    if len(list_location) > 0:
                        # get all information location levels
                        page_info = ""
                        param_request_level = '?limit=250&location_ids=' + ','.join(list_location)
                        while page_info != -1:
                            location_level_api_url = api_base_url + "/admin/api/2021-10/inventory_levels.json" + param_request_level
                            response = requests.request("GET", location_level_api_url, headers={}, data={})
                            data = response.json()
                            if 'inventory_levels' in data:
                                inventory_levels_data = data['inventory_levels']
                                if len(inventory_levels_data) > 0:
                                    info_location_levels += inventory_levels_data
                                link = response.headers.get('Link')
                                if not link or not isinstance(link, str):
                                    break
                                else:
                                    if link.find('next') > 0:
                                        for page_link in link.split(','):
                                            if page_link.find('next') > 0:
                                                page_info = page_link.split(';')[0].strip('<>').split('page_info=')[1]
                                                # print(page_info)
                                                param_request_level = '?limit=250&page_info=' + page_info
                                    else:
                                        page_info = -1
                                        break
                if len(info_location_levels) > 0:
                    # for từng location
                    for location_id in list_location:
                        list_product_related = []
                        # for từng sản phẩm
                        for product in list_product:
                            total_quantity = 0
                            # for từng variant của sản phẩm
                            if 'variants' in product and product['variants']:
                                for variant in product['variants']:
                                    # for từng record trong list location levels
                                    for location_level in info_location_levels:
                                        if location_level['location_id'] == int(location_id):
                                            # tìm những location levels của variant của sản phẩm
                                            if location_level['inventory_item_id'] == variant['inventory_item_id']:
                                                quantity = location_level['available']
                                                if quantity != None:
                                                    total_quantity += quantity
                            if total_quantity > 0:
                                a.append(product['id'])
                            list_product_related.append({"product_id": product['id'], "quantity": total_quantity})
                        data_need_save.append({"location_id": int(location_id), "products": json.dumps(list_product_related)})
                #print(len(a))
                if len(data_need_save) > 0:
                    # update data_need_save to stock location file in shopify
                    url_update_asset = api_base_url + "/admin/api/2021-10/themes/" + str(theme_id) + "/assets.json"
                    payload = {"asset": {"key": "assets/stock_location.js", "value": json.dumps(data_need_save)}}
                    response = requests.request("PUT", url_update_asset, headers={'Content-Type': 'application/json'},
                                                data=json.dumps(payload))
                    # save log
                    log_val = {
                        'type': 'server',
                        'name': 'Logging: update stock location file (Kentucky shopify)',
                        'path': 'models/kentucky_project_cron.py',
                        'line': 106,
                        'func': 'update_stock_location_file',
                        'message': json.dumps(response.json()) + '\n' + 'status: ' + str(response.status_code)
                    }
                    self.env['ir.logging'].sudo().create(log_val)
            except Exception as e:
                print(str(e))
