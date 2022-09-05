# -*- coding: utf-8 -*-
import json

from odoo import models, fields, api
import shopify
import logging
import traceback

from odoo.tools import date_utils

_logger = logging.getLogger(__name__)

TYPE = [('customer', 'Customer'),
        ('order', 'Order'),
        ('product', 'Product'),
        ]


class ShopifyData(models.Model):
    _name = 's.data.preview'
    _description = 'Preview'

    name = fields.Char()
    # s_sp_search = fields.Char()
    products = fields.One2many('s.data.preview', 'preview_id')
    page = fields.Integer(store=True)
    preview_id = fields.Many2one('s.data.preview')
    s_sp_id = fields.Many2one('s.sp.app', index=True)
    # app_id = fields.Many2one('s.app', index=True)
    shopify_id = fields.Char(index=True)
    has_next_page = fields.Boolean()
    pagination = fields.Char()
    data = fields.Text()
    checked = fields.Boolean(default=False)
    record_checked = fields.Char()
    attribute = fields.Char()
    list_origin = fields.Char()
    mode = fields.Char()
    media_url = fields.Char()
    product_id = fields.Char()

    # @api.model
    # def create(self, value):
    #     pass
    #
    # def write(self, value):
    #     pass

    @api.onchange('page')
    def onchange_page(self):
        for rec in self:
            page = rec.page
            shop_app_id = rec.s_sp_id.id
            # app_id = rec.app_id.id
            if rec.name == '' or rec.name == False:
                products, has_next_page = self.load_product(page=page, shop_app_id=shop_app_id)
                if products is not None:
                    if len(products) > 1:
                        rec.products = products
                rec.has_next_page = has_next_page

    @api.onchange('name')
    def onchange_name(self):
        for rec in self:
            name = rec.name
            shop_app_id = rec.s_sp_id.id
            # app_id = rec.app_id.id
            products = self.load_product_name(name=name, shop_app_id=shop_app_id)
            if products is not None:
                if len(products) > 1:
                    rec.products = products
            rec.page = 1

    def load_product_name(self, shop_app_id=None, name=None):
        data = [(5, 0)]
        if name and name != '':
            instance = self.env['s.sp.app'].sudo().search([('id', '=', shop_app_id)])
            instance.get_shopify_session()
            query = '{products(first: 20, query: "title:%s*") {edges {node {id title handle vendor images(first: 1) {edges { node {originalSrc}}} variants(first:20) { edges { node { id title }}}}}}}' % name
            query_result = shopify.GraphQL().execute(query=query)
            query_result = json.loads(query_result)
            products = query_result['data']['products']['edges']
            check_ids = []
            checked_data = self.get_record_ids(params=self.record_checked)
            for key in checked_data:
                rec_data = json.loads(checked_data[key])
                check_ids.append(str(rec_data.get('id')))
            for product in products:
                image = ''
                list_variant = []
                variants = product['node']['variants']['edges']
                if variants:
                    list_variant = self.get_product_variants_load_product_name(variants)
                checked = str(product['node']['id'].split('/')[-1]) in check_ids
                if len(product['node']['images']) > 0:
                    if len(product['node']['images']['edges']) > 0:
                        image = product['node']['images']['edges'][0]['node']['originalSrc']
                data.append((0, 0, {
                    'name': product['node']['title'],
                    'data': json.dumps({
                        'id': product['node']['id'].split('/')[-1],
                        'title': product['node']['title'],
                        'handle': product['node']['handle'],
                        'image': image,
                        'vendor': product['node']['vendor'],
                        'variants': list_variant
                    }),
                    'media_url': image,
                    'product_id': str(product['node']['id'].split('/')[-1]),
                    'checked': checked

                }))
            # clear session
            shopify.ShopifyResource.clear_session()
        if name == '':
            data, has_next_page = self.load_product(page=1, shop_app_id=shop_app_id)
        return data

    @api.model
    def load_product(self, shop_app_id=None, page=None):
        try:
            # get shopify product
            instance = self.env['s.sp.app'].sudo().search([('id', '=', shop_app_id)])
            instance.get_shopify_session()
            products = shopify.Product.find(limit=10)
            data = [(5, 0)]
            count = 1
            if page > 1:
                while True:
                    if products.has_next_page():
                        has_next_page = True
                        products = products.next_page()
                    count += 1
                    if count == page:
                        break
            if products.has_next_page():
                has_next_page = True
            else:
                has_next_page = False
            for product in products:
                list_variant = []
                if len(product.attributes['variants']) > 0:
                    variants = product.attributes['variants']
                    if variants:
                        list_variant = self.get_product_variant_load_product(variants)
                image = ''
                if len(product.attributes.get('images')) > 0:
                    for img in product.attributes.get('images'):
                        if img.attributes.get('position') == 1:
                            image = img.attributes.get('src')
                            break
                data.append((0, 0, {
                    'name': product.attributes.get('title'),
                    'data': json.dumps({
                        'id': product.attributes.get('id'),
                        'title': product.attributes.get('title'),
                        'image': image,
                        'handle': product.attributes.get('handle'),
                        'vendor': product.attributes.get('vendor') if product.attributes.get('vendor') else '',
                        'variants': list_variant
                    }),
                    'media_url': image,
                    'product_id': str(product.attributes.get('id'))
                }))
            # clear session
            shopify.ShopifyResource.clear_session()
            return data, has_next_page
        except Exception as e:
            _logger.error(traceback.format_exc())

    def add_product(self):
        result = False
        for rec in self:
            data = self.get_record_ids(params=rec.record_checked)
            # products = rec.products.filtered(lambda s: s.checked == True)
            active = self.env[self.env.context['active_model']].browse(self.env.context['active_id'])
            list_origin_prd = []
            if rec.list_origin:
                list_origin_prd = rec.list_origin.split(',')
            if hasattr(self, '%s_add_data' % active._name.replace('.', '_')):
                result = getattr(self, '%s_add_data' % active._name.replace('.', '_'))(data, list_origin_prd, active)
        # clear data
        self.sudo().search([]).unlink()
        return result

    def get_record_ids(self, params=None):
        if params:
            data = json.loads(params)
            return data
        return {}

    def get_product_variant_load_product(self, variants):
        if variants:
            list_variant = [{'product_variant_id': 'all', 'product_variant_title': 'All'}]
            for variant in variants:
                if variant.attributes.get('title'):
                    if variant.attributes.get('title') == 'Default Title':
                        return
                    else:
                        if variant.id:
                            list_variant.append({'product_variant_id': variant.id,
                                                 'product_variant_title': variant.attributes.get('title')})
            return list_variant

    # load_product_name
    def get_product_variants_load_product_name(self, variants):
        if variants:
            list_variant = [{'product_variant_id': 'all', 'product_variant_title': 'All'}]
            for variant in variants:
                if 'node' in variant:
                    if 'id' in variant['node']:
                        product_variant_id = variant['node']['id'].split('/')[-1]
                        if 'title' in variant['node']:
                            if variant['node']['title'] == 'Default Title':
                                return
                            else:
                                if product_variant_id:
                                    list_variant.append({'product_variant_id': product_variant_id,
                                                         'product_variant_title': variant['node']['title']})
            return list_variant


class ShopifyApp(models.Model):
    _inherit = 's.sp.app'

    def action_get_popup_data(self):
        view = self.env.ref('s_base.s_data_fetch_preview_form_view_search', raise_if_not_found=False)
        return {
            'name': 'Products',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'res_model': 's.data.preview',
            'view_id': view.id,
            'views': [(view.id, 'form')],
            'target': 'new',
            'limit': 3,
            'context': {
                'default_s_sp_id': self.id,
                'default_page': 1,
                'create': False,
                'edit': False,
            },
        }
