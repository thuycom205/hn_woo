from odoo import models, fields, api, http

from odoo.http import request


class IrModel(models.Model):
    _inherit = 'ir.model'
    module_name = fields.Char(compute='compute_module_name', compute_sudo=True)

    @api.depends()
    def compute_module_name(self):
        installed_modules = self.env['ir.module.module'].search([('state', '=', 'installed')])
        # installed_names = set(installed_modules.mapped('s_shopify_app_name'))
        module_names_dic = {}
        for module in installed_modules:
            module_names_dic[module.name] = module.s_shopify_app_name if module.s_shopify_app_name else ''
        xml_ids = models.Model._get_external_ids(self)
        for model in self:
            module_names = [xml_id.split('.')[0] for xml_id in xml_ids[model.id]]
            final_module_name = ''
            if len(module_names) > 0:
                final_module_name = module_names_dic[module_names[0]]
            model.module_name = final_module_name

    @api.model
    def get_module_name_from_model(self, model_name=None):
        module_name = ''
        if model_name:
            model = self.sudo().search([('model', '=', model_name)], limit=1)
            xml_ids = models.Model._get_external_ids(model)
            module_names = [xml_id.split('.')[0] for xml_id in xml_ids[model.id]]
            if len(module_names) > 0:
                module_name = module_names[0]
        return module_name


class Http(models.AbstractModel):
    _inherit = 'ir.http'

    def session_info(self):
        result = super(Http, self).session_info()
        has_notify = False
        if result['username']:
            shop = self.env['s.sp.shop'].sudo().search([('base_url', '=', result['username'])], limit=1)
            if shop and shop.shop_owner:
                notifications = []
                general_notifications = self.env['s.app.notifications'].sudo().search([('is_public', '=', True)])
                for gn in general_notifications:
                    notifications.append({
                        'title': gn.name,
                        'content': gn.content
                    })
                shop_apps = self.env['s.sp.app'].sudo().search([('sp_shop_id', '=', shop.id)])
                for sp_app in shop_apps:
                    for notify in sp_app.s_app_id.notifications:
                        notifications.append({
                            'title': notify.name,
                            'content': notify.content
                        })
                if len(notifications) > 0:
                    has_notify = True
                result.update({
                    'shopOwner': shop.shop_owner,
                    'notify': has_notify,
                    'notifications': notifications
                })
        return result

    def binary_content(self, xmlid=None, model='ir.attachment', id=None, field='datas',
                       unique=False, filename=None, filename_field='name', download=False,
                       mimetype=None, default_mimetype='application/octet-stream',
                       access_token=None):

        """over-ride"""
        if 'wsap' in model:
            record, status = self.sudo()._get_record_and_check(xmlid=xmlid, model=model, id=id, field=field, access_token=access_token)
        else:
            record, status = self._get_record_and_check(xmlid=xmlid, model=model, id=id, field=field, access_token=access_token)

        if not record:
            return (status or 404, [], None)

        content, headers, status = None, [], None

        if record._name == 'ir.attachment':
            status, content, filename, mimetype, filehash = self._binary_ir_attachment_redirect_content(record, default_mimetype=default_mimetype)
        if not content:
            status, content, filename, mimetype, filehash = self._binary_record_content(
                record, field=field, filename=filename, filename_field=filename_field,
                default_mimetype='application/octet-stream')

        status, headers, content = self._binary_set_headers(
            status, content, filename, mimetype, unique, filehash=filehash, download=download)

        a = 0
        # Remove cache-control trong headers
        # add headers cache-control moi
        # headers.append(('Cache-Control', 'max-age=%s, public' % (odoo.http.STATIC_CACHE_LONG if unique else 0)))
        if unique:
            for head in headers:
                if len(head) > 0 and head[0] == 'Cache-Control':
                    headers.remove(head)
            headers.append(('Cache-Control', 'max-age=%s, public' % (http.STATIC_CACHE_LONG if unique else 0)))
            # request.endpoint.routing['save_session'] = False

        return status, headers, content


class ResConfigSettings(models.TransientModel):
    _inherit = 'res.config.settings'

    update_cdn_allow = fields.Boolean('Allow to Update CDN', config_parameter='s_base.update_cdn_script', default=False)
    is_dev_env = fields.Boolean('Is dev environment', config_parameter='s_base.is_dev_env', default=False)
