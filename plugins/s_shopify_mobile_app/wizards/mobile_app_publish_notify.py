# -*- coding: utf-8 -*-

from odoo import api, fields, models


class MobileAppPublishNotify(models.TransientModel):
    _name = 'mobile.app.publish.notify'

    type_button = fields.Selection(selection=[('publish', 'Publish'), ('update', 'Update')])
    image_section = fields.Selection(
        selection=[('app_name_section', 'app name'), ('tag_line_section', 'tag line'),
                   ('category_section', 'category'), ('app_icon_section', 'app icon')])

    def action_delete_notification(self):
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        self.env['s.shopify.mobile.app.notification'].sudo().search(
            [('id', '=', self._context['default_message_id']), ('s_sp_shop_id', '=', current_shop_id)]).unlink()
