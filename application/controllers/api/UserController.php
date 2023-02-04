<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class UserController extends REST_Controller{

    public function __construct() {
        parent::__construct();
        
        $this->load->library("services/user/userservice");
        $this->load->library("services/user/uservalidationservice");
        $this->load->library("utils/ci_utils");
    }

    public function index_post() {
        // $_POST = json_decode(file_get_contents("php://input"), true);

        // print_r($this->uservalidationservice->xss_clean());

        if(!$this->uservalidationservice->validate_user()){

            $this->response(array(
                "status" => REST_Controller::HTTP_BAD_REQUEST,
                "message" => "All fields are needed"
              ) , REST_Controller::HTTP_BAD_REQUEST);

        } else {

                $user = $this->ci_utils->xss_clean();

                if($this->userservice->insert($user)) {
                    $this->response(array(
                        "status" => REST_Controller::HTTP_OK,
                        "message" => "New user created successfully."
                    ) , REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        "status" => REST_Controller::HTTP_OK,
                        "message" => "Failed to create user."
                    ) , REST_Controller::HTTP_OK);
                }

        }
    }

    public function index_get() {
        //READ
        $id = $this->get('id');

        if($id != null) {
            //READ DETAIL
            $user = $this->userservice->read_detail($id);

            if($user == null) {

                $this->response(array(
                    "status" => REST_Controller::HTTP_NOT_FOUND,
                    "message" => "User not found."
                  ) , REST_Controller::HTTP_NOT_FOUND);

            } else {

                $this->response(array(
                    "status" => REST_Controller::HTTP_OK,
                    "message" => "User found.",
                    "data" => $user
                  ) , REST_Controller::HTTP_OK);

            }
        }

        //READ LIST
        $users = $this->userservice->read_list();
        $userCount = count($users);

        if($userCount > 0) {

            $this->response(array(
                "status" => REST_Controller::HTTP_OK,
                "message" => "Users found.",
                "totalCount" => $userCount,
                "data" => $users
              ) , REST_Controller::HTTP_OK);

        } else {

            $this->response(array(
                "status" => REST_Controller::HTTP_NOT_FOUND,
                "message" => "Users not found.",
                "data" => $users
              ) , REST_Controller::HTTP_NOT_FOUND);

        }
    }

    public function index_put() {
        //UPDATE

        if(!$this->uservalidationservice->validate_user_id()){

            $this->response(array(
                "status" => REST_Controller::HTTP_BAD_REQUEST,
                "message" => "ID is required!"
              ) , REST_Controller::HTTP_BAD_REQUEST);

        } else {

            $userInformation = $this->ci_utils->xss_clean();

            // print_r($userInformation);

            if($this->userservice->update($userInformation)) {
                $this->response(array(
                    "status" => REST_Controller::HTTP_OK,
                    "message" => "User information updated successfully."
                  ) , REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => REST_Controller::HTTP_OK,
                    "message" => "Failed to update user information."
                ) , REST_Controller::HTTP_OK);
            }
        }
    }

    public function index_delete() {
        $id = $this->uri->segment(3);
        print_r($id);
        if($this->userservice->delete($id)) {
            $this->response(array(
                "status" => REST_Controller::HTTP_OK,
                "message" => "User deleted successfully."
              ) , REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "status" => REST_Controller::HTTP_OK,
                "message" => "Failed to delete user."
            ) , REST_Controller::HTTP_OK);
        }
    }
}

?>