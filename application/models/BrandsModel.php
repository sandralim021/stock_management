<?php
class BrandsModel extends CI_Model {

    public function get_entries(){
        $query = $this->db->get('brands');
        return $query->result_array();
    }

    public function insert_entry($data){
        $insert = $this->db->insert('brands', $data);
        return ($insert == true) ? true : false;
    }

    public function single_entry($id){
        $query = $this->db->select("*")
                        ->from("brands")
                        ->where("brand_id",$id)
                        ->get();
        if(count($query->result()) > 0){
            return $query->row();
        }else{
            return false;
        }

    }

    public function update_entry($data){
        $update = $this->db->update('brands', $data, array('brand_id' => $data['brand_id']));
        return ($update) ? true : false;
    
    }

    public function delete_entry($id){
        $delete = $this->db->delete('brands', array('brand_id' => $id));
        return ($delete) ? true : false;
    }


}

