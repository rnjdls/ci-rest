<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Utils {
    public function __construct() {
        $this->CI =& get_instance();

        $this->CI->load->helper("security");
    }

    public function xss_clean() {
        $data = json_decode(file_get_contents("php://input"), true);

        $objArr = array();
        foreach($data as $key => $val) {
            $objArr[$key] = $this->CI->security->xss_clean($val);
        }

        return (object) $objArr;
    }
}