<div class="optiondemo-option-form">
    <h2>This is option page title</h2>
    <form method="post" action="<?php echo admin_url("admin-post.php")?>">
        <?php 
            wp_nonce_field("optiondemo");
            $latitude=get_option("optiondemo_latitude02");
            $lontitude=get_option("optiondemo_lontitude02");
        ?>
        <div class="form-group">
            <label for="optiondemo_latitude02"><?php _e("Latitude","optionDemo")?></label>
            <input type="text" class="form-control" id="optiondemo_latitude02" placeholder="Enter latitude" name="optiondemo_latitude02" value="<?php echo $latitude?>">
        </div>
        <div class="form-group">
            <label for="optiondemo_lontitude02"><?php _e("Lontitude","optionDemo")?></label>
            <input type="text" class="form-control" id="optiondemo_lontitude02" placeholder="Enter Lontitude" name="optiondemo_lontitude02" value="<?php echo $lontitude?>">
        </div>
        <input type="hidden" name="action" value="optiondemo_admin_page"/>
        <?php 
            submit_button("Save");
        ?>
    </form>
</div>