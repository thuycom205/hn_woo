from odoo import models, fields, api
import logging
import traceback

_logger = logging.getLogger(__name__)

class SpRegistryPlan(models.Model):
    _name = 'sp.lookbook.plan'
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
