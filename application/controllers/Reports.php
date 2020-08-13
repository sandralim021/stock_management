<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('ReportsModel','r_model');
    }

	public function index()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Reports';
        $this->load->view('templates/header',$data);
        $this->load->view('reports/reports');
        $this->load->view('templates/footer');
    }
    public function fetch(){
        $startDate = $this->input->post('start_date');
        $start_date = DateTime::createFromFormat('m/d/Y',$startDate)->format("Y-m-d");
    
        $endDate = $this->input->post('end_date');
        $end_date = DateTime::createFromFormat('m/d/Y',$endDate)->format("Y-m-d");

        $form_data = array(
            'start_date' => $start_date,
            'end_date' => $end_date
        );
        $data['report_data'] = $this->r_model->fetch($form_data);
        $data['form_data'] = $form_data;
        $this->load->view('reports/print_reports',$data);
        
    }
    
}