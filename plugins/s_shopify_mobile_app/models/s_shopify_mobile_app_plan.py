from datetime import datetime, timedelta, date

import shopify

from odoo import models, fields, api, _
import logging
import traceback

_logger = logging.getLogger(__name__)
from odoo.exceptions import ValidationError


class ShopMobileAppPlan(models.Model):
    _name = 's.mobile.app.plan'

    sp_name = fields.Char()
    sp_price = fields.Float('Price', required=True, default=0.0, index=True)


class MobileAppShopPlan(models.Model):
    _name = 's.shopify.mobile.app.plan'
    _rec_name = 'display_name'

    name = fields.Char(related='current_plan.sp_name')
    display_name = fields.Char(default='PLAN')
    price = fields.Float(related='current_plan.sp_price')
    sp_shop_id = fields.Many2one('s.sp.shop', string="SP Shop", index=True)
    sp_app_id = fields.Many2one('s.sp.app', string="SP Shop App")
    current_plan = fields.Many2one('s.mobile.app.plan', store=True)
    plan_name = fields.Char(compute='_get_plan_name')
    start_trial_date = fields.Datetime()

    def _get_plan_name(self):
        self.plan_name = self.current_plan.sp_name

    def find_plan_by_price(self, price):
        return self.env['s.mobile.app.plan'].sudo().search([('sp_price', '=', price)], limit=1)

    def open_mobile_app_shop_plan(self):
        try:
            tree_view = self.env.ref('s_shopify_mobile_app.sp_shop_mobile_app_plan_view_tree',
                                     raise_if_not_found=False)
            if not tree_view:
                raise Exception('Could not find the ID of Mobile App Shop Plan view Tree.')
            if self.user_has_groups('base.group_system'):
                return {
                    'name': 'Shop Plan',
                    'type': 'ir.actions.act_window',
                    'view_mode': 'tree,form',
                    'target': 'current',
                    'views': [[tree_view.id, "tree"], [False, "form"]],
                    'context': {'create': False},
                    'res_model': 's.shopify.mobile.app.plan'
                }
            else:
                sp_shop_id = self.env.user.sudo().sp_shop_id.id
                if sp_shop_id:
                    shop_plan_id = self.sudo().search([('sp_shop_id', '=', sp_shop_id)], limit=1).id
                    if not shop_plan_id:
                        raise Exception('Could not find the mobile shop Plan.')
                    view_id = self.env.ref('s_shopify_mobile_app.sp_shop_mobile_app_plan_view_form').id
                    if not view_id:
                        raise Exception('Could not find the ID of Mobile App shop Plan view form.')
                    return {
                        'name': 'Shop Settings',
                        'type': 'ir.actions.act_window',
                        'view_mode': 'form',
                        'target': 'current',
                        'views': [(view_id, 'form')],
                        'res_id': shop_plan_id,
                        'res_model': 's.shopify.mobile.app.plan'
                    }
        except Exception as e:
            _logger.error(traceback.format_exc())

    def schedule_check_plan(self):
        current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo()
        shop_apps = self.env['s.sp.app'].sudo().search(
            [('s_app_id', '=', current_app.id), ('install_status', '=', True)])
        for shop_app in shop_apps:
            try:
                shop_mobile_app_plan = self.search([('sp_shop_id', '=', shop_app.sp_shop_id.id)])
                current_plan = shop_app.find_current_plan()
                if not current_plan:
                    shop_mobile_app_plan.current_plan = None
                    shop_app_info = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
                        [('s_sp_shop_id', '=', shop_app.sp_shop_id.id)], limit=1)
                    if shop_app_info:
                        shop_app_info.is_installed = False
                    return
                else:
                    plan = self.find_plan_by_price(current_plan.price)
                    if plan:
                        self.set_shop_app_plan_status(current_plan.trial_ends_on, shop_app, plan)
                        if shop_mobile_app_plan.current_plan != plan:
                            shop_mobile_app_plan.current_plan = plan
            except Exception as e:
                _logger.error(traceback.format_exc())
        return True

    def set_shop_app_plan_status(self, trial_ends_on, shop_app, plan):
        trials_end = False
        if trial_ends_on:
            now = datetime.now().date()
            date = datetime.strptime(trial_ends_on, '%Y-%m-%d').date()
            trials_end = now > date
        if not trials_end:
            if shop_app.plan_name != 'trial_' + plan.sp_name.lower():
                shop_app.plan_name = 'trial_' + plan.sp_name.lower()
        else:
            if shop_app.plan_name != 'paid_' + plan.sp_name.lower():
                shop_app.plan_name = 'paid_' + plan.sp_name.lower()

    def upgrade_plan(self, plan):
        try:
            session = self.sudo().sp_app_id.get_shopify_session()
            current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').sudo()
            # plan = self.env['s.plan'].sudo().search([('s_app_id', '=', current_app.id)], limit=1)
            plan_id = str(plan.id) if plan else ''
            current_display_plan = str(self.id)
            return_url = self.env['ir.config_parameter'].sudo().get_param(
                'web.base.url') + '/mobile_app/plan/accept/' + str(
                self.sp_app_id.id) + '/' + plan_id + '/' + current_display_plan
            test_env = True if current_app.sp_env == 'sandbox' else False

            if self.start_trial_date:
                remaining_trial_days = 14 - (date.today() - self.start_trial_date.date()).days
                if remaining_trial_days < 0:
                    remaining_trial_days = 0
            else:
                remaining_trial_days = 14

            charge = shopify.RecurringApplicationCharge.create({
                'name': plan.sp_name,
                'price': plan.sp_price,
                'return_url': return_url + '?shop=' + self.sudo().sp_shop_id.base_url,
                'test': test_env,
                'trial_days': remaining_trial_days
            })
            url = charge.confirmation_url
            shopify.ShopifyResource.clear_session()
            return url
        except Exception as e:
            _logger.error(traceback.format_exc())
        return True

    # def sign_up_free(self):
    #     plan = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_plan_free')
    #     if plan:
    #         url = self.upgrade_plan(plan)
    #         return {
    #             'type': 'ir.actions.act_url',
    #             'target': 'self',
    #             'url': url,
    #         }

    def sign_up_essential(self):
        plan = self.env['s.mobile.app.plan'].sudo().search([('sp_name', '=', 'Essential')], limit=1)
        if plan:
            url = self.upgrade_plan(plan)
            return {
                'type': 'ir.actions.act_url',
                'target': 'self',
                'url': '/shopify/mobile/redirect?url=%s' %url
            }
