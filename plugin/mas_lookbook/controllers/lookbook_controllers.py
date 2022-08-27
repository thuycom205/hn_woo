#/apps/gift-registry
import json

from werkzeug.utils import redirect
import ssl
from odoo import http
from odoo.http import request
import traceback
import urllib.request

import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)


class LookbookController(http.Controller):
    #/lookbook/userguide
    @http.route('/lookbook/userguide', auth='public')
    def lookbook_userguide(self,**kw):
        # body = """
        # user_guide
        # """
        shop_url = http.request.env.user.sp_shop_id.base_url
        frame = 'https://app.thexseed.com/blog/wp-login.php?shop_name=' + shop_url
        body = '''
             <html>
             <iframe src="%s" style="position:fixed; top:0; left:0; bottom:0; right:0; width:%s; height:%s; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
             </html>
            ''' % (frame, '100%', '100%')
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'text/html')
        ])
        return response

    @http.route('/lookbook/index2', auth='user')
    def lookbook_index2(self,**kw):
        shop_url = http.request.env.user.sp_shop_id.base_url
        frame = 'https://app.thexseed.com/blog/wp-login.php?shop_name=' + shop_url

        body='''
        <html>
        <iframe src="%s" style="position:fixed; top:0; left:0; bottom:0; right:0; width:%s; height:%s; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
        </html>
       ''' %(frame,'100%','100%')
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'text/html')
        ])
        return response
    @http.route('/lookbook/view/<string:id>', auth='public')
    def lookbook_view(self,**kw):
        context = ssl._create_unverified_context()
        url = "https://app.thexseed.com/blog/wp-admin/admin-ajax.php?action=wlb_get_lookbook_saas&id=%s" %(id)
        fp = urllib.request.urlopen(url,context=context)
        mybytes = fp.read()

        mystr = mybytes.decode("utf8")
        fp.close()

        body = mystr
        # body="""
        # <html>
        # <iframe src="http://wp.local/wp-login.php?shop_name=hanetest2.myshopify.com" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>
        # </html>
        # """
        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'text/html')
        ])
        return response
