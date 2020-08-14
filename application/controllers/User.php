<?php
    class User extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->load->model('UserModel','u_model');
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
                    'user_id' => $data['user_id'],
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                    'username' => $username,
                    'password' => $data['password'],
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

        public function profile(){
            $data['title'] = 'Profile';

            $this->load->view('templates/header',$data);
            $this->load->view('profile');
            $this->load->view('templates/footer');
        }

        public function update_profile($id){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $response = array();
            $this->form_validation->set_rules('fname', 'First name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');

            if($this->form_validation->run() == TRUE){
                $password = $this->input->post('password');
                if(trim($password) == ''){
                    $password = $this->session->userdata('password');
                }else{
                    $password = md5($this->input->post('password'));
                }
                $full_name = $this->input->post('fname')." ".$this->input->post('lname');
                $data = array(
                    'fname' => $this->input->post('fname'),
                    'lname' => $this->input->post('lname'),
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'password' => $password	
                );
                $update = $this->u_model->update_profile($data,$id);
                if($update){
                    //Unset Session
                    $this->session->unset_userdata('full_name');
                    $this->session->unset_userdata('fname');
                    $this->session->unset_userdata('lname');
                    $this->session->unset_userdata('email');
                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('password');
                    //Set New Session
                    $this->session->set_userdata('full_name',$full_name);
                    $this->session->set_userdata('fname',$this->input->post('fname'));
                    $this->session->set_userdata('lname',$this->input->post('lname'));
                    $this->session->set_userdata('email',$this->input->post('email'));
                    $this->session->set_userdata('username',$this->input->post('username'));
                    $this->session->set_userdata('password',$password);
                    
                    $response['success'] = true;
                    $this->session->set_flashdata('success', 'Profile successfully updated');		
                    
                }
                else{
                    $response['success'] = false;
                    $this->session->set_flashdata('success', 'Error updating profile');
                }
            }
            else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
        }

    }