<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('users_model');
    }

    public function login_post()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $users = new Users_model();

        $users->setEmail($email);
        $users->setPassword($password);

        $result = $users->login();

        $response = array(
			'err'			=>	$result['err']
		);
		$this->response($response, 200);
    }
}