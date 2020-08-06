<?php
    class Users extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('UsersModel','u_model');
        }
        public function index(){
            if($this->session->userdata('logged_in')){
                redirect('dashboard');
            }else{
                $this->load->view('login');
            }
        }
        public function login(){
            $response = array('error' => false);
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $data = $this->u_model->login($username,$password);
            if($data){
                $full_name = $data['fname'] ." ". $data['lname'];
                $session_data = array(
                    'full_name' => $full_name,
                    'username' => $username,
                    'logged_in' => true
                );
                $this->session->set_userdata($session_data);
            }else{
                $response['error'] = true;
			    $response['message'] = 'Login Invalid. Please try again';
            }
            echo json_encode($response);
        }
        public function logout(){
            $this->session->sess_destroy();
            redirect('login/index'); 
        }
    }