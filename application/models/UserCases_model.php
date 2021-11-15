<?php

class UserCases_model  extends CI_Model  {

    protected $case_id, $user_id, $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'user_cases';
    }

    public function setCaseId($case_id)
    {
        $this->case_id = $case_id;
    }

    public function getCaseId()
    {
        return $this->case_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getUserCases()
    {
        $query = "	SELECT c.`*`, u.email, u.name FROM {$this->getTable()} uc
                    INNER JOIN cases c ON c.id = uc.case_id
                    INNER JOIN users u ON u.id = uc.user_id
                    WHERE uc.user_id = {$this->getUserId()} ";

        $result = $this->db->query($query)->row();

        return $result;
    }

}
