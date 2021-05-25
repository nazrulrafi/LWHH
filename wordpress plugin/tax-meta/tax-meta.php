<?php
/**
 * Plugin Name:       Taxonomy Metabox
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nazrul Rafi
 * Author URI:        https://nazrulrafi.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
function loading_plugin_textdomain(){
    load_plugin_textdomain("tax-meta".false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","loading_plugin_textdomain");
function taxm_bootstrap(){
    $args=array(
        "type"              =>"String",
        "sanitize_callback" =>"sanitize_text_field",
        "single"            =>true,
        "description"       =>"Simple Meta field for category taxonomy",
        "show_in_rest"      =>true
    );
    register_meta("term","texm_extra_info",$args);
}
add_action("init","taxm_bootstrap");
function save_category_meta($term_id){
    if(wp_verify_nonce($_POST["_wpnonce_add-tag"],"add-tag")){
        $extra_info=sanitize_text_field($_POST["extra-info"]);
        update_term_meta($term_id,"taxm_extra_info",$extra_info);
    }
}
add_action("create_category","save_category_meta");
function taxm_update_category_meta($term_id){
    if(wp_verify_nonce($_POST["_wpnonce"],"update-tag_{$term_id}")){
        $extra_info=sanitize_text_field($_POST["extra-info"]);
        update_term_meta($term_id,"taxm_extra_info",$extra_info);
    }
}
add_action("edit_category","taxm_update_category_meta");
function tax_category_form_field(){
    ?>
    <div class="form-field term-name-wrap">
        <label for="extra-info">Extra Info</label>
        <input name="extra-info" id="extra-info" type="text" value=""/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, distinctio ducimus ex laboriosam neque
            nihil odit perspiciatis,</p>
    </div>
    <?php
}
add_action("category_add_form_fields","tax_category_form_field");

function tax_category_edit_form_field($term){
    $val=get_term_meta($term->term_id,"taxm_extra_info",true);
    echo $val;
    ?>
    <tr class="form-field form-required term-name-wrap">
        <th scope="row"><label for="extra-info">Extra Info</label></th>
        <td><input name="extra-info" id="extra-info" type="text" value="<?php echo $val?>"/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, distinctio ducimus ex laboriosam neque
                nihil odit perspiciatis,</p>
        </td>
    </tr>
    <?php
}
add_action("category_edit_form_fields","tax_category_edit_form_field");

