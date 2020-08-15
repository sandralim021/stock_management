<?php
class BrandsModel extends CI_Model {

    public function get_entries(){
        $query = $this->db->where('brand_status',1)
                        ->get('brands');
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

    public function update_entry($data,$id){
        $update = $this->db->update('brands', $data, array('brand_id' => $id));
        return ($update) ? true : false;
    
    }

    public function delete_entry($id){
        $delete = $this->db->set('brand_status',0)
                        ->where('brand_id',$id)
                        ->update('brands');
    
        return ($delete) ? true : false;
    }

    // Check brand exists
    public function check_brand_exists($brand){
        $query = $this->db->get_where('brands', array('brand_name' => $brand, 'brand_status' => 1));
        if(empty($query->row_array())){
            return true;
        } else {
            return false;
        }
    }


}

