<?php

namespace Mas\Whatsapp\Admin;
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class AbandonedCartTable
{
  public function view()
  {
      ?>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

      <table id="table_id" class="display">
          <table id="example" class="display">
              <thead>
              <tr>
                  <th><?php echo __('First name' , 'maswa')  ?></th>
                  <th><?php echo __('Last name' , 'maswa')  ?> </th>
                  <th><?php echo __('Email' , 'maswa')  ?></th>
                  <th><?php echo __('Total' , 'maswa')  ?></th>

              </tr>
              </thead>
              <tfoot>
              <tr>
                  <th><?php echo __('First name' , 'maswa')  ?></th>
                  <th><?php echo __('Last name' , 'maswa')  ?></th>
                  <th><?php echo __('Email' , 'maswa')  ?></th>
                  <th><?php echo __('Total' , 'maswa')  ?></th>

              </tr>
              </tfoot>
      </table>
      <script>
          jQuery(document).ready(function () {
              jQuery('#example').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=maswa_ajax_get_abandoned_cart',
              });
          });

      </script>
   <?php

  }
}