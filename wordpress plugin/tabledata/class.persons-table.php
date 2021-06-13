<?php 
if(!class_exists("Wp_List_Table")){
    require_once ("ABSPATH"."wp-admin/includes/class-wp-list-table.php");
}
class Persons_Table extends Wp_List_Table{
    public $_items;
    function __construct($args=array()){
        parent::__construct($args);
    }
    function set_data($data){
        $this->_items=$data;
    }
    function get_columns(){
        return [
            "cb"    =>"<input type='checkbox'>",
            "name"  =>__("Name","table-data"),
            "sex"   =>__("Gender","table-data"),
            "email" =>__("Email","table-data"),
            "age"   =>__("Age","table-data"),
        ];
    }
    function get_sortable_columns(){
        return[
            "age"   =>["age",true],
            "name"  =>["name",true],
        ];
    }

    function extra_tablenav($which){
        if("top"==$which){
?>
    <div class="actions alignleft">
        <select name="filter_s" id="filter_s">
            <option value="all">All</option>
            <option value="M">Males</option>
            <option value="F">Females</option>
        </select>
        <?php submit_button("Filter","primary","submit",false)?>
    </div>
<?php
        }
    }
    function prepare_items(){
        $paged=$_REQUEST["paged"]??1;
        $per_page=3;
        $total_items=count($this->_items);
        $this->_column_headers=array($this->get_columns(),array(),$this->get_sortable_columns());
        $data_chunk=array_chunk($this->_items,$per_page);
        $this->items=$data_chunk[$paged-1];
        $this->set_pagination_args([
            "total_items"   =>$total_items,
            "per_page"      =>$per_page,
            "total_pages"   =>ceil(count($this->_items)/$per_page)
        ]);
    }
    function column_cb($item){
        return "<input type='checkbox' value='{$item["id"]}'/>";
    } 
    function column_name($item){
        $name=ucfirst($item['name']);
        return "<strong>{$name}</strong>";
    }
    function column_default($item, $column_name){
        return $item[$column_name];
    }
}