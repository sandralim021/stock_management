<?php
    class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
        }
        public function index(){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $data['title'] = "Orders";
            $this->load->view('templates/header',$data);
            $this->load->view('orders');
            $this->load->view('templates/footer');
        }
    }