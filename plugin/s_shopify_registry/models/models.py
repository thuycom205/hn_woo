# -*- coding: utf-8 -*-

from odoo import models, fields, api
import logging
import traceback

_logger = logging.getLogger(__name__)


class s_shopify_registry_event(models.Model):
    _name = 's_shopify_registry.s_shopify_registry_event'
    _description = 's_shopify_registry.s_shopify_event'

    name = fields.Char()
    title = fields.Char()
    code = fields.Char()
    description = fields.Text()

    def _get_sp_app(self):
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        sp_shop_id = self.env.user.sp_shop_id.id
        sp_app = self.env['s.sp.app'].sudo().search([('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                                                    limit=1)
        return sp_app

    sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True,
                                 default=lambda self: self.env.user.sp_shop_id)
    sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App", default=_get_sp_app)

class s_shopify_registry_r(models.Model):
    _name = 's_shopify_registry.s_shopify_registry'
    _description = 's_shopify_registry.s_shopify_registry'

    event_id = fields.Many2one('s_shopify_registry.s_shopify_registry_event', string='Event')

    name = fields.Char(default='Detail')
    display_name = fields.Char(default='Detail')
    title = fields.Char()
    customer_email = fields.Char()
    customer_id = fields.Char()

    status = fields.Selection(
        string='Status',
        selection=[('active', 'Active'),
                   ('disable', 'Disable'), ],
        required=False,
        default='active')
    public_message = fields.Text()

    qr = fields.Many2many('ir.attachment', string='Qr', ondelete='cascade')
    binary = fields.Binary()

    registrant_first_name = fields.Char(string='Registrant first name')
    registrant_last_name = fields.Char(string='Registrant last name')
    registrant_email = fields.Char(string='Registrant email')

    event_date = fields.Char(string='Event')
    event_location = fields.Char(string='Event location')

    is_public = fields.Boolean(string='Is public')
    password = fields.Char(string='Password')

    sa_first_name = fields.Char(string='Shipping first name')
    sa_last_name = fields.Char(string='Shipping last name')
    sa_phone = fields.Char(string='Shipping Phone')
    sa_country= fields.Char(string='Shipping Country')
    sa_country_code= fields.Char()
    sa_city = fields.Char()
    sa_city_code = fields.Char()

    sa_province = fields.Char()
    sa_province_code = fields.Char()
    sa_street = fields.Char()
    sa_zip = fields.Char()

    item_ids = fields.One2many('s_shopify_registry.s_shopify_registry_item','registry_id')
    order_ids = fields.One2many('s_shopify_registry.s_shopify_registry_order','registry_id')

    def _get_sp_app(self):
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        sp_shop_id = self.env.user.sp_shop_id.id
        sp_app = self.env['s.sp.app'].sudo().search([('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                                                    limit=1)
        return sp_app

    sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True,
                                 default=lambda self: self.env.user.sp_shop_id)
    sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App", default=_get_sp_app)


class s_shopify_registry_item(models.Model):
    _name = 's_shopify_registry.s_shopify_registry_item'
    _description = 's_shopify_registry.s_shospify_item'

    registry_id = fields.Many2one('s_shopify_registry.s_shopify_registry' , string='Gift Registry')
    name = fields.Char()
    product_img_url = fields.Char("Product URL")
    product_id = fields.Char("Product ID")
    variant_id = fields.Char("Variant ID")
    variant_title= fields.Char("Variant Title")

    priority = fields.Selection(
        string='Priority',
        selection=[('1', '1'),
                   ('2', '2'),('2', '3'), ],
        required=True,
        default='1')
    qty = fields.Integer("Quantity")
    price = fields.Char("Price")
    purchased_qt = fields.Integer('Purchased Quantity')

    status = fields.Selection(
        string='Status',
        selection=[('active', 'OK'),
                   ('not_finish', 'Not finished yet'), ],
        required=True,
        default='active')
    product_type = fields.Selection(
        string='Product Type',
        selection=[('simple', 'Simple'),
                   ('variant', 'Variant'),
                   ('other', 'Other'),],
        required=True,
        default='simple')

    option = fields.Text()

    description = fields.Text()
    def _get_sp_app(self):
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        sp_shop_id = self.env.user.sp_shop_id.id
        sp_app = self.env['s.sp.app'].sudo().search([('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                                                    limit=1)
        return sp_app

    sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True,
                                 default=lambda self: self.env.user.sp_shop_id)
    sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App", default=_get_sp_app)

class s_shopify_registry_order(models.Model):
    _name = 's_shopify_registry.s_shopify_registry_order'
    _description = 's_shopify_registry.s_shopify_order'


    registry_id = fields.Many2one('s_shopify_registry.s_shopify_registry' , string='Gift Registry')
    name = fields.Char()
    order_id = fields.Char()
    total = fields.Char()
    customer_name = fields.Char()
    note = fields.Char()
    description = fields.Text()

    def _get_sp_app(self):
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        sp_shop_id = self.env.user.sp_shop_id.id
        sp_app = self.env['s.sp.app'].sudo().search([('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                                                    limit=1)
        return sp_app

    sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True,
                                 default=lambda self: self.env.user.sp_shop_id)
    sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App", default=_get_sp_app)

class SpRegistryPlan(models.Model):
    _name = 'sp.registry.plan'
    _rec_name = 'display_name'

    name = fields.Char(related='current_plan.sp_name')
    display_name = fields.Char(default='Plan')
    price = fields.Float(related='current_plan.sp_price')
    is_upgrade = fields.Boolean(
        string='Check upgrade',
        default=False)

    def _get_default_plan(self):
        self.sudo().s_sp_app_id = False
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        sp_shop_id = self.env.user.sudo().sp_shop_id.id
        if s_app_id and sp_shop_id:
            s_sp_app = self.env['s.sp.app'].sudo().search(
                [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                limit=1).id
            return s_sp_app

    s_sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App", default=_get_default_plan)
    s_sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True, related='s_sp_app_id.sp_shop_id')
    current_plan = fields.Many2one('s.plan', related='s_sp_app_id.s_plan_id')
class SpRegistrySetting(models.Model):
    _name = 's_shopify_registry.setting'
    _rec_name = 'display_name'
    _order = 'id asc'
    name = fields.Char(default='Setting')
    display_name = fields.Char(default='Setting')
    is_enable  = fields.Boolean(
        string='Is Enable',
        default=True)

    def _get_default_s_sp_app_registry_settings(self):
        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
        #todo :
        sp_shop_id = self.env.user.sudo().sp_shop_id.id
        if s_app_id and sp_shop_id:
            s_sp_app = self.env['s.sp.app'].sudo().search(
                [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', sp_shop_id)],
                limit=1).id
            return s_sp_app

    s_sp_app_id = fields.Many2one('s.sp.app', string='Shopify app', default=_get_default_s_sp_app_registry_settings)
    s_sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True)

    def get_shop_status_by_shop_domain(self,**kwargs):
        try:
            shop_domain  = kwargs['shop_domain']

            s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
            shop= self.env['s.sp.shop'].sudo().search([('base_url','=', shop_domain)],limit=1)
            s_sp_app = self.env['s.sp.app'].sudo().search([('s_app_id', '=', s_app_id), ('sp_shop_id', '=', shop.id)])

            if not s_sp_app:
                return True

            record = self.env['s_shopify_registry.setting'].sudo().search([('s_sp_shop_id', '=' , shop.id) , ('s_sp_app_id', '=' , s_sp_app.id)],limit=1)
            if record:
                return record.is_enable
            else:
                return True
        except Exception as e:
            _logger.error(traceback.format_exc())

            return True

    @api.model
    def create(self, vals):
        if 's_sp_shop_id' not in vals or not vals['s_sp_shop_id']:
            current_user = self.env.uid
            user = self.env['res.users'].browse(current_user)

            if user.sp_shop_id:
                s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
                s_sp_app = self.env['s.sp.app'].sudo().search(
                    [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', user.sp_shop_id.id)])

                record = self.sudo().search([('s_sp_app_id', '=', s_sp_app.id), ('s_sp_shop_id', '=', user.sp_shop_id.id)],limit=1)
                if record:
                    record.write(vals)
                    return record
                else :
                    if user.is_client:
                        vals['s_sp_shop_id'] = user.sp_shop_id.id
                        s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id


                        s_sp_app = self.env['s.sp.app'].sudo().search(
                            [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', user.sp_shop_id.id)],
                            limit=1).id
                        vals['s_sp_app_id'] =s_sp_app
                        record = super(SpRegistrySetting, self).create(vals)
                        return record

    def write(self, vals):
        current_user = self.env.uid
        user = self.env['res.users'].browse(current_user)

        if user.sp_shop_id:
            s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
            s_sp_app = self.env['s.sp.app'].sudo().search(
                [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', user.sp_shop_id.id)])

            record = self.sudo().search([('s_sp_app_id', '=', s_sp_app.id), ('s_sp_shop_id', '=', user.sp_shop_id.id)],limit=1)
            if record:
                vals['id'] = record.id

        record = super(SpRegistrySetting, self).write(vals)
        return record

    # def read(self, fields=None, load='_classic_read'):
    #     x =1
    #     return super(SpRegistrySetting, self).read(fields, load=load)

    def search_read(self, domain=None, fields=None, offset=0, limit=None, order=None):
        current_id = self.env['res.users'].sudo().search([('id', '=', self.env.uid)])
        shop_id = current_id.sp_shop_id

        if shop_id:
            domain = ([('s_sp_shop_id', '=', shop_id)])
        return super(SpRegistrySetting, self).search_read(domain=domain, fields=fields,
                                                           offset=offset, limit=limit, order=order)
    def get_setting_id(self,**kwargs):
        user_id = kwargs['user_id']
        current_user = self.env.uid
        user = self.env['res.users'].browse(current_user)

        if user.sp_shop_id:
            s_app_id = self.env.ref('s_shopify_registry.s_shopify_registry_app').id
            s_sp_app = self.env['s.sp.app'].sudo().search(
                [('s_app_id', '=', s_app_id), ('sp_shop_id', '=', user.sp_shop_id.id)])

            record = self.sudo().search([('s_sp_app_id', '=', s_sp_app.id), ('s_sp_shop_id', '=', user.sp_shop_id.id)],limit=1)
            if record:
                return record.id
        return 0

