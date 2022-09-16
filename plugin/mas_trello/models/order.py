from odoo import models, fields, api
import logging
import traceback
import requests


_logger = logging.getLogger(__name__)

class OrderTrelloConnector(models.Model):
    _name = 'sp.trello.order'
    _rec_name = 'display_name'
    _description = "Trello Shopify integration order log"
    order_id = fields.Char()
    customer_name = fields.Char()
    order_url = fields.Char()
    g_order_id = fields.Char()
    card_url = fields.Char()
    shop_domain = fields.Char()


