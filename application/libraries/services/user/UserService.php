<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserService {

    public function __construct(){
        $this->CI =& get_instance();

        $this->CI->load->model(array("api/UserModel"));
        $this->CI->load->library('encrypt');
    }

    public function insert($user = array()) {
        $userModel = array(
            "first_name" => $user->firstName,
            "last_name" => $user->lastName,
            "username" => $user->username,
            "password" => $this->CI->encrypt->encode($user->password),
        );

        return $this->CI->UserModel->insert_user($userModel);
    }

    public function read_detail($id) {
        return $this->CI->UserModel->get_user($id);
    }

    public function read_list() {
        return $this->CI->UserModel->get_users();
    }

    public function update($userInformation) {
        $userModel = array();
        $id = $userInformation->id;
        
        if(isset($userInformation->firstName)) {
            $userModel["first_name"] = $userInformation->firstName;
        }

        if(isset($userInformation->lastName)) {
            $userModel["last_name"] = $userInformation->lastName;
        }

        if(isset($userInformation->username)) {
            $userModel["username"] = $userInformation->username;
        }

        return $this->CI->UserModel->update_user($id, $userModel);
    }

    public function delete($id) {
        return $this->CI->UserModel->delete_user($id);
    }
}