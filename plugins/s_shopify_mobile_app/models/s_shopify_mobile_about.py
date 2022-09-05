from odoo import models, fields, api


class AboutAllfetch(models.TransientModel):
    _name = 's.shopify.mobile.app.about'

    name = fields.Char()

    def rate_now(self):
        return {
            'type': 'ir.actions.act_url',
            'url': 'https://apps.shopify.com/native-mobile-app-builder?#modal-show=ReviewListingModal',
            'target': 'new',
        }

    def join_comunity(self):
        return {
            'type': 'ir.actions.act_url',
            'url': 'https://www.facebook.com/groups/2616043705162232',
            'target': 'new',
        }
