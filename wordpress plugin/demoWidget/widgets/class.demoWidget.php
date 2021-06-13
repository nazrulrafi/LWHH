<?php 
class DemoWidget extends WP_Widget{
    public function __construct(){
        parent::__construct(
            "demowidget",
            __("Demo Widget","demowidget"),
           array("description"=>__("Our Widget Description","demowidget")) 
        );
    }
    public function form($instance){
        $title=isset($instance["title"])?$instance["title"]:__("Demo Widget","demowidget");
        $latitude=isset($instance["latitude"])?$instance["latitude"]:25.45;
        $lontitude=isset($instance["lontitude"])?$instance["lontitude"]:58.45;
        $email=isset($instance["email"])?$instance["email"]:"jhon@gmail.com";
?>
    <label for="<?php echo esc_attr($this->get_field_id("title"))?>"><?php _e("Demo Widget","demowidget")?></label>
    <input 
        type="text" 
        id="<?php echo esc_attr($this->get_field_id("title"))?>" 
        name="<?php echo esc_attr($this->get_field_name("title"))?>" 
        value="<?php echo $title?>"
        class="widefat"
    /> 
    <label for="<?php echo esc_attr($this->get_field_id("latitude"))?>"><?php _e("Latitude","demowidget")?></label>
    <input 
        type="text" 
        id="<?php echo esc_attr($this->get_field_id("latitude"))?>" 
        name="<?php echo esc_attr($this->get_field_name("latitude"))?>" 
        value="<?php echo $latitude?>"
        class="widefat"
    /> 
    <label for="<?php echo esc_attr($this->get_field_id("lontitude"))?>"><?php _e("longtitude","demowidget")?></label>
    <input 
        type="text" 
        id="<?php echo esc_attr($this->get_field_id("lontitude"))?>" 
        name="<?php echo esc_attr($this->get_field_name("lontitude"))?>" 
        value="<?php echo $lontitude?>"
        class="widefat"
    /> 
    <label for="<?php echo esc_attr($this->get_field_id("email"))?>"><?php _e("Email","demowidget")?></label>
    <input 
        type="text" 
        id="<?php echo esc_attr($this->get_field_id("email"))?>" 
        name="<?php echo esc_attr($this->get_field_name("email"))?>" 
        value="<?php echo $email?>"
        class="widefat"
    />        
<?php
    } 
    public function widget($args,$instance){
        echo $args["before_widget"];
        if(isset($instance["title"])&& $instance["title"]!=""){
            echo $args["before_title"];
            echo apply_filters("widget_title",$instance["title"]);
            echo $args["after_title"];
?>
        <div class="demowidget">
            <p>Latitude:<?php echo isset($instance["latitude"])?$instance["latitude"]:"N/A"?></p>
            <p>Lontitude:<?php echo isset($instance["lontitude"])?$instance["lontitude"]:"N/A"?></p>
        </div>
<?php
        }
        echo $args["after_widget"];
     }
    public function update($new_instance,$old_instance){
        $instance=$new_instance;
        $instance["title"]=sanitize_text_field($instance["title"]);
        $email=$new_instance["email"];
        if(!is_email($email)){
            $instance["email"]=$old_instance["email"];
        }
        if(!is_numeric($new_instance["latitude"])){
            $instance["latitude"]=$old_instance["latitude"];
        } 
        if(!is_numeric($new_instance["lontitude"])){
            $instance["lontitude"]=$old_instance["lontitude"];
        }
        return $instance;
    }
}


