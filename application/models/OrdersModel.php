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

        public function fetch_orders(){
            $query = $this->db
                     ->select('*')
                     ->from('orders')
                     ->get();
        
            return $query->result_array();
        }

        public function edit_payment($id){
            $query = $this->db->select("*")
                            ->from("orders")
                            ->where("order_id",$id)
                            ->get();
            if(count($query->result()) > 0){
                return $query->row();
            }else{
                return false;
            }
    
        }
        public function update_payment($data,$id){
            $update = $this->db->update('orders', $data, array('order_id' => $id));
            return ($update) ? true : false;
        
        }
        public function invoice($id){
            $query = $this->db->select('*')
                            ->from('orders')
                            ->where('order_id',$id)
                            ->get();
            if(count($query->result()) > 0){
                return $query->row();
            }else{
                return false;
            }
        }
        public function invoice_details($id){
            $query = $this->db->select('od.price,od.qty,p.product_name')
                            ->from('order_details od')
                            ->join('products p','p.product_id = od.product_id','left')
                            ->where('od.order_id',$id)
                            ->get();
            return $query->result();
        }
    }