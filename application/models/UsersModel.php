<?php
    class UsersModel extends CI_Model{
        public function __construct(){
            parent::__construct();
        }
        public function login($username,$password){
            $query = $this->db->get_where('admin', array('username'=>$username, 'password'=>$password));
			return $query->row_array();
        }

    }