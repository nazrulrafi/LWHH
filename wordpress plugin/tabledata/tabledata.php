<?php 
/*
**************************************************************************

Plugin Name:  Table Data
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  table-data
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html

**************************************************************************
*/
require_once "class.persons-table.php";
function tabledata_laod_textdomain(){
    load_plugin_textdomain("table-data",false,dirname(__FILE__)."languages");
}
add_action("plugins_loaded","tabledata_laod_textdomain");
function datatable_admin_page(){
    add_menu_page(
        "Data Table Page",
        "Data Table",
        "manage_options",
        "datatable",
        "datatable_display_table"
    );
}
function datatable_search_by_name($item){
    $name=strtolower($item["name"]);
    $search_name=sanitize_text_field($_REQUEST["s"]);
    if(strpos($name,$search_name)!== false){
        return true;
    }
    return false;
}
function datatable_filter_sex($item){
    $sex=$_REQUEST["filter_s"]??"all";
    if("all"==$sex){
        return true;
    }else{
        if($sex==$item["sex"]){
            return true;
        }
    }
    return false;
}
function datatable_display_table(){
    include_once "dataset.php";
    $orderBy=$_REQUEST["orderby"];
    $order=$_REQUEST["order"];
    if(isset($_REQUEST["s"] ) && !empty($_REQUEST["s"])){
        $data=array_filter($data,"datatable_search_by_name");
    }  
    if(isset($_REQUEST["filter_s"] ) && !empty($_REQUEST["filter_s"])){
        $data=array_filter($data,"datatable_filter_sex");
    }
    $table=new Persons_Table();
    if("age"==$orderBy){
        if("asc"==$order){
            usort($data,function($item01,$item02){
                return $item02["age"]<=>$item01["age"];
            });
        }else{
            usort($data,function($item01,$item02){
                return $item01["age"]<=>$item02["age"];
            }); 
        }
    }elseif("name"==$orderBy){
        if("asc"==$order){
            usort($data,function($item01,$item02){
                return $item02["name"]<=>$item01["name"];
            });
        }else{
            usort($data,function($item01,$item02){
                return $item01["name"]<=>$item02["name"];
            }); 
        }
    }
    $table->set_data($data);
    $table->prepare_items();
?>
<div class="wrap">
    <h2><?php echo __("Persons","table-data")?></h2>
    <form method="GET">
        <?php 
            $table->search_box("search","search_id");
            $table->display();
        ?>
        <input type="hidden" name="page" value="<?php echo $_REQUEST["page"]?>">
    </form>
</div>
<?php
    
}
add_action("admin_menu","datatable_admin_page");