from odoo import fields, models, api
import shopify
from random import randint
import uuid
import json
import logging
import time
from odoo.exceptions import UserError, ValidationError

_logger = logging.getLogger(__name__)

FIELDS = ['primary_color', 'secondary_color', 'launch_screen', 'menu_list_ids', 'custom_setting_ids']


class MobileAppCustomDesign(models.Model):
    _name = 's.shopify.mobile.app.custom.design'
    _description = 'CustomDesign'
    _rec_name = 'name'

    primary_color = fields.Char()
    secondary_color = fields.Char()
    custom_js = fields.Char(string='Custom js')
    custom_css = fields.Char(string='Custom css')
    menu_list_ids = fields.One2many('s.shopify.mobile.app.menu.list', 'custom_design_id', string="Menu List", copy=True)
    custom_setting_ids = fields.One2many('s.shopify.mobile.app.custom.setting', 'custom_setting_id',
                                         string="Custom Setting", copy=True)

    @api.onchange('menu_list_ids')
    def _onchange_limit_menu_type(self):
        for rec in self:
            if (len(rec.menu_list_ids) > 5):
                raise UserError(("Only allow to create 5 records of Menu Type"))

    def _get_default_access_token(self):
        return str(uuid.uuid4())

    access_token = fields.Char('Access Token', default=lambda self: self._get_default_access_token(), copy=False)

    name = fields.Char("App Name*")
    app_subtitle = fields.Char(string="Tagline*", size=100, default='')
    category_ios_c1 = fields.Many2one('s.shopify.mobile.app.ios.category', string="App Store Category")
    category_ios_c2 = fields.Many2one('s.shopify.mobile.app.ios.category')
    category_android_c1 = fields.Many2one('s.shopify.mobile.app.android.category', string="Google Play Category")
    category_android_c2 = fields.Many2one('s.shopify.mobile.app.android.category')
    keyword_ids = fields.Many2many('s.shopify.app.keywords')
    description = fields.Char(string="Description*")
    img_url = fields.Char("Img URL", compute='compute_url_img', invisible=True, store=True)
    privacy_policy = fields.Char("Privacy Policy URL*")
    support = fields.Char("Support URL*")
    marketing = fields.Char("Marketing URL")
    left_characters = fields.Integer('Left Character', compute='_onchange_left_characters')

    @api.onchange('app_subtitle')
    def _onchange_left_characters(self):
        self.left_characters = 100
        for rec in self:
            rec.left_characters = 100 - len(rec.app_subtitle)

    @api.onchange('img_url')
    def _onchange_img_url(self):
        """
            Change icon on notification
            return:
        """
        shop_id = self.env.user.sp_shop_id.id
        icon_url = self.env['s.shopify.mobile.app.notification'].sudo().search(
            [('s_sp_shop_id', '=', shop_id)],
            limit=1)
        if icon_url:
            icon_url.app_icon_url = self._origin.img_url
        else:
            icon_url.app_icon_url = "/s_shopify_mobile_app/static/src/img/shopify.png"

    @api.depends('app_icon')
    def compute_url_img(self):
        """
        Compute url_img fields to get link
        """
        for rec in self:
            if rec.app_icon:
                if isinstance(rec.id, int):
                    current_app_url = self.env['ir.config_parameter'].sudo().get_param('web.base.url')
                    rec.img_url = f"{current_app_url}/web/image?model=s.shopify.mobile.app.custom.design&id=" + \
                                  str(rec.id) + "&field=app_icon"
                else:
                    rec.img_url = "/s_shopify_mobile_app/static/src/img/shopify_wait.png"
            else:
                rec.img_url = "/s_shopify_mobile_app/static/src/img/shopify.png"

    name_confirmed = fields.Boolean(
        string='Name confirmed',
        required=False)

    s_sp_shop_id = fields.Many2one('s.sp.shop')
    s_sp_app_id = fields.Many2one('s.sp.app')
    shopify_theme_id = fields.Char("shopify theme id")
    shopify_theme_graphql_api_id = fields.Char("shopify theme id")
    setting_public_url = fields.Char("Json url file")
    launch_screen = fields.Binary("Launch screen")
    launch_screen_url = fields.Char(compute='compute_launch_screen_url')
    launch_screen_public_url = fields.Char("Launch screen public url")
    base_url = fields.Char("Base url")
    apple_account_name = fields.Char()
    google_account_name = fields.Char()
    app_listing_info_text = fields.Text(compute='_compute_app_listing_info_text')
    is_app_listing_info_text = fields.Boolean(compute='_compute_app_listing_info_text')
    is_publish = fields.Boolean(default=False)
    is_register_plan = fields.Boolean(default=False, compute='_compute_register_plan')
    submit_account = fields.Selection(
        selection=[('both', 'Both'), ('apple_account', 'Apple app store'), ('google_account', 'Google play store')],
        default='both')
    apple_account_state = fields.Selection(selection=[('in_progress', 'In Progress'), ('done', 'Done')],
                                           compute='_compute_submit_state')
    google_play_state = fields.Selection(selection=[('in_progress', 'In Progress'), ('done', 'Done')],
                                         compute='_compute_submit_state')
    is_installed = fields.Boolean(default=True)

    def action_open_dashboard(self):
        """
           open form view of app listing
           return: view form
        """
        current_shop_id = self.env.user.sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)],
            limit=1).id
        view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_dashboard_form_1').id

        if self.user_has_groups('base.group_system'):
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'tree,form',
                'views': [[False, "tree"], [view_id, "form"]],
                'view_id': False,
                'res_model': 's.shopify.mobile.app.custom.design',
            }
        elif current_shop_id:
            rec_exist = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)],
                limit=1)
            if rec_exist:
                res_id = rec_exist.id
            else:
                record = self.env['s.shopify.mobile.app.custom.design'].sudo().create(
                    {'s_sp_shop_id': current_shop_id,
                     'name': "Your app name",
                     'app_subtitle': "AnyThing",
                     's_sp_app_id': s_sp_app_id,
                     })
                if record:
                    res_id = record.id
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'target': 'current',
                'views': [(view_id, 'form')],
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'context': {'active_id': res_id,
                            'active_model': 's.shopify.mobile.app.custom.design',
                            'form_view_initial_mode': 'edit',
                            'create': False
                            },
            }

    def _compute_submit_state(self):
        self.apple_account_state = None
        self.google_play_state = None
        current_shop_id = self.env.user.sp_shop_id.id
        allfetch_submit_id = self.env['s.shopify.mobile.app.allfetch.submit'].sudo().search(
            [('s_sp_shop_id', '=', current_shop_id)], limit=1)
        if allfetch_submit_id:
            self.apple_account_state = allfetch_submit_id.apple_status_submit
            self.google_play_state = allfetch_submit_id.google_status_submit
        else:
            self.apple_account_state = None
            self.google_play_state = None

    def action_open_custom(self):
        """
        open form view of customization
        return: view form
        """
        current_shop_id = self.env.user.sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)],
            limit=1).id
        view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_dashboard_form_2').id

        if self.user_has_groups('base.group_system'):
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'tree,form',
                'views': [[False, "tree"], [view_id, "form"]],
                'view_id': False,
                'res_model': 's.shopify.mobile.app.custom.design',
            }
        elif current_shop_id:
            rec_exist = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)],
                limit=1)
            if rec_exist:
                res_id = rec_exist.id
            else:
                record = self.env['s.shopify.mobile.app.custom.design'].sudo().create(
                    {'s_sp_shop_id': current_shop_id,
                     'name': "Your app name",
                     'app_subtitle': "AnyThing",
                     's_sp_app_id': s_sp_app_id,
                     })
                if record:
                    res_id = record.id
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'target': 'current',
                'views': [(view_id, 'form')],
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'context': {'active_id': res_id,
                            'active_model': 's.shopify.mobile.app.custom.design',
                            'form_view_initial_mode': 'edit',
                            'create': False
                            },
            }

    def put_theme_to_shopify(self):
        """
         - Connect with shopify
         - create theme if specific theme don't exist
         - push field's data to shopify by function getting_data()
         - get setting_public_url of theme
         - get link launch screen public after pushing img to shopify
        """
        s_sp_app = self.sudo().s_sp_app_id
        session = shopify.Session(s_sp_app.sudo().sp_shop_id.base_url, s_sp_app.sudo().s_app_id.sp_api_version,
                                  s_sp_app.sudo().token)
        shopify.ShopifyResource.activate_session(session)
        if s_sp_app.mobile_app_shopify_theme_id:
            try:
                theme = shopify.Theme.find()
                list_theme = []
                for rec in theme:
                    list_theme.append(rec.id)
                if not int(s_sp_app.mobile_app_shopify_theme_id) in list_theme:
                    theme = shopify.Theme.create({
                        "name": "Allfetch mobile app",
                        "body": {"test": "222", }
                    })
                    if theme.id:
                        s_sp_app.mobile_app_shopify_theme_id = theme.id
                        s_sp_app.mobile_app_shopify_theme_graphql_api_id = theme.admin_graphql_api_id
                        print(1)
                    else:
                        ##Todo raise user error maybe? No shopify error
                        x = 1
            except Exception as e:
                logging.exception('Error loading data shop ' + str(e))
        else:
            try:
                theme = shopify.Theme.create({
                    "name": "Allfetch mobile app",
                    "body": {"test": "111", }
                })
                if theme.id:
                    s_sp_app.mobile_app_shopify_theme_id = theme.id
                    s_sp_app.mobile_app_shopify_theme_graphql_api_id = theme.admin_graphql_api_id
                else:
                    ##Todo raise user error maybe?
                    x = 1
            except Exception as e:
                logging.exception('Error loading data shop ' + str(e))
        launch_screen = shopify.Asset.create(
            {"theme_id": s_sp_app.mobile_app_shopify_theme_id,
             "key": "assets/launch_screen"+str(int(time.time()))+"." + self._compute_launch_screen_key(),
             "src": self.launch_screen_url})
        if 'public_url' in launch_screen.attributes:
            self.launch_screen_public_url = launch_screen.public_url
        setting = shopify.Asset.create(
            {"theme_id": s_sp_app.mobile_app_shopify_theme_id, "key": "assets/mobile_app.js",
             "value": str(self.getting_data())})

        if 'public_url' in setting.attributes:
            self.setting_public_url = setting.public_url.split('?v=')[0]
        ##push to asset
        # return

    def compute_launch_screen_url(self):
        """
        compute fields launch_screen_url through a controller
        when opening link, an image will occur
        return: link
        """
        for rec in self:
            rec.launch_screen_url = ''
            if rec.launch_screen:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.launch_screen_url = base_url + '/allfetch/image2/launch_screen/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    app_icon = fields.Binary("App Icon*")
    icon_url = fields.Char(string='Icon Url', compute='compute_icon_url')

    def compute_icon_url(self):
        """
        compute fields launch_screen_url through a controller
        when opening link, an image will occur
        return: link
        """
        for rec in self:
            rec.icon_url = ''
            if rec.app_icon:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.icon_url = base_url + '/allfetch/icon_resize/app_icon/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    feature_graphic = fields.Binary("Feature Graphic*")
    feature_graphic_url = fields.Char(string='Feature Graphic Url', compute='compute_feature_graphic_url')

    def compute_feature_graphic_url(self):
        for rec in self:
            rec.feature_graphic_url = ''
            if rec.feature_graphic:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.feature_graphic_url = base_url + '/allfetch/feature_graphic/feature_graphic/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    phone_screenshot = fields.Binary("Phone Screenshot 1*")
    phone_screenshot_1_url = fields.Char(string='Phone Screenshot 1', compute='compute_phone_screenshot_1_url')

    def compute_phone_screenshot_1_url(self):
        for rec in self:
            rec.phone_screenshot_1_url = ''
            if rec.phone_screenshot:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.phone_screenshot_1_url = base_url + '/allfetch/phone_screenshot/phone_screenshot/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    phone_screenshot_2 = fields.Binary("Phone Screenshot 2*")
    phone_screenshot_2_url = fields.Char(string='Phone Screenshot 2', compute='compute_phone_screenshot_2_url')

    def compute_phone_screenshot_2_url(self):
        for rec in self:
            rec.phone_screenshot_2_url = ''
            if rec.phone_screenshot_2:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.phone_screenshot_2_url = base_url + '/allfetch/phone_screenshots_2/phone_screenshot_2/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    table_7inch = fields.Binary("7-inch table screenshot*")
    table_7inch_url = fields.Char(string='7-inch table url', compute='compute_7_inch_table')

    def compute_7_inch_table(self):
        for rec in self:
            rec.table_7inch_url = ''
            if rec.table_7inch:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.table_7inch_url = base_url + '/allfetch/table_7inch/table_7inch/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    table_10inch = fields.Binary("10-inch table screenshot*")
    table_10inch_url = fields.Char(string='10-inch table url', compute='compute_10_inch_table')

    def compute_10_inch_table(self):
        for rec in self:
            rec.table_10inch_url = ''
            if rec.table_10inch:
                current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
                base_url = current_app.sudo().base_url
                rec.table_10inch_url = base_url + '/allfetch/table_10inch/table_10inch/' + str(
                    randint(100, 999)) + '/' + str(rec.sudo().id)

    term_condition = fields.Boolean(default=False)

    def write(self, vals):
        res = super(MobileAppCustomDesign, self).write(vals)
        self.env.cr.commit()
        # current_shop_id = self.env.user.sp_shop_id.id
        # term = self.env['s.shopify.mobile.app.custom.design'].sudo().search([
        #     ('term_condition', '!=', True), ('id', '=', self.id), ('s_sp_shop_id', '=', current_shop_id)
        # ])
        if self.term_condition:
            for field in FIELDS:
                if field in vals:
                    self.put_theme_to_shopify()
                    break
        return res

    def _compute_launch_screen_key(self):
        """
        by default file Binary has type image/png...
        replace field mimetype in model ir.attachment
        example : image/png, image/jpeg --> png, jpeg
        return: minetype
        """
        mimetype = ''
        if self.launch_screen:
            rec = self.sudo().env['ir.attachment'].search(
                [('res_model', '=', 's.shopify.mobile.app.custom.design'),
                 ('res_field', '=', 'launch_screen'),
                 ('res_id', '=', self.id)], limit=1)
            if rec:
                mimetype = rec.mimetype.replace('image/', '')
        return mimetype

    def getting_data(self):
        """
        Take field's data convert to json
        return: json
        """
        menu_lists = self.menu_list_ids.sorted(lambda x: x.sequence, reverse=False)
        custom_settings = self.custom_setting_ids.sorted(lambda x: x.sequence, reverse=False)

        # current_app = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app')
        # base_url = current_app.sudo().base_url
        s_sp_app = self.sudo().s_sp_app_id
        base_url = s_sp_app.sudo().sp_shop_id.base_url

        if self.launch_screen is False:
            setting = {
                'primary_color': self.primary_color or '',
                'secondary_color': self.secondary_color or '',
                'launch_screen': '',
                'base_url': base_url,
                'currencyCode': self.s_sp_shop_id.currency_code or ''
            }
        else:
            setting = {
                'primary_color': self.primary_color or '',
                'secondary_color': self.secondary_color or '',
                'launch_screen': self.launch_screen_public_url or '',
                'base_url': base_url,
                'currencyCode': self.s_sp_shop_id.currency_code or ''
            }

        list_custom_setting = []
        for custom_setting in custom_settings:
            menu = {
                'title': custom_setting.title or '',
                'url': custom_setting.url or '',
            }
            list_custom_setting.append(menu)
        setting['custom_setting'] = list_custom_setting

        list_menu = []
        for menu_list in menu_lists:
            menu = {
                'menu_type_id': menu_list.menu_type_id.menu_type or '',
                'title': menu_list.title or '',
                'icon_name': menu_list.icon_id.name or '',
            }
            list_menu.append(menu)
        setting['menu'] = list_menu
        setting['app_state'] = self.is_installed

        return json.dumps(setting)

    @api.model
    def create(self, vals):
        res = super(MobileAppCustomDesign, self).create(vals)
        res.put_theme_to_shopify()
        return res

    def open_form_link_access(self):
        """
        Open popup link access form by clicking action server
        return: form
        """
        self.put_theme_to_shopify()
        return {
            'name': 'Link Access',
            'domain': [],
            'res_model': 'mobile.app.link.access.token',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'context': {
                'default_custom_design_id': self.sudo().id,
            },
            'target': 'new',
        }

    def open_form_request_submission(self):
        """
        Open popup request submission form by clicking action server
        return: form
        """
        form_id = self.env.ref("s_shopify_mobile_app.mobile_app_request_store_submission_form").sudo().id
        return {
            'name': 'Request Store Submission',
            'domain': [],
            'res_model': 'mobile.app.link.access.token',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_id': form_id,
            'view_type': 'form',
            'context': {
                'default_custom_design_id': self.sudo().id,
            },
            'target': 'new',
        }

    def open_form_register_plan(self):
        res_id = ''
        current_shop_id = self.env.user.sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)],
            limit=1).id
        view_id = self.env.ref('s_shopify_mobile_app.sp_shop_mobile_app_plan_view_form').id

        if current_shop_id:
            rec_exist = self.env['s.shopify.mobile.app.plan'].sudo().search([('sp_shop_id', '=', current_shop_id)])
            if rec_exist:
                res_id = rec_exist.id
            else:
                record = self.env['s.shopify.mobile.app.plan'].sudo().create({'display_name': "PLAN"})
                if record:
                    res_id = record.id

            return {
                # 'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'target': 'main',
                'views': [(view_id, 'form')],
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.plan'
            }

    def _compute_app_listing_info_text(self):
        current_shop_id = self.env.user.sp_shop_id.id
        for rec in self:
            rec.app_listing_info_text = None
            rec.is_app_listing_info_text = None
            existing_app_listing_record = self.sudo().search(
                [('s_sp_shop_id', '=', current_shop_id), ('term_condition', '=', True)])
            if existing_app_listing_record:
                rec.app_listing_info_text = ''
                rec.is_app_listing_info_text = False
            else:
                rec.app_listing_info_text = 'You are missing required fields. Please finish it before jumping to next steps.'
                rec.is_app_listing_info_text = True

    def _open_publish_process_form(self):
        """
        open form view of publish process
        return: view form
        """
        current_shop_id = self.env.user.sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        s_sp_app_id = self.env['s.sp.app'].sudo().search(
            [('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)],
            limit=1).id
        view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_publish_process_view_form').id

        if self.user_has_groups('base.group_system'):
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'tree,form',
                'views': [[False, "tree"], [view_id, "form"]],
                'view_id': False,
                'res_model': 's.shopify.mobile.app.custom.design',
            }
        elif current_shop_id:
            rec_exist = self.env['s.shopify.mobile.app.custom.design'].sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)],
                limit=1)
            if rec_exist:
                res_id = rec_exist.id
            else:
                record = self.env['s.shopify.mobile.app.custom.design'].sudo().create(
                    {'s_sp_shop_id': current_shop_id,
                     'name': "Your app name",
                     'app_subtitle': "AnyThing",
                     's_sp_app_id': s_sp_app_id,
                     })
                if record:
                    res_id = record.id
            return {
                'name': 'Setting',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'target': 'current',
                'views': [(view_id, 'form')],
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'context': {'active_id': res_id,
                            'active_model': 's.shopify.mobile.app.custom.design',
                            'form_view_initial_mode': 'edit',
                            'create': False
                            },
            }

    def action_open_customization(self):
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        if current_shop_id:
            customize_record_exist = self.sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)], limit=1)
            if customize_record_exist:
                res_id = customize_record_exist.sudo().id
            else:
                record = self.sudo().create({'name': 'Customization'})
                res_id = record.id
            view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_dashboard_form_2').id
            return {
                # 'name': 'Customization',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'views': [(view_id, 'form')],
                'view_id': view_id,
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'target': 'main',
            }

    def action_open_app_listing(self):
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        if current_shop_id:
            app_listing_record_exist = self.sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)], limit=1)
            if app_listing_record_exist:
                res_id = app_listing_record_exist.sudo().id
            else:
                record = self.sudo().create({'name': 'App Listing'})
                res_id = record.id
            view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_dashboard_form_1').id
            return {
                # 'name': 'Customization',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'views': [(view_id, 'form')],
                'view_id': view_id,
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'target': 'main',
            }

    def _compute_register_plan(self):
        for rec in self:
            rec.is_register_plan = False
            current_shop_id = rec.env.user.sudo().sp_shop_id.id
            current_plan_shop = self.env['s.shopify.mobile.app.plan'].sudo().search([('sp_shop_id', '=', current_shop_id)], limit=1)
            if current_plan_shop.current_plan.sp_name == 'Essential':
                rec.is_register_plan = True

    def action_publish_app_success(self):
        self.put_theme_to_shopify()
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        current_app_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app').id
        if current_shop_id:
            s_sp_app_id = self.env['s.sp.app'].sudo().search([('sp_shop_id', '=', current_shop_id), ('s_app_id', '=', current_app_id)], limit=1).id
            plan_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_plan_free').id
            s_sp_plan_id = self.env['s.mobile.app.plan'].sudo().search([('id', '=', plan_id)]).id
            plan_shop_id = self.env['s.shopify.mobile.app.plan'].sudo().search(
                [('sp_shop_id', '=', current_shop_id)], limit=1)
            if plan_shop_id:
                res_id = plan_shop_id.sudo().id
            else:
                record = self.env['s.shopify.mobile.app.plan'].sudo().create({
                    'name': 'PLAN',
                    'sp_shop_id': current_shop_id,
                    'sp_app_id': s_sp_app_id,
                    'current_plan': s_sp_plan_id
                })
                res_id = record.id

            if plan_shop_id.current_plan.sp_name == 'Essential':
                self.is_publish = True
                self.is_register_plan = True

                if self.submit_account == 'apple_account':
                    if self.apple_account_name:
                        vals = {
                            "user_note_gg_account": "",
                            "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
                            "user_note_apple_account": "User submit Apple Account: " + str(self.apple_account_name),
                            "allfetch_submit_id": self.id,
                            "shop_email": self.sudo().s_sp_shop_id.email
                        }
                    else:
                        raise UserError('You need fill your account name in step 2')
                elif self.submit_account == 'google_account':
                    if self.google_account_name:
                        vals = {
                            "user_note_gg_account": "User submit GG Account: " + str(self.google_account_name),
                            "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
                            "user_note_apple_account": "",
                            "allfetch_submit_id": self.id,
                            "shop_email": self.sudo().s_sp_shop_id.email
                        }
                    else:
                        raise UserError('You need fill your account name in step 2')
                else:
                    if self.google_account_name and self.apple_account_name:
                        vals = {
                            "user_note_gg_account": "User submit GG Account: " + str(self.google_account_name),
                            "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
                            "user_note_apple_account": "User submit Apple Account: " + str(self.apple_account_name),
                            "allfetch_submit_id": self.id,
                            "shop_email": self.sudo().s_sp_shop_id.email
                        }
                    else:
                        raise UserError('You need fill your account name in step 2')

                self.env['s.shopify.mobile.app.allfetch.submit'].create(vals)

                view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_publish_notify_view_form').id
                return {
                    'name': 'Mobile App Notify',
                    'domain': [],
                    'res_model': 'mobile.app.publish.notify',
                    'type': 'ir.actions.act_window',
                    'view_mode': 'form',
                    'view_type': 'form',
                    'view_id': view_id,
                    'target': 'new',
                    'context': {'default_type_button': 'publish'}
                }
            else:
                view_id = self.env.ref('s_shopify_mobile_app.sp_shop_mobile_app_plan_view_form').id
                return {
                    'name': 'Mobile App Notify',
                    'domain': [],
                    'res_model': 's.shopify.mobile.app.plan',
                    'type': 'ir.actions.act_window',
                    'view_mode': 'form',
                    'view_type': 'form',
                    'view_id': view_id,
                    'res_id': res_id,
                    'target': 'main',
                }
        # self.is_publish = True
        # vals = {
        #     "user_note_gg_account": "User submit GG Account: " + str(self.google_account_name),
        #     "s_sp_shop_id": self.env.user.sudo().sp_shop_id.id,
        #     "user_note_apple_account": "User submit Apple Account: " + str(self.apple_account_name),
        #     "allfetch_submit_id": self.id,
        #     "shop_email": self.sudo().s_sp_shop_id.email
        # }
        # self.env['s.shopify.mobile.app.allfetch.submit'].create(vals)
        #
        # view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_publish_notify_view_form').id
        # return {
        #     'name': 'Mobile App Notify',
        #     'domain': [],
        #     'res_model': 'mobile.app.publish.notify',
        #     'type': 'ir.actions.act_window',
        #     'view_mode': 'form',
        #     'view_type': 'form',
        #     'view_id': view_id,
        #     'target': 'new',
        #     'context': {'default_type_button': 'publish'}
        # }

    def open_form_update_publish_app(self):
        # self.put_theme_to_shopify()
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_publish_notify_view_form').id
        return {
            'name': 'Mobile App Notify',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'target': 'new',
            'context': {'default_type_button': 'update'}
        }

    def open_popup_app_name(self):
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_image_popup_view_form').id
        return {
            'name': 'Mobile App Notify',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'target': 'new',
            'context': {'default_image_section': 'app_name_section'},
        }

    def open_popup_tag_line(self):
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_image_popup_view_form').id
        return {
            'name': 'Mobile App Notify',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'target': 'new',
            'context': {'default_image_section': 'tag_line_section'},
        }

    def open_popup_category(self):
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_image_popup_view_form').id
        return {
            'name': 'Mobile App Notify',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'target': 'new',
            'context': {'default_image_section': 'category_section'},
        }

    def open_popup_app_icon(self):
        view_id = self.env.ref('s_shopify_mobile_app.af_mobile_app_image_popup_view_form').id
        return {
            'name': 'Mobile App Notify',
            'domain': [],
            'res_model': 'mobile.app.publish.notify',
            'type': 'ir.actions.act_window',
            'view_mode': 'form',
            'view_type': 'form',
            'view_id': view_id,
            'target': 'new',
            'context': {'default_image_section': 'app_icon_section'},
        }

    def open_form_publish_app(self):
        # self.put_theme_to_shopify()
        current_shop_id = self.env.user.sudo().sp_shop_id.id
        if current_shop_id:
            recommend_explorer_exist = self.sudo().search(
                [('s_sp_shop_id', '=', current_shop_id)], limit=1)
            if recommend_explorer_exist:
                res_id = recommend_explorer_exist.sudo().id
            else:
                record = self.sudo().create({'name': 'Publish Process'})
                res_id = record.id
            view_id = self.env.ref('s_shopify_mobile_app.s_shopify_mobile_app_publish_process_view_form').id
            return {
                # 'name': 'Customization',
                'type': 'ir.actions.act_window',
                'view_mode': 'form',
                'views': [(view_id, 'form')],
                'view_id': view_id,
                'res_id': res_id,
                'res_model': 's.shopify.mobile.app.custom.design',
                'target': 'main',
                'context': {'active_id': res_id,
                            'active_model': 's.shopify.mobile.app.custom.design',
                            'form_view_initial_mode': 'edit',
                            'create': False
                            },
            }
