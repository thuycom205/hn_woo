from odoo import models, fields


class SSpWebHook(models.Model):
    _name = 's.sp.web.hook'
    _rec_name = 'topic'

    topic = fields.Char()
    is_singleton = fields.Boolean(default=True)

    def shopify_web_hook_products_create(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_products_update(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_products_delete(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_collections_create(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_collections_update(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_collections_delete(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_app_uninstalled(self, app, shop, object_name, action, data):
        return True

    def shopify_web_hook_fulfillments_create(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_fulfillments_update(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_fulfillment_events_update(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_fulfillment_events_delete(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_orders_create(self, shop, object_name, action, data):
        return True

    def shopify_web_hook_orders_updated(self, shop, object_name, action, data):
        return True
