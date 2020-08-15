<?php
class CategoriesModel extends CI_Model {

    public function get_entries(){
        $query = $this->db->where('cat_status',1)
                        ->order_by('category_name','ASC')
                        ->get('categories');
        return $query->result_array();
    }

    public function insert_entry($data){
        $insert = $this->db->insert('categories', $data);
        return ($insert == true) ? true : false;
    
    }

    public function single_entry($id){
        $query = $this->db->select("*")
                        ->from("categories")
                        ->where("category_id",$id)
                        ->get();
        if(count($query->result()) > 0){
            return $query->row();
        }else{
            return false;
        }

    }

    public function update_entry($data,$id){
        $update = $this->db->update('categories', $data, array('category_id' => $id));
        return ($update) ? true : false;
    
    }

    public function delete_entry($id){
        $delete = $this->db->set('cat_status',0)
                        ->where('category_id',$id)
                        ->update('categories');

        return ($delete) ? true : false;
    }

    // Check category exists
    public function check_category_exists($category){
        $query = $this->db->get_where('categories', array('category_name' => $category, 'cat_status' => 1));
        if(empty($query->row_array())){
            return true;
        } else {
            return false;
        }
    }


}

