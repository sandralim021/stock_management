<?php
class CategoriesModel extends CI_Model {

    public function get_entries(){
        $query = $this->db->get('categories');
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

    public function update_entry($data){
        $update = $this->db->update('categories', $data, array('category_id' => $data['category_id']));
        return ($update) ? true : false;
    
    }

    public function delete_entry($id){
        $delete = $this->db->delete('categories', array('category_id' => $id));
        return ($delete) ? true : false;
    }


}

