<?php
    class ReportsModel extends CI_Model{
        
        public function fetch($form_data){
            $query = $this->db->select('*')
                            ->from('orders')
                            ->where('order_date >=',$form_data['start_date'])
                            ->where('order_date <=',$form_data['end_date'])
                            ->get();
                            
            return $query->result();
        }
    }