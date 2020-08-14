<?php
    class DashboardModel extends CI_Model{
        
        public function total_revenue(){
            $query = $this->db->select_sum('net_total')
                            ->from('orders')
                            ->get();
            
            return $query->row()->net_total;
        }
        public function revenue_month(){
            $query = $this->db->select_sum('net_total')
                            ->from('orders')
                            ->where('MONTH(order_date)',date('m'))
                            ->get();
            
            return $query->row()->net_total;
        }
        public function orders_today(){
            $date =  new DateTime('now');
            $current_date = $date->format('Y-m-d');
            $query = $this->db->select('*')
                            ->from('orders')
                            ->where('order_date',$current_date)
                            ->get();

            return $query->num_rows();

        }
        public function unpaid_customers(){
            $query = $this->db->select('*')
                            ->from('orders')
                            ->where('paid',0)
                            ->get();
            
            return $query->num_rows();
        }

        public function partial_customers(){
            $query = $this->db->select('*')
                            ->from('orders')
                            ->where('paid < net_total')
                            ->where('paid > 0')
                            ->get();
            
            return $query->num_rows();
        }
    }