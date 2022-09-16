# -*- coding: utf-8 -*-
import base64
import json
import logging
import os
import random
import string
import traceback

import shopify
import werkzeug

from odoo import http
from odoo.http import request
from ...s_base.controllers.sp_controllers import SpController
from flask import  abort
import hmac
import hashlib
_logger = logging.getLogger(__name__)


class MWTrelloController(http.Controller):

    @http.route('/strello/x', auth='public',methods=['POST', 'GET', 'OPTIONS'], csrf=False, cors='*')
    def x(self, **kw):
        x=1