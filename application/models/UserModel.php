<?php
    class UserModel extends CI_Model{

        public function __construct(){
            parent::__construct();
        }

        public function login($username,$password){
            $query = $this->db->get_where('users', array('username'=>$username, 'password'=>$password));
			return $query->row_array();
        }

        public function update_profile($data,$id){
            if($data && $id) {
                $this->db->where('user_id', $id);
                $update = $this->db->update('users', $data);
                return ($update == true) ? true : false;
            }
        }

    }