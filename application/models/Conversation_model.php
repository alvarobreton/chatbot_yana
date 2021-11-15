<?php

class Conversation_model  extends CI_Model  {

    protected $user_case_id, $questionsbot_id, $quickreplies_id, $user_response, $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'conversations';
    }

    public function getConversation()
    {
        $response['success']        = FALSE;
        $response['message']    = "Incorrect username or password";
        $result = $this->db->where('email', $this->getEmail())
                    ->get($this->getTable());
    }

}
