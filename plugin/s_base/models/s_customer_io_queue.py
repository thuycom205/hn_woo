from odoo import fields, models, api
from datetime import datetime
from customerio import CustomerIO
import logging
import traceback
_logger = logging.getLogger(__name__)

class SCustomerIOQueue(models.Model):
    _name = 's.customer.io.queue'
    _description = 'Customer IO Queue'
    _rec_name = 'shop_url'

    # customer_io_id = fields.Char(string="ID")
    email = fields.Char()

    shop_name = fields.Char()
    shop_url = fields.Char()
    s_app_id = fields.Many2one('s.app')
    first_name = fields.Char()
    last_name = fields.Char()
    name = fields.Char()
    plan = fields.Char()
    uninstall = fields.Boolean(default=False)
    country = fields.Char()
    log = fields.Char()
    state = fields.Selection(
        string='State',
        selection=[('pending', 'Pending'),
                   ('done', 'Done'), ],
        required=False,
        default='pending')
    shop_create_date = fields.Datetime()

    def sync_to_customer_io(self):
        x=1
        # customers = self.sudo().env['s.customer.io.queue'].search([('state', '!=', 'done')])
        # for customer in customers:
        #     epoch = datetime.utcfromtimestamp(0)
        #     if customer.s_app_id:
        #         site_id = customer.sudo().s_app_id.customer_io_site_id
        #         api_key = customer.sudo().s_app_id.customer_io_api_key
        #         if site_id and api_key:
        #             cio = CustomerIO(site_id, api_key)
        #             try:
        #                 update_at = str(customer.write_date)
        #                 create_at = (customer.shop_create_date - epoch).total_seconds()
        #                 id = customer.id or ''
        #                 name = customer.name or ''
        #                 shop_name = customer.shop_name or ''
        #                 email = customer.email or ''
        #                 plan = customer.plan or 'Free'
        #                 country = customer.country or ''
        #                 shop_url = customer.shop_url or ''
        #                 uninstall = "True" if customer.uninstall else "False"
        #                 shop_create_date = int(customer.shop_create_date.timestamp())
        #                 cio.identify(id=id, email=email, name=name, plan=plan, shop_name=shop_name, shop_url=shop_url,
        #                              country=country, uninstall=uninstall, created_at=create_at, update_at=update_at, shop_create_date=shop_create_date)
        #                 customer.sudo().state = 'done'
        #                 self.env.cr.commit()
        #             except Exception as ex:
        #                 _logger.error(traceback.format_exc())
        #                 customer.sudo().log = str(ex)

    def force_update_customer_io_queue(self):
        x=1
        # shop_apps = self.env['s.sp.app'].sudo().search([])
        # for rec in shop_apps:
        #     existed_queue = self.env['s.customer.io.queue'].sudo().search(
        #         [('s_app_id', '=', rec.s_app_id.id), ('shop_url', '=', rec.sudo().sp_shop_id.base_url)], limit=1)
        #     if existed_queue:
        #         existed_queue.sudo().write({
        #             'shop_url': rec.sudo().sp_shop_id.base_url or '',
        #             's_app_id': rec.s_app_id.id,
        #             'plan': rec.sudo().s_plan_id.customer_io_plan_name or 'Free',
        #             'shop_name': rec.sudo().sp_shop_id.name,
        #             'state': 'pending',
        #             'email': rec.sudo().sp_shop_id.email or '',
        #             'country': rec.sudo().sp_shop_id.country or '',
        #             'shop_create_date': rec.create_date,
        #             'uninstall': False if rec.install_status else True,
        #         })
        #     else:
        #         self.env['s.customer.io.queue'].sudo().create({
        #             'shop_url': rec.sudo().sp_shop_id.base_url or '',
        #             's_app_id': rec.s_app_id.id,
        #             'plan': rec.sudo().s_plan_id.customer_io_plan_name or 'Free',
        #             'shop_name': rec.sudo().sp_shop_id.name,
        #             'state': 'pending',
        #             'email': rec.sudo().sp_shop_id.email or '',
        #             'country': rec.sudo().sp_shop_id.country or '',
        #             'shop_create_date': rec.create_date,
        #             'uninstall': False if rec.install_status else True,
        #         })

    def force_update_customer_io_action_server(self):
        for rec in self:
            rec.sudo().write({
                'state': 'pending',
            })