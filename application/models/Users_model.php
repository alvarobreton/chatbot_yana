<?php

class Users_model  extends CI_Model  {

    protected $email = '';
    protected $password = '';

    function __construct()
    {
        parent::__construct();
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function login()
    {
        $response['err']        = false;
        $response['message']    = "Incorrect username or password";
        $result = $this->db->where('email', $this->getEmail())
                    ->get('users');

        if($result->row())
        {
            $user = $result->row();
            
            $response['err'] = password_verify($this->getPassword(),$user->password);
            if($response['err'])
                $response['message'] = "Bienvenido ".$user->name.", me da gusto volverte a ver";
        }

        return $response;
    }
}

?>