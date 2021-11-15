<?php

class Users_model  extends CI_Model  {

    protected $email = '';
    protected $password = '';
    protected $name = '';
    protected $api = '';

    private $table = '';

    function __construct()
    {
        parent::__construct();

        $this->table = 'users';
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

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setApi($api)
    {
        $this->api = $api;
    }

    public function getApi()
    {
        return $this->api;
    }

    public function login()
    {
        $response['success']        = FALSE;
        $response['message']    = "Incorrect username or password";
        $result = $this->db->where('email', $this->getEmail())
                    ->get($this->getTable());

        if($result->row())
        {
            $user = $result->row();
            
            $response['success'] = password_verify($this->getPassword(),$user->password);
            if($response['success'])
                $response['message'] = "Bienvenido ".$user->name.", me da gusto volverte a ver";
        }

        return $response;
    }

    
    public function create()
    {
        $response['success']        = false;
        $response['message']    = "Error creating user or existing email";

        $result = $this->db->where('email', $this->getEmail())
                    ->get($this->getTable());

        if(empty($result->row()))
        {
            $data = array(
                'name'      => $this->getName(),
                'email'     => $this->getEmail(),
                'password'  => password_hash($this->getPassword(), PASSWORD_DEFAULT),
            );
            $result = $this->db->insert($this->getTable(), $data);

            if($result)
            {
                $response = array(
                    'success'           =>  FALSE,
                    'affected_rows' =>  $this->db->affected_rows(),
                    'message'       =>  'Record inserted successfully',
                    'insert_id'     =>  $this->db->insert_id(),
                );
            }
        }

        return $response;
    }

    public function getUser()
    {
        $query = "SELECT * FROM {$this->getTable()} u 
        INNER JOIN `keys` k ON k.user_id = u.id
        WHERE (k.`key` = '{$this->getApi()}' OR u.email = '{$this->getEmail()}' )";
        $result = $this->db->query($query);

        return $result->row();
    }
}

?>