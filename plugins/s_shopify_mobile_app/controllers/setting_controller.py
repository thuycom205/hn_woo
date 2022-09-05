import datetime
import traceback

import werkzeug
from dateutil.relativedelta import relativedelta

from odoo import http
import json
import logging
from odoo.http import request
import requests
from datetime import date

_logger = logging.getLogger(__name__)
class MobileApp(http.Controller):

    @http.route('/mobile_apps/data/<string:access_token>', auth="public", type="http", csrf=False, cors='*')
    def get_data_theme(self, access_token):
        luuthuy = 'thuyluu'
