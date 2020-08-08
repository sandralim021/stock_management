<?php
    class OrdersModel extends CI_Model{
        
        public function get_products(){
            $query = $this->db->get('products');
            return $query->result_array();
        }
        public function insert_entry($data){
            $insert = $this->db->insert('orders', $data);
            if($insert){
                return $inserted_id = $this->db->insert_id();
            }
        }
        public function insert_order_details($data){
            $insert = $this->db->insert_batch('order_details', $data);
            return ($insert == true) ? true : false;
        }
        public function qty_price($id){
            $query = $this->db->select("qty,price")
                            ->from("products")
                            ->where("product_id",$id)
                            ->get();
            if(count($query->result()) > 0){
                return $query->row();
            }else{
                return false;
            }
        }
    }