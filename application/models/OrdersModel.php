<?php
    class OrdersModel extends CI_Model{
        
        public function get_products(){
            $query = $this->db->get('products');
            return $query->result_array();
        }
        public function insert_entry($data){
            $insert = $this->db->insert('order_details', $data);
            return ($insert == true) ? true : false;
        }
    }