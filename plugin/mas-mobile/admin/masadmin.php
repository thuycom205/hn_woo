<?php

class MasMobileAdmin
{
    public function adminMenu()
    {
        add_menu_page('Mobile app builder', 'Mobile app builder', 'edit_posts', 'edit.php?post_type=mas_mobile_x', '', 'dashicons-wheel', 100);
        add_menu_page('Mobile app setting', 'Mobile app setting', 'edit_posts', 'masmb_setting', 'MasMobileAdmin::viewSetting', 'dashicons-admin-generic', 100);
        add_menu_page('Mobile app preview', 'Mobile app preview', 'edit_posts', 'masmb_preview', 'MasMobileAdmin::previewApp', 'dashicons-smartphone', 100);
        //  add_submenu_page('edit.php?post_type=mas_mobile_x', 'Gift Registry Detail', 'Gift Registry Detail', 'edit_posts', 'masmb_detail',  'MasMobileAdmin::viewSetting');
    }

    public static function previewApp()
    {
        $userId = get_current_user_id();

        $setting = self::getMobileSettingByUserId($userId);

        if ($setting) {
            $token = get_post_meta($setting->ID, 'token', true);
            if ($token == null || $token == '') {
                $token = md5($setting->ID);
            }


        } else {
            echo "pls set up and click submit";
            wp_die();
        }
        ?>
        <link rel="stylesheet" href="https://ablesense.github.io/bootstrap-polaris/demo/bootstrap-polaris.min.css">
        <link rel="stylesheet" href="<?php echo MASMB_URL ?>/assets/masmbadmincss.css">

        <style>
            #preview_instruction {
                padding: 15px 15px 15px 15px;
            }
            #qrcode {
                padding: 15px 15px 15px 15px;
                margin: 5px 5px 5px 5px;

            }
        </style>
        <main class="container">

            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="card" id="preview_instruction">
                            Note:Please customize your navigation bar before previewing your app.
                            Follow these below steps to preview your mobile app before setting it live.
                            <ul>
                             <li>
                            Step 1: Download the TheXseed Preview App

                            Simply reach out to Google Play store then searching for the app "TheXseed
                            Shopify Preview" or click on the button below.

                            On Google Play
                             </li>
                                <li>
                                Step 2: Open the app after installing

                                </li>
                                <li>
                            Step 3: Scan the QR Code or paste the copied text

                            Scan the QR on the right side and start testing your app inaction.

                            Note:
                            If you cannot scan the QR code, please copy the url under the QR code abd paste into the
                            "Preview URL" field in the app and submit.
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="col">
                        <div><strong>Qr code</strong></div>
                        <div id="qrcode" data-token="<?php echo $token ?>"></div>
                        <div>
                            <input id="mobile_preview_token" name="mobile_preview_token" value="<?php  echo 'https://'.$_SERVER['HTTP_HOST']. '/token/' . $token  ?>"/>
                            <button onclick="masmb_copytext(this)">Copy text</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
    }

    public static function getMobileSettingByUserId($user_id)
    {
//        $args = array(
//            'author'        => $user_id,
//            'post_type' => 'mas_mobile_x',
//            'post_status' => 'private',
//            'posts_per_page' => 1,
//            'orderby'       =>  'post_date',
//            'order'         =>  'ASC'
//        );
        $args = array(
            'author' => $user_id,
            'post_type' => 'mas_mobile_x',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'ASC'
        );

        $setting = get_posts($args);

        if (isset($setting[0])) {
            return $setting[0];

        } else {
            return false;
        }
    }

    public function viewSetting()
    {
        $userId = get_current_user_id();

        $setting = self::getMobileSettingByUserId($userId);

        if ($setting) {
            $redirect_url = 'https://'.$_SERVER['HTTP_HOST'].'/blog/wp-admin/post.php?post=' . $setting->ID . '&action=edit';
            $redirect_to = $redirect_url;

        } else {
            $redirect_to = 'https://'.$_SERVER['HTTP_HOST'].'/blog/wp-admin/post-new.php?post_type=mas_mobile_x';
        }

        wp_safe_redirect($redirect_to);
        exit();
    }

    public function add_metabox()
    {
        add_meta_box(
            'mas-mobile-app-setting',
            __('Setting', 'masma'),
            array($this, 'render_metabox'),
            'mas_mobile_x',
            'normal',
            'high'
        );
    }

    public function save_metabox($post_id, $post)
    {
//https://gist.github.com/dingo-d/4b226c20f5071d0b0dd6
        // Check if user has permissions to save data.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check if not an autosave.
        if (wp_is_post_autosave($post_id)) {
            return;
        }

        // Check if not a revision.
        if (wp_is_post_revision($post_id)) {
            return;
        }

        if (!isset($_POST['masmb_params'])) {
            return;
        }
        update_post_meta($post_id, 'masmb_params', $_POST['masmb_params']);

        if (isset($_POST['token'])) {
            update_post_meta($post_id, 'token', $_POST['token']);
        } else {
            update_post_meta($post_id, 'token', md5($post_id));

        }
        if (isset($_POST['shop_url'])) {
            update_post_meta($post_id, 'token', $_POST['token']);
        } else {
            update_post_meta($post_id, 'token', md5($post_id));

        }
        global $current_user;
        wp_get_current_user();
        update_post_meta($post_id, 'shop_name', $current_user->user_login);
        global $wpdb;
        if ($post->post_type=='mas_mobile_x' && isset($_REQUEST['masmb_params']) ) {
            if ($post->post_status == 'publish' ) {
                // @codingStandardsIgnoreStart
                $wpdb->query(
                    $wpdb->prepare(
                        "
			UPDATE $wpdb->posts
			SET post_status = '%s'
			WHERE post_type = '%s'
			AND ID = '%d'

			",
                        'private',
                        'woocommerce-lookbook',
                        $post_id
                    )
                );
            }
        }
    }

    private function get_data($post_id, $field, $default = '')
    {
        if (isset($this->data[$post_id]) && $this->data[$post_id]) {
            $params = $this->data[$post_id];
        } else {
            $this->data[$post_id] = get_post_meta($post_id, 'masmb_params', true);
            $params = $this->data[$post_id];
        }
        if (isset($params[$field]) && $field) {
            return $params[$field];
        } else {
            return $default;
        }
    }
    public function initFakeData(&$homeData) {
        if (!isset($homeData['enable'])) {
            $homeData['enable'] = 0;
        }
        if (!isset($homeData['title'])) {
            $homeData['title'] = '';
        }
        if (!isset($homeData['icon'])) {
            $homeData['icon'] = 0;
        }
        return $homeData;
    }
    public function render_metabox($post)
    {
       // echo base64_encode($post->ID);
      //  echo md5($post->ID);
        $app_name = $this->get_data($post->ID, 'app_name');
        $tagline = $this->get_data($post->ID, 'tagline');
        $primary_color = $this->get_data($post->ID, 'primary_color');
        $secondary_color = $this->get_data($post->ID, 'secondary_color');
        $keyword = $this->get_data($post->ID, 'keyword');
        $description = $this->get_data($post->ID, 'description');
        $privacy_policy_url = $this->get_data($post->ID, 'privacy_policy_url');
        $support_url = $this->get_data($post->ID, 'support_url');
        $marketing_url = $this->get_data($post->ID, 'marketing_url');
        $token = get_post_meta($post->ID, 'token', true);
        $upload_link = esc_url(get_upload_iframe_src('image', $post->ID));

        $homeData = $this->get_data($post->ID, 'home');
        $cartData = $this->get_data($post->ID, 'cart');

        $infoData = $this->get_data($post->ID, 'info');
        $settingData = $this->get_data($post->ID, 'setting');

        $this->initFakeData($homeData);
        $this->initFakeData($cartData);
        $this->initFakeData($infoData);
        $this->initFakeData($settingData);

        // See if there's a media id already saved as post meta
        $your_img_id = $this->get_data($post->ID, 'image');



        // Get the image src
        $your_img_src = wp_get_attachment_image_src($your_img_id, 'full');

        // For convenience, see if the array is valid
        $you_have_img = is_array($your_img_src);
        ?>
        <link rel="stylesheet" href="https://ablesense.github.io/bootstrap-polaris/demo/bootstrap-polaris.min.css">

        <main class="container">
            <div class="row no-gutters">
                <div class="col-md-4 card-annotation">
                    <h3>App information</h3>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary" type="submit"> Submit</button>

                            <button class="btn btn-primary" type="button"> Preview</button>

                            <input type="hidden" name="token" value="<?php echo $token ?>">
                            <label for="app_name">App name</label>
                            <input type="text" id="app_name" class="form-control" name="masmb_params[app_name]"
                                   value="<?php echo $app_name ?>">
                            <label for="tagline">Tagline</label>
                            <input type="text" id="tagline" class="form-control" name="masmb_params[tagline]"
                                   value="<?php echo $tagline ?>">
                            <label for="keyword">Keyword</label>
                            <input type="text" id="keyword" class="form-control" name="masmb_params[keyword]"
                                   value="<?php echo $keyword ?>" aria-describedby="keyword">
                            <small id="passwordHelpBlock" class="polaris-caption">Your keyword is separated by
                                commas.</small>
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="masmb_params[description]" rows="6"
                                      cols="15"> <?php echo $description ?> </textarea>

                            <label for="url">Privacy Policy URL</label>
                            <input type="url" id="privacy_policy_url" class="form-control"
                                   name="masmb_params[privacy_policy_url]" value="<?php echo $privacy_policy_url ?>">
                            <label for="url">Support URL</label>
                            <input type="url" id="support_url" class="form-control" name="masmb_params[support_url]"
                                   value="<?php echo $support_url ?>">
                            <label for="url">Marketing URL</label>
                            <input type="url" id="marketing_url" class="form-control" name="masmb_params[marketing_url]"
                                   value="<?php echo $marketing_url ?>">


                        </div>
                        <!--Start -->
                        <div class="masmb-image-container">

                            <?php if ($you_have_img) : ?>
                                <img class="masmb-image" src="<?php echo $your_img_src[0] ?>" alt=""
                                     style="max-width:100%;"/>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Your add & remove image links -->
                    <div class="hide-if-no-js">
                        <p>
                            <a class="vi-ui button green masmb-upload-img <?php if ($you_have_img) {
                                echo 'hidden';
                            } ?>" href="<?php echo $upload_link ?>">
                                <?php esc_html_e('Add Image', 'woocommerce-lookbook') ?>
                            </a>
                            <a class="vi-ui button red masmb-delete-img <?php if (!$you_have_img) {
                                echo 'hidden';
                            } ?>" href="#">
                                <?php esc_html_e('Remove this image', 'woocommerce-lookbook') ?>
                            </a>
                        </p>
                    </div>
                    <!--End-->
                    <!-- A hidden input to set and post the chosen image id -->
                    <input class="masmb-image-data" name="masmb_params[image]" type="hidden"
                           value="<?php echo esc_attr($your_img_id); ?>"/>
                    <div class="card-body">
                        <h3>Customize mobile app</h3>

                        <label for="primary_color">Primary color</label>
                        <input class="color_field" type="hidden" name="masmb_params[primary_color]"
                               value="<?php echo $primary_color ?>"/>

                        <label for="secondary_color">Secondary color </label>
                        <input class="color_field" type="hidden" name="masmb_params[secondary_color]"
                               value="<?php echo $secondary_color ?>"/>

                    </div>
                    <div class="card-body">
                        <h3>Bottom navigation bar</h3>

                        <div class="container">
                            <ul id="sortable">
                                <li>
                                    <div class="row">
                                        <div class="col-sm">
                                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                            <div>
                                                <label>Home</label>
                                                <input value="1"  <?php if (isset($homeData['enable'])) { ?> name="masmb_params[home][enable]" <?php checked( $homeData['enable'], 1 ) ?>  <?php  } ?>style="height:15px!important;width:15px" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <label>Title</label>
                                            <input <?php if (isset($homeData['title'])) { ?>  value="<?php echo $homeData['title'] ?>"  <?php }  ?> name="masmb_params[home][title]" type="text" class="form-control">
                                        </div>
                                        <div class="col-sm">
                                            <label>Icon</label>
                                            <select name="masmb_params[home][icon]"  class="form-control"
                                                    aria-describedby="selectHelp">
                                                <option value="1" <?php if (isset($homeData['icon'])) { ?> <?php selected( $homeData['icon'], 1 ) ?> <?php } ?> >One</option>
                                                <option value="2"  <?php if (isset($homeData['icon'])) { ?>  <?php selected( $homeData['icon'], 2 ) ?> <?php } ?> >Two</option>
                                                <option value="3" <?php if (isset($homeData['icon'])) { ?>  <?php selected( $homeData['icon'], 3 ) ?> <?php } ?> >Three</option>
                                                <option value="4" <?php if (isset($homeData['icon'])) { ?>  <?php selected( $homeData['icon'], 4 ) ?> <?php } ?> >Four</option>
                                            </select>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="micon-name">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                <label>Cart</label>
                                                <input value="1" name="masmb_params[cart][enable]"  <?php checked( $cartData['enable'], 1 ) ?>style="height:15px!important;width:15px" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <label>Title</label>
                                            <input name="masmb_params[cart][title]" type="text" class="form-control">
                                        </div>
                                        <div class="col-sm">
                                            <label>Icon</label>
                                            <select name="masmb_params[cart][icon]" class="form-control"
                                                    aria-describedby="selectHelp">
                                                <option value="1" <?php selected( $cartData['icon'], 1 ) ?> >One</option>
                                                <option value="2" <?php selected( $cartData['icon'], 2 ) ?> >Two</option>
                                                <option value="3" <?php selected( $cartData['icon'], 3 ) ?> >Three</option>
                                                <option value="4" <?php selected( $cartData['icon'], 4 ) ?> >Four</option>
                                            </select>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="micon-name">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                <label>Info</label>
                                                <input  value="1" <?php checked( $infoData['enable'], 1 ) ?> name="masmb_params[info][enable]" style="height:15px!important;width:15px" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <label>Title</label>
                                            <input name="masmb_params[info][title]"type="text" class="form-control">
                                        </div>
                                        <div class="col-sm">
                                            <label>Icon</label>
                                            <select name="masmb_params[info][icon]" id="select" class="form-control"
                                                    aria-describedby="selectHelp">
                                                <option value="1" <?php selected( $infoData['icon'], 1 ) ?> >One</option>
                                                <option value="2" <?php selected( $infoData['icon'], 1 ) ?> >Two</option>
                                                <option value="3" <?php selected( $infoData['icon'], 1 ) ?> >Three</option>
                                                <option value="4"  <?php selected( $infoData['icon'], 1 ) ?> >Four</option>
                                            </select>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="micon-name">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                <label>Setting</label>
                                                <input  value="1" <?php checked( $infoData['enable'], 1 ) ?> name="masmb_params[setting][enable]" style="height:15px!important;width:15px" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <label>Title</label>
                                            <input name="masmb_params[setting][title]" type="text" class="form-control">
                                        </div>
                                        <div class="col-sm">
                                            <label>Icon</label>
                                            <select name="masmb_params[setting][icon]" class="form-control"
                                                    aria-describedby="selectHelp">
                                                <option value="1" <?php selected( $settingData['icon'], 1 ) ?> >One</option>
                                                <option value="2" <?php selected( $settingData['icon'], 2 ) ?> >Two</option>
                                                <option value="3" <?php selected( $settingData['icon'], 3 ) ?> >Three</option>
                                                <option value="4" <?php selected( $settingData['icon'], 4 ) ?> >Four</option>
                                            </select>
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </main>
        <script>
            jQuery(document).ready(function (jQuery) {
                jQuery("#sortable").sortable();

                jQuery('.color_field').each(function () {
                    jQuery(this).wpColorPicker();
                });
            });
        </script>
        <?php

    }
}