<?php
?>
<div>
    <button>Create</button>


</div>
<table id="table_id" >
    <thead>
    <tr>
        <th>Column 1</th>
        <th>Column 2</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Row 1 Data 1</td>
        <td>Row 1 Data 2</td>
    </tr>
    <tr>
        <td>Row 2 Data 1</td>
        <td>Row 2 Data 2</td>
    </tr>
    </tbody>
</table>
<script type="text/javascript">
    jQuery(document).ready( function () {
        jQuery('#table_id').DataTable();
    } );
</script>
<!--<script src="https://unpkg.com/vue@3"></script>-->
<!---->
<!--<div id="app">{{ message }}</div>-->
<!---->
<!--<script>-->
<!--    const { createApp } = Vue-->
<!---->
<!--    createApp({-->
<!--        data() {-->
<!--            return {-->
<!--                message: 'Hello Vue!'-->
<!--            }-->
<!--        }-->
<!--    }).mount('#app')-->
<!--</script>-->
