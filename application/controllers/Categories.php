<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CategoriesModel','c_model');
    }

	public function index()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Categories';
        $this->load->view('templates/header',$data);
        $this->load->view('categories');
        $this->load->view('templates/footer');
    }
    
    public function insert(){
        $response = array();

        $this->form_validation->set_rules('category_name', 'Category name', 'trim|required|is_unique[categories.category_name]');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'category_name' => $this->input->post('category_name'),
                'cat_status' => $this->input->post('cat_status')
            );
            $create = $this->c_model->insert_entry($data);
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
        $data = $this->c_model->get_entries();
        foreach ($data as $key => $value) {
            // button
            $buttons = '';
            $buttons .= '<button class="btn btn-sm btn-outline-info item-edit" data='.$value['category_id'].'><i class="fas fa-edit"></i></button>';
            $buttons .= '<button class="btn btn-sm btn-outline-danger item-delete" data='.$value['category_id'].'><i class="fas fa-trash-alt"></i></button>';
            $status = ($value['cat_status'] == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Not Active</span>';
            $result['data'][$key] = array(
                $value['category_name'],
                $status,
                $buttons
            );
        }   // /foreach
        echo json_encode($result); 
    }

    public function edit($id){
        $data = $this->c_model->single_entry($id);
        echo json_encode($data);
    }

    public function update($id){
        $category_db = $this->c_model->single_entry($id);
        $category_name = $this->input->post('category_name');
        if($category_db->category_name != $category_name){
            $is_unique = 'trim|required|is_unique[categories.category_name]';
        }else{
            $is_unique = 'trim|required';
        }
        //Updating The Data
        $response = array();
        $this->form_validation->set_rules('category_name', 'Category name', $is_unique);
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');
        if($this->form_validation->run() == TRUE){
            $data = array(
                'category_id' => $this->input->post('category_id'),
                'category_name' => $this->input->post('category_name'),
                'cat_status' => $this->input->post('cat_status')
            );
            $update = $this->c_model->update_entry($data);
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
            $delete = $this->c_model->delete_entry($id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";	
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the category information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

}
