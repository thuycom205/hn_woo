import werkzeug
from odoo.addons.web.controllers.main import Home

from odoo import http
from werkzeug.http import dump_cookie
from odoo.http import request
from odoo.http import Response

class FixSecureSameSiteNone(Response):

    def set_cookie(
            self,
            key,
            value="",
            max_age=None,
            expires=None,
            path="/",
            domain=None,
            secure=False,
            httponly=False,
            samesite=None,
    ):
        # Force Secure, samesite=none
        dump_cookie_str = dump_cookie(
                key,
                value=value,
                max_age=max_age,
                expires=expires,
                path=path,
                domain=domain,
                secure=True,
                httponly=httponly,
                charset=self.charset,
                # max_size=self.max_cookie_size,
                # max_size=4093,
                # samesite=samesite
            )
        if dump_cookie_str and len(dump_cookie_str) > 0:
            dump_cookie_str += "; Samesite=None;"
        self.headers.add(
            "Set-Cookie",
            dump_cookie_str,
        )
Response.set_cookie = FixSecureSameSiteNone.set_cookie


class FixSameSite(Home):

    @http.route('/web', type='http', auth="none")
    def web_client(self, s_action=None, **kw):
        try:
            if request.session.uid:
                if 'debug=' in request.httprequest.full_path:
                    debug_position = request.httprequest.full_path.index('debug=')
                    if request.httprequest.full_path[debug_position + 6] != '#':
                        if not request.env.ref('base.group_system').id in request.env['res.users'].sudo().browse(
                                request.session.uid).groups_id.ids:
                            return werkzeug.utils.redirect('/web?debug=', 303)
        except Exception as ex:
            a = 0
        result = super(FixSameSite, self).web_client(s_action, **kw)
        # result.set_cookie(key='session_id', value=request.session.sid, secure=True, samesite="None")
        #### by alexandra
        try:
            if request.session.uid:
                user = request.env['res.users'].sudo().browse(request.session.uid)
                if user.sp_shop_id:
                    if user.sp_shop_id.base_url:
                        shopify_url = user.sp_shop_id.base_url
                        result.headers['Content-Security-Policy'] = 'frame-ancestors https://%s https://admin.shopify.com' %(shopify_url)

        except Exception as ex:
            a = 0
        ####
        result.headers['X-Frame-Options'] = 'ALLOWALL'
        request.params['is_s_client'] = True
        if request and request.env and request.env.user:
            request.params['is_s_client'] = request.env.user.is_client

        return result

    @http.route('/web/login', type='http', auth="none")
    def web_login(self, redirect=None, **kw):
        result = super(FixSameSite, self).web_login(redirect, **kw)
        request.params['is_s_client'] = True
        if request and request.env and request.env.user:
            request.params['is_s_client'] = request.env.user.is_client
        return result
