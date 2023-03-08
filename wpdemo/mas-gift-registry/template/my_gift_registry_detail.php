<?php
$masr_nonce  = wp_create_nonce("masr_ajax_update_item");
$isLogin = is_user_logged_in();
$ajax_nonce = wp_create_nonce("masr_ajax_get_registry");
$ajax_nonce_submit_registry = wp_create_nonce("masr_ajax_submit_registry");
/** @var  $ajax_url */
$ajax_url = admin_url( 'admin-ajax.php' );
?>
<script type="text/javascript">
    var ajax_nonce = '<?php  echo $ajax_nonce ?>';
    var ajax_nonce_sr = '<?php echo $ajax_nonce_submit_registry ?>';
    var ajax_url = '<?php echo $ajax_url ?>';


</script>
<style>
    li {
        list-style-type: none !important; display: inline-block
    }

</style>
<?php

if ( $isLogin) { ?>
    <script type="text/javascript">
        var masIsLogin = true;

    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">

        var masIsLogin = false;
    </script>

<?php } ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
<script type="text/javascript" src="<?php echo WOOREG_URL ?>/assets/js/knockout.validation.js"></script>
<link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/css/bootstrap-polaris.min.css' media='all' />
<script type="text/javascript" >
    var masr_nonce = '<?php echo $masr_nonce; ?>'
    var masrPriority = [];
    masrPriority.push({
        value : 1,
        label : '<?php echo __('Highest') ?>'
    });
    masrPriority.push({
        value : 2,
        label : '<?php echo __('Normal') ?>'
    });

    masrPriority.push({
        value : 3,
        label : '<?php echo __('Trivial') ?>'
    });
    let masrQtyArr= [{value: 1,label:1}, {value: 2,label:2}, {value: 3,label:3},{value: 4,label:4} ,{value: 5,label:5}];

