<?php
class ProductsModel extends CI_Model {

    public function get_entries(){
        $query = $this->db
                     ->select('*')
                     ->from('products')
                     ->join('brands','brands.brand_id = products.brand_id','left')
                     ->join('categories','categories.category_id = products.category_id','left')
                     ->get();
        
        return $query->result_array();
       
    }
    public function get_brands(){
        $query = $this->db->get('brands');
        return $query->result_array();
    }

    public function get_categories(){
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    public function insert_entry($data){
        $insert = $this->db->insert('products', $data);
        return ($insert == true) ? true : false;
    
    }

    public function single_entry($id){
        $query = $this->db->select("*")
                    ->from("products")
                    ->where("product_id",$id)
                    ->get();

        if(count($query->result()) > 0){
            return $query->row();
        }else{
            return false;
        }

    }

    public function update_entry($data){
        $update = $this->db->update('products', $data, array('product_id' => $data['product_id']));
        return ($update) ? true : false;
    
    }

    public function delete_entry($id){
        $delete = $this->db->delete('products', array('product_id' => $id));
        return ($delete) ? true : false;
    }

}
