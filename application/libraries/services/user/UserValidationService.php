<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserValidationService {
    public function __construct() {
        $this->CI =& get_instance();

        $this->CI->load->library(array("form_validation"));
    }

    public function validate_user() {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $validation = $this->CI->form_validation;

        $validation->set_rules('firstName', 'firstName', 'required');
        $validation->set_rules('lastName', 'lastName', 'required');
        $validation->set_rules('username', 'username', 'required');
        $validation->set_rules('password', 'password', 'required');

        return $validation->run();
    }

    public function validate_user_id() {
        $data = json_decode(file_get_contents("php://input"));

        return isset($data->id) && $data->id != null;
    }
}