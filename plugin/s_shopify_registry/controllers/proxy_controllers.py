#/apps/gift-registry
import json

from werkzeug.utils import redirect

from odoo import http
from odoo.http import request
import traceback

import logging
from datetime import datetime
import shopify

_logger = logging.getLogger(__name__)


class SpController(http.Controller):
    @http.route('/gift-registry/list', auth='public')
    def gift_registry_list(self,*kw):
        body = '''
<link rel="stylesheet" href="https://app.thexseed.com/s_shopify_registry/static/src/bootstrap-polaris.min.css">
<link rel="stylesheet" href="https://app.thexseed.com/s_shopify_registry/static/src/selectize.css">
<link rel="stylesheet" href="https://app.thexseed.com/s_shopify_registry/static/src/select2.min.css">
<link rel="stylesheet" href="https://app.thexseed.com/s_shopify_registry/static/src/tooltipster.bundle.min.css">
<link rel="stylesheet" href="https://app.thexseed.com/s_shopify_registry/static/src/registry_frontend.css">

<script src="https://app.thexseed.com/s_shopify_registry/static/src/jquery-3.6.0.js" defer></script>
        
<script src="https://app.thexseed.com/s_shopify_registry/static/src/selectize.js" defer></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://app.thexseed.com/s_shopify_registry/static/src/flatpickr.js" defer></script>

<script src="https://app.thexseed.com/s_shopify_registry/static/src/select2.min.js" defer></script>
<script src="https://app.thexseed.com/s_shopify_registry/static/src/qrcode.min.js"></script>
<script src="https://app.thexseed.com/s_shopify_registry/static/src/tooltipster.bundle.min.js" defer></script>

<style>
    .lc-product-img {
        width: 150px;
    }
    .select2-container {
        min-width:200px!important;
    }
    .lc_privacy_label {
        font-size: 16px;
        padding-bottom: 15px;
    }

    .lc_privacy_label_content {
        padding-left: 10px;
    }

    .lcselect-product-wrapper {
        margin-top: 20px;
        margin-bottom: 20px;

    }
      .row_template {
        display: none!important;
    }

 #ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7)!important;
  position: absolute;
  z-index: +100 !important;
  width: 100% !important;
  height:100% !important;
}

#ajax-loader img {
  position: relative !important;
  top:50% !important;
  left:50% !important;
}
</style>
{% if customer %}
<div id="ajax-loader">
    <img src="https://app.thexseed.com/s_shopify_registry/static/src/img/loading-icon.gif" class="img-responsive" />
</div>

<main class="container" id="lc_gift_registry_list_container">
    <div>
        <header class="page-header">
            <div class="page-header__content">
                <h1 class="display-2">Gift Registry</h1>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Gift Registry List</a></li>
                </ol>
            </nav>

            <div class="page-header__actions">
                <button id="lc_add_giftregistry" onclick="lc_gr_add_new_gift_registry(this)"  type="button" class="btn btn-primary"><span
                        style="padding-left: 19px; padding-right: 6px">+</span></button>

            </div>
        </header>
     <div class="banner banner--critical " tabindex="0" role="status" style="display: none">
      <div>
        <h3>Gift registry has not been created</h3>
        <p><a href="#">There is an error when creating your gift registry.Please contact admin</a></p>
      </div>
    </div>
        <div class="banner banner--success" tabindex="0" role="status" style="display: none">
      <div>
        <h3>Gift registry has been created</h3>
        <p><a href="#">Your gift registry is now live.Click detail to view it then click on item tab to start adding items to your gift registry</a></p>
      </div>
    </div>

        <div class="card">

           <div class="banner" role="status" id="empty_gift_registry" >
              <div>
                <p>You have not created any gift registry yet.Please click Add button to start  </p>
              </div>
            </div>
            <div class="card-body-section table-responsive-wrapper">


                <table class="table table-hover" id="gift-registry-list">
                    <thead>
                    <tr>
                        <th scope="col">
                            <label>
                                <span><span class="sr-only">#</span></span>
                            </label>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Title</a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort active">
                                Registrant first name

                            </a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort"> Registrant last name</a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Event date</a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Status</a>
                        </th>
                        <th scope="col" class="sort" style="text-align: right;">
                            <a href="#" class="btn btn-link-sort">Action</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="row_template">
                        <td>
                            <label>
                                <span><span class="sr-only">0</span></span>
                            </label>
                        </td>
                        <td>{{title}}</td>
                        <td>{{registrant_first_name}}</td>
                        <td>{{registrant_last_name}}</td>
                        <td><span>{{event_date}}</span></td>
                        <td><span class="badge badge--attention">{{status}}</span></td>
                        <td>
                            <button  class="btn" data-item="{{id}}" onclick="registry_delete(this)"> Delete</button>
                            <button class="btn"  data-item="{{id}}" onclick="registry_detail(this)" onclick="registry_detail(this)">Detail</button>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</main>

<main class="container" id="lcr_dashboard_container">

    <div>
        <header class="page-header">
            <div class="page-header__content">
                <h1 class="display-2">Gift Registry</h1>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li  id="bc_back_gr" class="breadcrumb-item"><a onclick="lc_back_registry()" href="#">Gift Registry List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </header>

        <div class="card">
            <div class="card-header-actions">
                <ul class="card-header-tabs">
                    <li class="card-header-tab">
                        <a class="tablinks" href="#" onclick="openRegistryTab(event, 'lc-registry-form')" id="lc-registry-form-tab">Gift Registry Information</a>
                    </li>

                    <li class="card-header-tab">
                        <a class="tablinks"  onclick="openRegistryTab(event, 'registry_item')" href="#">Items</a>
                    </li>
                    <li class="card-header-tab" style="display:none">
                        <a class="tablinks" onclick="openRegistryTab(event, 'lc-registry-dashboard-order')" class="active" href="#">Orders</a>
                    </li>
                </ul>
            </div>


            <div id="lc-registry-form" class="tabcontent">
<!--end of share -->
                 <div class="card-body-section share-section">
                     <div id="share_section">
                         <h3>
                             <strong>
                                 <img src="https://app.thexseed.com/s_shopify_registry/static/src/img/share.png" width="20px"
                                 style="float: left; margin-top: 10px; margin-right: 10px;">
                                 Get your registry Share Link

                             </strong>
                         </h3>

                         <p style="width: 50%" id="link-text-share">  <input type="hidden" id="mas_r_sharelink_input_text" /> </span>
                             <img  class="vote-up-off" id="mas_r_sharelink_img" onclick="return mas_r_copy_sharelink(this)"
                                                                                    title="Copy to clipboard"
                                                                                    src="https://app.thexseed.com/s_shopify_registry/static/src/img/copy.png"
                                                                                    style="float: right">
                         </p>

                     </div>
                     <ul class="ul_share">
                         <li class="li_share">
                             <a target="_blank"  id="mas_facebook_share" class="facebook_share"  onclick="return fbs_click()">
                                 <img src="https://app.thexseed.com/s_shopify_registry/static/src/img/fb.png" />
                             </a>
                         </li>
                         <li class="li_share">
                             <a target="_blank" id="mas_tw_share" class="twitter_share" href="">
                                 <img src="https://app.thexseed.com/s_shopify_registry/static/src/img/tw.png" />
                             </a>
                         </li>
                         <li class="li_share" id="">
                             <button id="btn_qr" class="btn" onclick="return generate_qr_code(this)"> Generate QR</button>
                             <img title="Create beautiful QR code for gift registry and share it with your friends!"  class="tooltipster"  src="https://app.thexseed.com/s_shopify_registry/static/src/img/info.png"  />
                         </li>
                     </ul>
                      <div id="qrcode_container">
                        <div id="qrcode"></div>
                       </div>

                 </div>

                <!--end of share -->
                <form style="padding: 50px" method="post"  onsubmit="return submit_form_registry(this)" action="https://app.thexseed.com/gift-registryx/save"
                      id="lc_gr_form_info" >
                    <input type="hidden" name="form_type" value="registry_information" >
                    <input type="hidden" name="customer_id" value="{{ customer.id }}">
                    <input type="hidden" name="shop_domain" value="{{ shop.domain }}">
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" class="form-control lc_require_f1" name="registrant_first_name"
                               aria-describedby="emailHelp" required>
                        <small id="registrant_first_name" class="form-text text-muted">Enter the registrant first
                            name</small>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control lc_require_f1" name="registrant_last_name"
                               aria-describedby="emailHelp" required>
                        <small id="registrant_last_name" class="form-text text-muted">Enter the registrant last
                            name</small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control lc_require_f1" name="registrant_email"  id="registrant_email"required>
                        <small id="registrant_email_help" class="form-text text-muted">Enter the registrant email</small>
                         <div class="invalid-feedback">
                         You must enter a validate email.
                         </div>
                    </div>
                    <div class="form-group">
                        <label>Event title</label>
                        <input type="text" class="form-control lc_require_f1" name="title" id="event_title"
                               aria-describedby="event_title" required>
                        <small id="event_title_help" class="form-text text-muted">Enter the event type</small>
                    </div>
                    <div class="form-group">
                        <label>Message to guest</label>
                        <input type="text" class="form-control lc_require_f1" name="public_message"
                               aria-describedby="public_message" required>
                        <small id="public_message" class="form-text text-muted">Enter the message to all guests</small>
                    </div>
                    <div class="form-group">
                        <label>Event date</label>
                        <input type="text" class="form-control lc_require_f1" name="event_date"
                               aria-describedby="event_date" required>
                        <small id="event_date" class="form-text text-muted">Enter the event date</small>
                    </div>
                    <div class="form-group">
                        <label>Event location</label>
                        <input type="text" class="form-control lc_require_f1" name="event_location"
                               aria-describedby="event_location" required>
                        <small id="event_location" class="form-text text-muted">Enter the event location</small>
                    </div>
                    <div>
                        <div><span class="lc_privacy_label"> Privacy</span></div>
                        <div class="lc_privacy_label_content">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_public" id="is_public"
                                           value="1" >
                                    <label class="form-check-label" for="is_public">
                                        Is public
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_public" id="is_private"
                                           value="0">
                                    <label class="form-check-label" for="is_private">
                                        Password protection
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="password_form_group">
                        <label>Password</label>
                        <input type="password" class="form-control"  name="password"
                               aria-describedby="password" >
                        <small id="password" class="form-text text-muted">Enter the password for registry</small>
                    </div>
                        </div>


                        <div>
                            <div style="padding-bottom: 20px">
                                <h3>Shipping information</h3>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label>First name</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_first_name"
                                           aria-describedby="sa_first_name" required>
                                    <small id="sa_first_name" class="form-text text-muted">Enter the first name of
                                        shipping
                                        address which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_last_name"
                                           aria-describedby="sa_last_name" required>
                                    <small id="sa_last_name" class="form-text text-muted">Enter the last name of
                                        shipping
                                        address which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_phone"
                                           aria-describedby="sa_phone" required>
                                    <small id="sa_phone" class="form-text text-muted">Enter the phone shipping address
                                        which
                                        item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Street</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_street"
                                           aria-describedby="sa_street" required>
                                    <small id="sa_street" class="form-text text-muted">Enter the street shipping address
                                        which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <select  class="form-control lc_require_f1" name="sa_country"
                                           aria-describedby="sa_country" required> </select>


                                    <small id="sa_country" class="form-text text-muted">Enter the country of shipping
                                        address which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Province</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_province"
                                           aria-describedby="sa_province" required>
                                    <small id="sa_province" class="form-text text-muted">
                                        Enter the state/provice of shipping address
                                        which item is delivered to if your shipping address is in USA,Canada,Japan.
                                        If your shipping address is not in these countries,fulfill it with the city
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Province code</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_province_code"
                                           aria-describedby="sa_province_code" required>
                                    <small id="sa_province_code" class="form-text text-muted">Enter the province code of shipping address
                                        which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_city"
                                           aria-describedby="sa_city" required>
                                    <small id="sa_city" class="form-text text-muted">Enter the city of shipping address
                                        which item is delivered to</small>
                                </div>
                                <div class="form-group">
                                    <label>Postcode/Zip</label>
                                    <input type="text" class="form-control lc_require_f1" name="sa_zip"
                                           aria-describedby="sa_zip" required>
                                    <small id="sa_zip" class="form-text text-muted">Enter the postcode/Zip of shipping
                                        address which item is delivered to</small>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--end-->
                    <button onclick="submit_form_registry()" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <div id="registry_item" class="card-body-section table-responsive-wrapper tabcontent">
                <!--start of the banner -->
                  <div id="item-banner" class="banner"  style="display: block!important;" tabindex="0" role="status">
                      <div>
                        <p><span id="item-notification-content">Please sign in to create and manage gift registries.</span></p>
                      </div>
                 </div>
                <!--end of the banner -->

                <div style="margin-bottom: 20px">
                    <div style="padding:10px ">
                        <span>Type product name to search product then click Add product button to add items to your gift registry</span>
                    </div>
                    <div class="lcselect-product-wrapper" style="margin-bottom: 30px;margin-left: 30px; margin-right: 30px">
                        <div id="lcselect-product"></div>
                    </div>
                    <div class="lc-action-btn-wrapper" style="margin-bottom: 3px;margin-left: 30px;">
                        <button id="lc-gr-add-product" onclick="lcGRaddproduct(this)" class="btn btn-primary"><span>Add product</span>
                        </button>
                    </div>
                </div>

                          <!--Edit form -->
                <div id="lgr_edit_item_form_wrapper">

                    <h3 id="edit_item_name" style="text-align: center"> </h3>

                    <form style="padding: 50px">
                        <input type="hidden" name="edit_item_qty_product_type" id="edit_item_qty_product_type"  />
                        <input type="hidden"  id="edit_item_id"  />
                        <div class="form-group">
                            <label>Qty </label>
                            <input type="text" class="form-control lc_require_f1" id="edit_item_qty"
                                   aria-describedby="emailHelp" required/>
                        </div>
                       <div class="form-group">
                            <label>Priority </label>
                            <input type="text" class="form-control lc_require_f1" id="edit_item_priority"
                                   aria-describedby="emailHelp" required/>
                        </div>

                        <div class="form-group" id="edit_item_option_wrapper">
                            <label>Options </label>
                            <select id="edit_item_option" ></select>

                        </div>

                        <div><button  id="edit_item_btn" onclick="submit_edit_item_action(this)"> <span>Save</span></button></div>
                    </form>
                </div>
                <!--End of edit form -->
                 <div class="banner" role="status" id="empty_gift_registry_item" >
                  <div>
                    <p>You have not added any products in gift registry. Please search for product, then click Add  </p>
                  </div>
                </div>
                <table class="table table-hover" id="lc-registry-item-table">
                    <thead>
                    <tr>
                        <th scope="col">
                            <label>
                                <span><span class="sr-only">#</span></span>
                            </label>
                        </th>
                        <th scope="col" class="sort">
                            Product name
                        </th>
                        <th scope="col" class="sort">
                            Product price
                        </th>
                        <th scope="col" class="sort">
                            Product Image
                        </th>
                        <th scope="col" class="sort">
                            Option
                        </th>

                        <th scope="col" class="sort">
                            Desired qty
                        </th>
                        <th scope="col" class="sort">
                            Priority
                        </th>
                        <th scope="col" class="sort">
                            Status
                        </th>
                        <th scope="col" class="sort">
                            Action
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr class="lc-item-tr row_template" style="display: none" data-master='{{data-master}}'>
                        <td>#</td>
                        <td> {{name}}</td>
                        <td> {{price}}</td>
                        <td><img class="lc-product-img" src="{{product_img_url}}" alt="{{name}}"/></td>
                        <td><div class="lc_s_product_option" data-id="{{id}}" ><select disabled> <option>None</option></select></div></td>
                        <td> {{qty}}</td>
                        <td> {{priority}}</td>
                        <td> {{status}}</td>
                        <td>
                            <button data-iden="edit_btn" class="btn" data-id="{{id}}" onclick="lgr_edit_item_action(this)" >Edit</button>
                            <button data-iden="edit_btn"  class="btn" data-id="{{id}}" onclick="lgr_delete_item_action(this)" >Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <div id="lc-registry-dashboard-order" class="card-body-section table-responsive-wrapper tabcontent">
                 <div class="banner" role="status" id="empty_gift_registry_order" >
                  <div>
                    <p>There is no order purchased for your gift registry yet </p>
                  </div>
              </div>
                <table class="table table-hover" id="lc-registry-order-tbl">
                    <thead>
                    <tr>
                        <th scope="col">
                            #
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Order</a>
                        </th>
                        <th scope="col" class="sort">
                           <a href="#" class="btn btn-link-sort"> Date </a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Customer</a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Payment Status</a>
                        </th>
                        <th scope="col" class="sort">
                            <a href="#" class="btn btn-link-sort">Fulfillment Status</a>
                        </th>
                        <th scope="col" class="sort" style="text-align: right;">
                            <a href="#" class="btn btn-link-sort">Note</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!---->
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</main>
<script type="text/javascript">

    window.customerId = "{{ customer.id }}";
    window.lcShopdomain = "{{ shop.domain }}";
   

</script>
<script src="https://app.thexseed.com/s_shopify_registry/static/src/registry.js"></script>

{% else %}
<main class="container" id="lc_gift_registry_list_container_not_signed_in">
     <div id="visible-banner" class="banner"  style="display: block!important;" tabindex="0" role="status">
      <div>
        <h3>You have to login to create and manage gift registries</h3>
        <p><a href="#">Please sign in to create and manage gift registries.</a></p>
      </div>
    </div>
</main>

{% endif %}
        '''

        response = request.make_response(body, [
            # this method must specify a content-type application/json instead of using the default text/html set because
            # the type of the route is set to HTTP, but the rpc is made with a get and expects JSON
            ('Content-Type', 'application/liquid')
        ])
        return response


