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
        public function get_qty($id){
            $data = $this->o_model->get_qty($id);
            echo json_encode($data);
        }
        public function insert(){
            $product_id = $this->input->post('product_name');
            $product_qty = $this->input->post('product_qty');
            foreach ($product_id as $key => $item) 
            {
                $insert_data[] = array(
                    'product_id'=> $item,
                    'qty'=> $product_qty[$key]
                );
            }
            $create = $this->o_model->insert_entry($insert_data);
            if($create == true){
                echo 'ok';
            }
        }
    }