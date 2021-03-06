<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('BrandsModel','b_model');
    }

	public function index()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Brands';
        $this->load->view('templates/header',$data);
        $this->load->view('brands');
        $this->load->view('templates/footer');
    }
    
    public function insert(){
        $response = array();

        $this->form_validation->set_rules('brand_name', 'Brand name', 'trim|required|callback_check_brand_exists');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'brand_name' => $this->input->post('brand_name'),
                'brand_status' => 1
            );
            $create = $this->b_model->insert_entry($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the Category information';			
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

    public function fetch(){
        $result = array('data' => array());
        $i = 1;
        $data = $this->b_model->get_entries();
        foreach ($data as $key => $value) {
            // Select
            $buttons = '';
            $buttons .= '<button type="button" class="btn btn-sm btn-info mr-1 item-edit" data='.$value['brand_id'].'><i class="fas fa-edit"></i></button>';
            $buttons .= '<button type="button" class="btn btn-sm btn-danger item-delete" data='.$value['brand_id'].'><i class="fas fa-trash-alt"></i></button>';
            $status = ($value['brand_status'] == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Not Active</span>';
            $result['data'][$key] = array(
                $i++,
                $value['brand_name'],
                $buttons
            );
        }   // /foreach
        echo json_encode($result); 
    }

    public function edit($id){
        $data = $this->b_model->single_entry($id);
        echo json_encode($data);
    }

    public function update($id){
        $brand_db = $this->b_model->single_entry($id);
        $brand_name = $this->input->post('brand_name');
        if($brand_db->brand_name != $brand_name){
            $is_unique = 'trim|required|callback_check_brand_exists';
        }else{
            $is_unique = 'trim|required';
        }
        //Updating The Data
        $response = array();
        $this->form_validation->set_rules('brand_name', 'Brand name', $is_unique);
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');
        if($this->form_validation->run() == TRUE){
            $data = array(
                'brand_name' => $this->input->post('brand_name'),
            );
            $update = $this->b_model->update_entry($data,$id);
            if($update == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updated the Category information';			
            }
            
        }
        else{
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }
    
    public function delete($id){
        if($id) {
            $delete = $this->b_model->delete_entry($id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";	
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the brand information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function check_brand_exists($brand){
        $this->form_validation->set_message('check_brand_exists', 'That brand name is taken. Please choose a different one');
        if($this->b_model->check_brand_exists($brand)){
            return true;
        } else {
            return false;
        }
    }

}