</script>
<main class="container-fluid">
    <header class="page-header">
        <div class="page-header__content">
            <h1 class="display-2"><?php echo __('My gift registry' , 'masr') ?></h1>
        </div>

    </header>

    <div class="card">
        <!--Loading route -->
        <div data-bind="css: { display: state() == 'loading','not_display': state() != 'loading'}" >
            <div class="loader">
                <div class="loader-wheel"></div>
                <div class="loader-text"></div>
            </div>
        </div>
        <!--Loaded-->
        <div data-bind="css: { display: state() != 'loading','not_display': state() == 'loading'}" >
            <div class="card-header-actions">
                <ul class="card-header-tabs">
                    <li class="card-header-tab">
                        <a  data-bind="click: $root.itemTabClick(this),css: { active: currentTab() == 'item','inactive': currentTab() != 'item'}"  href="#"   ><?php echo __('Item','masr') ?></a>
                    </li>
                    <li class="card-header-tab">
                        <a data-bind="click: $root.shareTabClick(this),css: { active: currentTab() == 'share','inactive': currentTab() != 'share'}"  href="#"  ><?php echo __('Share' , 'masr')  ?></a>
                    </li>
                    <li class="card-header-tab">
                        <a  data-bind="click: $root.infoTabClick(this),css: { active: currentTab() == 'info','inactive': currentTab() != 'info'}" href="#" ><?php echo __('Information' , 'masr') ?></a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div id="item_tab_content" data-bind="css: { display: currentTab() == 'item','not_display': currentTab() != 'item'}" >
                    <?php if (count($items) ==0 ) {  ?>
                    <span><?php echo __('There is no item in your gift registry. Please create new one','masr')  ?></span>
                    <?php } else  { ?>
                    <div>
                        <h3><?php echo __('List of item in gift registry' , 'masr')  ?></h3>
                    </div>

                    <div class="card-body-section table-responsive-wrapper">
                        <table>
                            <thead>
                            <tr>
                                <td>
                                    <?php echo __('Product name' , 'masr') ?>
                                </td>
                                <td>
                                    <?php echo __('Product image' , 'masr') ?>
                                </td>
                                <td>
                                    <?php echo __('Price' , 'masr') ?>
                                </td>
                                <td>
                                    <?php echo __('Quantity' , 'masr') ?>
                                </td>
                                <td>
                                    <?php echo __('Priority' , 'masr') ?>
                                </td>
                                <td>
                                    <?php echo __('Delete' , 'masr') ?>
                                </td>
                            </tr>
                            </thead>
                            <?php
                            for ($i = 0; $i < count($items); $i++) {
                                $item = $items[$i];

                                ?>
                                <tr id="tr<?php echo $item['ID'] ?>">
                                    <td><?php echo $item['name'] ?>  </td>
                                    <td> <img class="masr_item_img" src="<?php echo $item['img'] ?>" /></td>
                                    <td><?php echo $item['price_html'] ?></td>
                                    <td>
                                        <select data-id="<?php echo $item['ID'] ?>" class="masr_qty" data-val="<?php echo  $item['quantity'] ?>" data-bind="change:$root.changePriorityAction(this,'qty')" onchange="window.$root.changeQuantityAction(this,'qty')">
                                            <option > <?php echo __('Select quantity' , 'masr') ?></option>
                                        </select>

                                    </td>
                                    <td>
                                        <select data-id="<?php echo $item['ID'] ?>" class="masr_priority" data-val="<?php echo  $item['priority'] ?>" data-bind="change:$root.changePriorityAction(this,'priority')" onchange="window.$root.changePriorityAction(this,'priority')">
                                            <option > <?php echo __('Select priority' , 'masr') ?></option>
                                        </select>
                                    </td>
                                    <td> <button data-id="<?php echo $item['ID'] ?>" onclick="window.$root.deleteItemAction(this,'<?php echo $item['ID'] ?>')"> <?php echo __('Delete') ?></button></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <?php  }  ?>
                </div>
                <div id="share_tab_content" data-bind="css: { display: currentTab() == 'share','not_display': currentTab() != 'share'}">
                    <?php echo __('Share gift registry with your friend' ,'masr')  ?>
                    <?php
                    $url     = urlencode( $publicViewUrl );

                    $facebook_share_link = "https://www.facebook.com/sharer.php?s=100" . "&amp;p[url]=" . $url ;
                    $twitter_share_link  = "https://twitter.com/share?url=" . $url ;


                    ?>
                    <ul class="masr_share_ul">
                        <li>
                            <a href="<?php echo $facebook_share_link  ?>">
                                <img  width="48" style="width: 48px;" src="<?php echo WOOREG_URL ?>/assets/img/share.png">
                            </a>
                        </li>
                        <li>
                            <a  href="<?php echo $twitter_share_link  ?>">
                                <img src="<?php echo WOOREG_URL ?>/assets/img/tw.png">
                            </a>
                        </li>
                        <li>
                            <a  href="<?php echo $facebook_share_link  ?>">
                                <img src="<?php echo WOOREG_URL ?>/assets/img/fb.png">
                            </a>
                        </li>

                    </ul>

                    <section>
                        <button class="btn btn-primary" onclick="masrGenerateQr('<?php echo $url ?>')"> <?php echo __('Generate QR' ,'masr') ?></button>
                        <p> <?php echo __('click button to generate QR code, then download it and share the qr code image via Facebook,Instagram') ?></p>
                        <div id="qrcode"></div>
                    </section>
                </div>
                <div id="info_tab_content" data-bind="css: { display: currentTab() == 'info','not_display': currentTab() != 'info'}">
                    <?php echo __('Gift registry information' ,'masr')  ?>
                    <div class="row no-gutters">
                        <div class="col-md-4 card-annotation">
                            <h3><?php echo __('Information' ,'masr') ?></h3>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <label for="title"><?php echo __('Title', 'masr') ?></label>
                                        <input type="text" id="masr_title" class="form-control" name="title" value="<?php echo $info['title'] ?>" />
                                        <label for="description"><?php echo __('Description' , 'masr') ?></label>
                                        <input id = "masr_description" type="text"  value="<?php echo $info['description'] ?>"  class="form-control" name="description" />
                                        <label for="email"><?php echo __('Email' , 'masr') ?></label>
                                        <input id="masr_email" type="email"   value="<?php echo $info['email'] ?>" class="form-control" name="email" />
                                        <label> <?php echo __('owner last name', 'masr')  ?></label>
                                        <input id="masr_last_name" type="text"  value="<?php echo $info['last_name'] ?>"  name="last_name"  class="form-control" />
                                        <label> <?php echo __('owner first name', 'masr')  ?></label>
                                        <input id="masr_first_name" type="text" name="first_name" value="<?php echo $info['first_name'] ?>"  class="form-control"  />
                                        <input id="masr_id" type="hidden" name="masr_id" value="<?php echo $info['ID'] ?>"  class="form-control"  />

                                        <div class="btn-group btn-group--spaced" role="group" aria-label="Related Actions" style="margin-top:20px">
                                            <button type="button" class="btn btn-primary" onclick="window.$root.submitGift()"><?php echo __('Save','mars')  ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--End of loaded-->

    </div>
</main>

<script type="text/javascript" src="<?php   echo WOOREG_URL?>/assets/js/gift_registry_detail.js"></script>