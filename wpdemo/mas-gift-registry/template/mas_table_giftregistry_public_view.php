<?php
?>
<script src="<?php echo WOOREG_URL ?>/assets/js/gridjs.umd.js"></script>
<link href="<?php echo WOOREG_URL ?>/assets/css/mermaid.min.css" rel="stylesheet" />
<?php echo __('Gift Registry Program') ?>
<div>
    <div id="wrapper"></div>

</div>
<?php
$return_arr =Mars_GiftRegistry_Util::getAllGiftRegistry();

$json = wp_json_encode($return_arr);
?>
<script type="text/javascript">
    var gdata = '<?php echo  $json?>';
    var adminUrl = '<?php echo admin_url( 'post.php' )?>';
    var json = JSON.parse(gdata);
    const grid = new gridjs.Grid({
        columns: [{
            id: 'first_name',
            name: 'First Name'
        },
         {
            id: 'last_name',
            name: 'Last Title'
        },
         {
            id: 'title',
            name: 'Title',
        },
            {
            id: 'url',
            name: 'Detail',
            formatter: (_, row) => gridjs.html(`<a href='${row.cells[3].data}'>View</a>`)
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