<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function insert_user($data = array()){
    return $this->db->insert("users", $data);
}


  public function get_users(){
    $this->db->select("*");
    $this->db->from("users");
    $query = $this->db->get();

    return $query->result();
  }

  public function get_user($id) {
    $this->db->select("*");
    $this->db->from("users");
    $this->db->where(['id' => $id]);
    $query = $this->db->get();

    return $query->result();
  }

  public function update_user($id, $userInformation) {
    $this->db->where("id", $id);

    return $this->db->update("users", $userInformation);
  }

  public function delete_user($id){
     $this->db->where("id", $id);
     return $this->db->delete("users");
   }
}

 ?>
