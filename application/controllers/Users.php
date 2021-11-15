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


    /**
     * @author: hola@alvarobreton.com
     * Endpoint: http://localhost/chatbot_yana/users/login
     * Headers: X-API-KEY = It is obtained from the database [Table: keys]
     * Body form-data: email, password
     * Status documentation: https://restfulapi.net/http-status-codes/
     */
    public function login_post()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        $status     = 401;

        $users = new Users_model();

        $users->setEmail($email);
        $users->setPassword($password);

        $response = $users->login();
        if($response['err'])
            $status = 200;
		$this->response($response, $status);
    }
}