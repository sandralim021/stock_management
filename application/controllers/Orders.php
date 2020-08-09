<?php
    class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('OrdersModel','o_model');
        }
        public function index(){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $data['title'] = "Orders";
            $data['products'] = $this->o_model->get_products();
            $this->load->view('templates/header',$data);
            $this->load->view('orders');
            $this->load->view('templates/footer');
        }
        public function qty_price($id){
            $data = $this->o_model->qty_price($id);
            echo json_encode($data);
        }
        public function insert(){
            //Insert Order Information
            $data = array(
                'order_date' => $this->input->post('order_date'),
                'customer_name' => $this->input->post('cus_name'),
                'sub_total' => $this->input->post('sub_total'),
                'discount' => $this->input->post('discount'),
                'net_total' => $this->input->post('net_total'),
                'paid' => $this->input->post('paid'),
                'due' => $this->input->post('due'),
                'payment_type' => $this->input->post('payment_type')
            );
            $create = $this->o_model->insert_entry($data);
            if($create != null){
                 // Insert Order Details
                $product_id = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('price');
                foreach ($product_id as $key => $item) 
                {
                    $insert_data[] = array(
                        'order_id' => $create,
                        'product_id'=> $item,
                        'price' => $product_price[$key], 
                        'qty'=> $product_qty[$key],
                    );
                    $qty = $product_qty[$key];
                    //Update QTY
                   $this->db->query("UPDATE products SET qty = qty - $qty WHERE product_id = $item");
                }
                $create2 = $this->o_model->insert_order_details($insert_data);
                if($create2 == true){
                    echo 'ok';
                }
            }
           
        }
    }