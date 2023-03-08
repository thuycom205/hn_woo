<?php
?>
<script src="<?php echo WOOREG_URL ?>/assets/js/gridjs.umd.js"></script>
<link href="<?php echo WOOREG_URL ?>/assets/css/mermaid.min.css" rel="stylesheet" />



<h2> <?php  echo __('Incentive coupon', 'masr') ?></h2>
<div id="wrapper"></div>
<script src="<?php echo WOOREG_URL ?>/assets/js/gridjs.umd.js"></script>
<?php
$return_arr =Mars_GiftRegistry_Util::getCouponForGiftRegistry($id);

$json = wp_json_encode($return_arr);

?>
<script type="text/javascript">
var gdata = '<?php echo  $json?>';
var adminUrl = '<?php echo admin_url( 'post.php' )?>';
var json = JSON.parse(gdata);
const grid = new gridjs.Grid({
    columns: [{
        id: 'coupon',
        name: 'Coupon'
    }, {
        id: 'coupon_amount',
        name: 'Coupon Amount'
    }, {
        id: 'order_id',
        name: 'Order Id',
        formatter: (_, row) => gridjs.html(`<a href='${adminUrl}?post=${row.cells[2].data}&action=edit'>Order</a>`)
    },
        {
            id: 'created_at',
            name: 'Created At'
        }
    ],
    data:json,
    search: true
}).render(document.getElementById("wrapper"));
</script>