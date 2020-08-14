<?php
class Archives extends CI_Controller{

    public function __construct(){
        parent::__construct();

    }

	public function brand_archive()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Archives';
        $this->load->view('templates/header',$data);
        $this->load->view('archives/brand_archive');
        $this->load->view('templates/footer');
    }

    public function category_archive()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Archives';
        $this->load->view('templates/header',$data);
        $this->load->view('archives/category_archive');
        $this->load->view('templates/footer');
    }

    public function product_archive()
	{
        if(!$this->session->userdata('logged_in')){
            redirect('login/index');
        }
        $data['title'] = 'Archives';
        $this->load->view('templates/header',$data);
        $this->load->view('archives/product_archive');
        $this->load->view('templates/footer');
    }
}