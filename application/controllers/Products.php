<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('ProductsModel','p_model');
    }

	public function index(){
        $data['title'] = "Products";
        $data['brands'] = $this->p_model->get_brands();
        $data['categories'] = $this->p_model->get_categories();
        $this->load->view('templates/header',$data);
        $this->load->view('products');
        $this->load->view('templates/footer');
    }

    public function fetch(){
        $result = array('data' => array());
        $data = $this->p_model->get_entries();
        foreach ($data as $key => $value) {
            // button
            $buttons = '';
            $buttons .= '<button class="btn btn-sm btn-outline-info item-edit" data='.$value['product_id'].'><i class="fas fa-edit"></i></button>';
            $buttons .= '<button class="btn btn-sm btn-outline-danger item-delete" data='.$value['product_id'].'><i class="fas fa-trash-alt"></i></button>';
            $status = ($value['prod_status'] == '1') ? '<span class="badge badge-success">Available</span>' : '<span class="badge badge-warning">Not Available</span>';
            $qty_status = '';
            if($value['qty'] < $value['alert_qty']){
                $qty_status = '<span class="badge badge-warning">Critical stock !</span>';
            }else if($value['qty'] == 0){
                $qty_status = '<span class="badge badge-danger">Out of stock !</span>';
            }
            // Displaying Data
            $result['data'][$key] = array(
                $value['brand_name'],
                $value['category_name'],
                $value['product_name'],
                $value['qty'].' '.$qty_status,
                $value['alert_qty'],
                "₱ ".number_format($value['price'], 2),
                $status,
                $buttons
            );
        }   // /foreach
        echo json_encode($result); 
    }

    
    public function insert(){
        $response = array();

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'brand_id' => $this->input->post('brand_id'),
                'category_id' => $this->input->post('category_id'),
                'product_name' => $this->input->post('product_name'),
                'qty' => $this->input->post('qty'),
                'alert_qty' => $this->input->post('alert_qty'),
                'price' => $this->input->post('price'),
                'prod_status' => $this->input->post('prod_status')
            );
            $create = $this->p_model->insert_entry($data);
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

    public function edit($id){
        $data = $this->p_model->single_entry($id);
        echo json_encode($data);
    }

    public function update($id){
        $response = array();

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">','</div>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'product_id' => $this->input->post('product_id'),
                'brand_id' => $this->input->post('brand_id'),
                'category_id' => $this->input->post('category_id'),
                'product_name' => $this->input->post('product_name'),
                'qty' => $this->input->post('qty'),
                'alert_qty' => $this->input->post('alert_qty'),
                'price' => $this->input->post('price'),
                'prod_status' => $this->input->post('prod_status')
            );
            $update = $this->p_model->update_entry($data);
            if($update == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully Updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updating the Product information';			
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
    public function delete($id){
        if($id) {
            $delete = $this->p_model->delete_entry($id);
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
