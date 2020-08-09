<?php
    class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('OrdersModel','o_model');
        }
        public function add_order(){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $data['title'] = "Add Order";
            $data['products'] = $this->o_model->get_products();
            $this->load->view('templates/header',$data);
            $this->load->view('orders/add_order');
            $this->load->view('templates/footer');
        }
        public function manage_orders(){
            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
            $data['title'] = "Manage Orders";
            $this->load->view('templates/header',$data);
            $this->load->view('orders/manage_orders');
            $this->load->view('templates/footer');
        }
        public function fetch_orders(){
            $result = array('data' => array());
            $data = $this->o_model->fetch_orders();
            foreach ($data as $key => $value) {
                // button
                $select = '';
                $select .= '<div class="dropdown">';
                $select .= '<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</button>';
                $select .= '<div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">';
                $select .= '<a class="dropdown-item" href="#">Action</a>';
                $select .= '<a class="dropdown-item" href="#">Another action</a>';
                $select .= '<a class="dropdown-item" href="#">Something else here</a>';
                $select .= '</div></div>';
                $payment_type = '<span class="badge badge-info">'.$value['payment_type'].'</span>';
                if($value['paid'] == $value['net_total']){
                    $payment_status ='<span class="badge badge-success">Full Payment</span>';
                }else if($value['paid'] < $value['net_total']){
                    $payment_status ='<span class="badge badge-warning">Partial Payment</span>';
                }else if($value['paid'] == 0){
                    $payment_status ='<span class="badge badge-danger">No Payment</span>';
                }
                $result['data'][$key] = array(
                    $value['customer_name'],
                    $value['customer_contact'],
                    $value['order_date'],
                    "₱ ".number_format($value['net_total']),
                    $payment_type,
                    $payment_status,
                    $select
                );
            }   // /foreach
            echo json_encode($result); 
        }
        public function qty_price($id){
            $data = $this->o_model->qty_price($id);
            echo json_encode($data);
        }
        public function insert_order(){
            //Insert Order Information
            $data = array(
                'order_date' => $this->input->post('order_date'),
                'customer_name' => $this->input->post('cus_name'),
                'customer_contact' => $this->input->post('cus_contact'),
                'sub_total' => $this->input->post('sub_total'),
                'discount' => $this->input->post('discount'),
                'net_total' => $this->input->post('net_total'),
                'paid' => $this->input->post('paid'),
                'due' => $this->input->post('due'),
                'payment_type' => $this->input->post('payment_type')
            );
            $create = $this->o_model->insert_entry($data);
            if($create != null){
                 // Insert Order Details
                $product_id = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('price');
                foreach ($product_id as $key => $item) 
                {
                    $insert_data[] = array(
                        'order_id' => $create,
                        'product_id'=> $item,
                        'price' => $product_price[$key], 
                        'qty'=> $product_qty[$key],
                    );
                    $qty = $product_qty[$key];
                    //Update QTY
                   $this->db->query("UPDATE products SET qty = qty - $qty WHERE product_id = $item");
                }
                $create2 = $this->o_model->insert_order_details($insert_data);
                if($create2 == true){
                    echo 'ok';
                }
            }
           
        }
    }