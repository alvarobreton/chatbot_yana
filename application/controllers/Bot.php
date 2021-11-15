<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Bot extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('users_model');
        $this->load->model('conversation_model');
    }

    public function conversation_post()
    {
        $api = $this->_head_args['X-API-KEY'];

        $users = new Users_model();
        $users->setApi($api);

        $getUser = $users->getUser();

        $this->response($getUser->id, 200);


    }
}