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
     * @method: POST
     * Endpoint: http://localhost/chatbot_yana/users/login
     * Headers: X-API-KEY = It is obtained from the database [Table: keys]
     * Body form-data: email, password
     * Status documentation: https://restfulapi.net/http-status-codes/
     * 
     * Desarrolla un endpoint que reciba las credenciales de un usuario y 
     * que valide contra la tabla de usuarios si las credenciales son válidas 
     * para el inicio de sesión, de no ser el caso devolver el error adecuado al caso.
     */
    public function login_post()
    {
        if ($this->form_validation->run('login_post')) 
        {
            $email      = $this->input->post('email');
            $password   = $this->input->post('password');
            $status     = 401;

            $users = new Users_model();

            $users->setEmail($email);
            $users->setPassword($password);
    
            $response = $users->login();
            if($response['success'])
                $status = 200;
        }
        else
        {
            $response['success'] = FALSE;
            $status = 400;
            $response['errors'] = $this->form_validation->get_errores_arreglo();
        }

		$this->response($response, $status);
    }
    /**
     * @author: hola@alvarobreton.com
     * @method: POST
     * Endpoint: http://localhost/chatbot_yana/users/create
     * Headers: X-API-KEY = It is obtained from the database [Table: keys]
     * Body form-data: name, email, password
     * Status documentation: https://restfulapi.net/http-status-codes/
     * 
     * Desarrolla un endpoint que cree una cuenta nueva de un usuario recibiendo 
     * los campos necesarios para su creación.
     */
    public function create_post()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        $name       = $this->input->post('name');
        
        if ($this->form_validation->run('create_post')) 
        {
            $status     = 401;

            $users = new Users_model();

            $users->setName($name);
            $users->setEmail($email);
            $users->setPassword($password);

            $response = $users->create();

            if($response['success'])
                $status = 200;
        }
        else
        {
            $response['success'] = FALSE;
            $status = 400;
            $response['errors'] = $this->form_validation->get_errores_arreglo();
        }

        $this->response($response, $status);
    }
}