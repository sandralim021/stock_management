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
        public function insert(){
            for($count = 0; $count < count(array($this->input->post('product_name'))); $count++){
                $data = array(
                    'product_id' => $this->input->post('product_name')[$count],
                    'qty' => $this->input->post('product_qty')[$count]
                );
            }
            $create = $this->o_model->insert_entry($data);
            if($create == true){
                echo 'ok';
            }
        }
    }