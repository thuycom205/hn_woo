<?php
/**
 * @class   WooRegAdminMenus
 *
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (class_exists('WooRegAdminMenus', false)) {
  //  return new WooRegAdminMenus();
}

/**
 * WooRegAdminMenus Class.
 */

class WooRegAdminMenus
{
    public static $capabilities = 'manage_options';
    /**
     * Hook in tabs.
     */
    public function __construct()
    {
        // Add menus.
        add_action('admin_menu', array($this, 'adminMenu'));
        add_filter('set-screen-option', array(__class__, 'wooreg_set_option'), 10, 3 );
    }
    function wooreg_set_option($status, $option, $value)
    {
        if ('wooreg_items_per_page' == $option) return $value;
        return $status;
    }

    /**
     * Add menu items.
     */
    public function adminMenu()
    {
        add_menu_page('Gift Registry', 'WooCommerce Gift Registry', WooRegAdminMenus::$capabilities, 'edit.php?post_type=mas_gift', '', 'dashicons-wheel', 100);
        add_submenu_page('edit.php?post_type=mas_gift', 'Gift Registry Detail', 'Gift Registry Detail', WooRegAdminMenus::$capabilities, 'masr_detail', 'WooRegAdminMenus::viewRegistry');

    }
    public static function viewRegistry() {
        $giftId = (int) $_REQUEST ['id'];
        if (!isset($_GET['coupon'])) {

        $items = MAS_Shortcode::getItems($giftId);
       // $cartlink = get_permalink(wc_get_page_id( 'cart' ));
       // $info = WooReg()::$main->getRegistryInfo($giftId);
 ?>
        <link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/css/bootstrap-polaris.min.css' media='all' />
 <main class="container-fluid">

    <div class="card">
        <div class="card-body">

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

                </tr>
                </thead>
                <?php
                for ($i = 0; $i < count($items); $i++) {
                    $item = $items[$i];
                    $variation_id= 0;
                    if ($item['variation_id']) {
                        $variation_id = $item['variation_id'];
                    }
                    ?>
                    <tr data-id="<?php echo $item['ID'] ?>">
                        <td><?php echo $item['name'] ?>  </td>
                        <td> <img style="width: 150px" class="masr_item_img" src="<?php echo $item['img'] ?>" /></td>
                        <td><?php echo $item['price_html'] ?></td>
                        <td><?php   echo $item['quantity']  ?></td>

                        <td>
                            <select disabled="disabled" data-id="<?php echo $item['ID'] ?>" class="masr_priority" data-val="<?php echo  $item['priority'] ?>" >
                            </select>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        </div>
        </div>
 </main>
        <script type="text/javascript" >
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

        <script type="text/javascript" src="<?php   echo WOOREG_URL?>/assets/js/publicView.js"></script>
        <?php } else {
            $coupon=[];
            $template_path = WOOREG_ABSPATH . 'admin/template/';
            wc_get_template(
                'view_coupon.php',
                array(
                        'id' =>$giftId,
                    'coupons' => '$fields'
                ),
                $template_path, $template_path
            );
        } ?>
        <!-- -->
        <?php

    }
}

return new WooRegAdminMenus();
