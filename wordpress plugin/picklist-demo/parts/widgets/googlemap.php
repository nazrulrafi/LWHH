<?php
/*
Title: google map
Description: A description of what my widget does
*/
?>
<?php 
    $place=$settings['place'];
?>
<div class="mapouter">
    <div class="gmap_canvas">
        <iframe width="400" height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $place?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            <style>
            .mapouter{
                position:relative;
                text-align:right;
                height:500px;
                width:600px;
            }
            .gmap_canvas {
                overflow:hidden;
                background:none!important;
                height:500px;
                width:600px;
            }
            </style>
        
    </div>
</div>