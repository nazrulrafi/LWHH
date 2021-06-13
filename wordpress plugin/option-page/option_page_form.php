<?php
$name=get_option("option_page_name");
$latitude=get_option("option_page_latitude");
$longtitude=get_option("option_page_longtitude");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="option-page-form">
                <h2>This is option page title</h2>
                <form method="post" action="<?php echo admin_url('admin-post.php')?>">
                    <?php
                    wp_nonce_field("option_page")
                    ?>
                    <div class="form-group">
                        <label for="option_page_name">Your Name</label>
                        <input type="text" class="form-control" id="option_page_name" name="option_page_name" placeholder="Enter Name" value="<?php echo $name?>">
                    </div>
                    <div class="form-group">
                        <label for="option_page_latitude">Latitude</label>
                        <input type="text" class="form-control" id="option_page_latitude" name="option_page_latitude" placeholder="Enter Latitude" value="<?php echo $latitude?>">
                    </div>
                    <div class="form-group">
                        <label for="option_page_longtitude">Longtitude</label>
                        <input type="text" class="form-control" id="option_page_longtitude" name="option_page_longtitude" placeholder="Enter Name" value="<?php echo $longtitude?>">
                    </div>
                    <input type="hidden" name="action" value="optiondemo_admit_page">
                    <?php submit_button("Save");?>
                </form>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
