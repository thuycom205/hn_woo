import logging

import cssutils

from odoo import http
from odoo.http import request

cssutils.log.setLevel(logging.CRITICAL)

_logger = logging.getLogger(__name__)


class SettingIframeMobileApp(http.Controller):

    @http.route('/iframe/s_shopify_mobile_app/app_listing', type='http', auth="public")
    def iframe_app_listing(self):
        response = request.render('s_shopify_mobile_app.onboarding_app_listing_iframe_template')
        return response

    @http.route('/iframe/s_shopify_mobile_app/notification', type='http', auth="public")
    def iframe_notification(self):
        response = request.render('s_shopify_mobile_app.onboarding_notification_iframe_template')
        return response

    @http.route('/iframe/s_shopify_mobile_app/customization', type='http', auth="public")
    def iframe_customization(self):
        response = request.render('s_shopify_mobile_app.onboarding_customization_iframe_template')
        return response



