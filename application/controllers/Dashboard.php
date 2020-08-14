<?php
    class Dashboard extends CI_Controller{
        public function __construct(){
            parent::__construct();

            $this->load->model('DashboardModel','d_model');
        }
        public function index(){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $data['title'] = 'Dashboard';
            $data['total_revenue'] = $this->d_model->total_revenue();
            $data['revenue_month'] = $this->d_model->revenue_month();
            $data['order_today'] = $this->d_model->orders_today();
            $data['unpaid_customers'] = $this->d_model->unpaid_customers();
            $data['partial_customers'] = $this->d_model->partial_customers();
            $this->load->view('templates/header',$data);
            $this->load->view('dashboard');
            $this->load->view('templates/footer');
        }
        
    }