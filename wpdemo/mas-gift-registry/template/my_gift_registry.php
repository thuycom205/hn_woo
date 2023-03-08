<?php
if (isset( WC()->session ))   {
   echo  WC()->session->gift_registry_id ;
}
$ajax_nonce = wp_create_nonce("masr_ajax_get_registry");
$ajax_nonce_for_remove = wp_create_nonce("masr_ajax_remove_registry");
$ajax_nonce_for_submit = wp_create_nonce("masr_ajax_submit_registry");
$isLogin = is_user_logged_in();
$args = array(
    'posts_per_page'   => 1,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'page',
    'guid'      => 'giftregistry'
);

$page = get_posts( $args );
if (!is_array($page));
$gp = $page[0];
$mas_gr_link = get_permalink( wc_get_page_id( 'mas-gift-registry' ) );

$mas_gr_link2 = get_permalink( $gp->ID );
$id = 0;
if(strpos($mas_gr_link, "?") !== false) {
    $endpoint = $mas_gr_link.'&view-gift-registry=0';
} else {
    $endpoint = $mas_gr_link.'?view-gift-registry=0';

}
?>
<script type="text/javascript">
    var masEndpoint  = '<?php echo $endpoint?>';
    var ajax_nonce = '<?php  echo $ajax_nonce ?>'
    var ajax_nonce_rm = '<?php  echo $ajax_nonce_for_remove ?>'
    var ajax_nonce_sb = '<?php  echo $ajax_nonce_for_submit ?>'

</script>
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
<style>
    body { font-family: arial; font-size: 14px; }


    li { list-style-type: disc; margin-left: 20px; }
    .display { display: block!important;}
    .not_display { display: none!important;}

</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
<script type="text/javascript" src="<?php echo WOOREG_URL ?>/assets/js/knockout.validation.js"></script>
<script type="text/javascript" src="https://knockoutjs.com/js/jquery.validate.js" ></script>
<script type="text/javascript" src="<?php echo WOOREG_URL ?>/assets/js/datatables.js" ></script>
<link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/datatables.css' media='all' />
<link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/masr.css' media='all' />
<link rel='stylesheet' id='table-css'  href='<?php echo WOOREG_URL ?>/assets/css/bootstrap-polaris.min.css' media='all' />
<main class="container">

