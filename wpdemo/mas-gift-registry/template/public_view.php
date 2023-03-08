<script type="text/javascript" src="<?php echo WOOREG_URL ?>/assets/js/knockout-min.js"></script>
<script type="text/javascript" src="<?php echo WOOREG_URL ?>/assets/js/knockout.validation.js"></script>
<link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/css/bootstrap-polaris.min.css' media='all' />
<script type="text/javascript" >
    var masrPriority = [];
    masrPriority.push({
        value : 1,
        label : '<?php echo __('Highest','masr') ?>'
    });
    masrPriority.push({
        value : 2,
        label : '<?php echo __('Normal','masr') ?>'
    });

    masrPriority.push({
        value : 3,
        label : '<?php echo __('Trivial','masr') ?>'
    });
    let masrQtyArr= [{value: 1,label:1}, {value: 2,label:2}, {value: 3,label:3},{value: 4,label:4} ,{value: 5,label:5}];

</script>

<?php if (count($items) >  0) {  ?>
<main class="container-fluid">

        <div class="card">

            <!--Loaded-->
            <div data-bind="css: { display: state() != 'loading','not_display': state() == 'loading'}" >

                <div class="card-body">
                    <div id="item_tab_content" data-bind="css: { display: currentTab() == 'item','not_display': currentTab() != 'item'}" >
                        <div>
                            <h3><?php echo __('List of items in gift registry', 'masr')  ?></h3>
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
                                        <?php echo __('Add to cart' , 'masr') ?>
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
                                        <td> <img class="masr_item_img" src="<?php echo $item['img'] ?>" /></td>
                                        <td><?php echo $item['price_html'] ?></td>
                                        <td><?php   echo $item['quantity']  ?></td>

                                        <td>
                                            <select disabled="disabled" data-id="<?php echo $item['ID'] ?>" class="masr_priority" data-val="<?php echo  $item['priority'] ?>" >
                                            </select>
                                        </td>
                                        <td> <button  data-gr-itemid = "<?php echo $item['ID']  ?>" data-query="<?php echo $item['query'] ?>" data-product-id="<?php echo $item['product_id']?>" data-qty="<?php echo $item['quantity'] ?>" data-variation-id="<?php echo $variation_id ?>" onclick="masr_add_item_cart(this ,'<?php echo $cartlink?>', '<?php echo $id ?>')"> <?php echo __('Add to cart','masr') ?></button></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!--End of loaded-->
        </div>
</main>
<script type="text/javascript" src="<?php   echo WOOREG_URL?>/assets/js/publicView.js"></script>
<?php  } else { ?>
<h2> <?php echo __('There is no item in this gift registry')  ?></h2>
<?php } ?>