<div class='card'>
    <div class="card-body">
    <input type="hidden" id="masr_admin_url" value="<?php echo admin_url( 'admin-ajax.php' ) ?>" />
    <!--Not login route -->
    <div data-bind="css: { display: currentRoute() == 'guest','not_display': currentRoute() != 'guest'}">
        <div> <?php echo __('Please login to manage your gift registry' ,'masr')  ?></div>
    </div>
    <!-- End of not login route-->
    <!--Loading route -->
    <div data-bind="css: { display: state() == 'loading','not_display': state() != 'loading'}" >
        <div class="loader">
            <div class="loader-wheel"></div>
            <div class="loader-text"></div>
        </div>
    </div>
    <!--end of Loading route -->

    <!-- Form View-->

    <div data-bind="css: { display: currentRoute() == 'form','not_display': currentRoute() != 'form'}">
        <div class="row no-gutters">
            <div class="col-md-4 card-annotation">
                <h3><?php echo __('Gift registry information') ?></h3>
                <p id="create_gr_guide"><?php echo __('Fulfill necessary information','masr') ?></p>
            </div>
            <div class="col-md-8" >
        <div>
            <button type="button" class="btn btn-secondary" data-bind="click: $root.backToList">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"></path>
                </svg>
            </button>
        </div>
    <table>
        <tr>
            <td><?php echo __("Title",'masr')  ?> *</td> <td> <input name="masr_title" class="form-control" id="masr_title"  data-bind="value:newTitle"/> </td> <td data-bind="css: { display: $root.validTitle() == 'failed','not_display': $root.validTitle() != 'failed'}"> <?php echo __('This field is required')  ?> </td>
        </tr>
        <tr>
            <td><?php echo __("Description",'masr') ?> *</td> <td> <input name="masr_description"  class="form-control"  id="masr_description" data-bind="value:newDes" /> </td><td data-bind="css: { display: validDes() == 'failed','not_display': validDes() != 'failed'}"> <?php echo __('This field is required')  ?> </td>
        </tr>
        <tr>
            <td><?php echo __("Owner last name", "masr") ?> *</td> <td> <input name="masr_last_name" class="form-control" id="masr_last_name" data-bind="value:newLastName" /></td> <td data-bind="css: { display: validLastName() == 'failed','not_display': validLastName() != 'failed'}"> <?php echo __('This field is required')  ?> </td>
        </tr>
        <tr>
            <td><?php echo __("Owner first name", "masr") ?> *</td> <td> <input name="masr_first_name"  class="form-control" id="masr_first_name"  data-bind="value:newFirstName" /></td> <td data-bind="css: { display: validFirstName() == 'failed','not_display': validFirstName() != 'failed'}"> <?php echo __('This field is required')  ?> </td>
        </tr>
        <tr>
            <td><?php echo __("Owner email", "masr") ?> *</td> <td> <input name="masr_email"  class="form-control" id="masr_email" data-bind="value:newEmail" /></td><td data-bind="css: { display: validEmail() == 'failed','not_display': validEmail() != 'failed'}"> <?php echo __('This field is required')  ?> </td>
        </tr>
    </table>
        <button class="btn btn-primary" data-bind="click: $root.submitGift"> <?php echo __('Submit' , 'masr')  ?> </button>
    </div>
        </div>
    </div>

    <!--End of form view -->
    <!-- ko if: currentGift -->
    <div>

    </div>
    <!-- /ko -->


    <!--List view -->
    <div data-bind="css: { display: currentRoute() == 'list','not_display': currentRoute() != 'list'}">
        <div class="loading_state"  data-bind="css: { display: state() == 'loading','not_display': state() != 'loading'}"> </div>
        <div class="error_state"  > </div>
        <div class="empty_state" data-bind="css: { display: state() == 'empty','not_display': state() != 'empty'}" >
            <?php echo __('Your gift registry is empty. Please create a new one', 'masr') ?>
            <div>
                <button type="button" class="btn btn-primary" data-bind='click: addGift' > <?php echo __('Create' , 'masr') ?></button>
            </div>
        </div>

        <div class="loaded_state" data-bind="css: { display: state() == 'loaded','not_display': state() != 'loaded'}">
        <div>
            <div>
                <button type="button" class="btn btn-primary" data-bind='click: addGift' > <?php echo __('Create' , 'masr') ?></button>
            </div>
        </div>
            <!-- ko if: gifts().length == 0-->
            <div class="empty-results">
                <h2 class="empty-results__title"> <?php echo __('Your gift registry is empty','masr') ?></h2>
            <span><?php echo __('Please create a new one', 'masr')  ?></span>
            </div>
            <!--/ko -->
            <!-- ko if: gifts().length > 0-->

            <table >
            <thead>
            <tr>
                <th><?php echo __('Title' , 'masr') ?></th>
                <th><?php echo __('Description' , 'masr')  ?></th>
                <th />
            </tr>
            </thead>
            <tbody data-bind='foreach: gifts'>
            <tr>
                <td><input class='required' data-bind='value: title, uniqueName: true' /></td>
                <td><input class='required ' data-bind='value: description, uniqueName: true' /></td>
                <td><a href='#' data-bind='click: $root.viewDetail'><?php echo __('Detail', 'masr')  ?></a></td>
                <td><a href='#' data-bind='click: $root.removeGift'><?php echo __('Delete', 'masr')  ?></a></td>
            </tr>
            </tbody>
        </table>
            <!-- /ko -->


            <!--        <button data-bind='enable: gifts().length > 0' type='submit'>Submit</button>-->
    </div>
    </div>
    <!--end of List view-->
</div>
</div>

</main>
<script type="text/javascript" src="<?php echo WOOREG_URL?>/assets/js/my_gift_registry.js">


    // Activate jQuery Validation
  //  $("form").validate({ submitHandler: viewModel.save });
</script>
