<?php

class Conversation_model  extends CI_Model  {

    protected $user_case_id, $questionsbot_id, $quickreplies_id, $user_response, $table, $order;

    function __construct()
    {
        parent::__construct();
        $this->table = 'conversations';
    }

    public function setUserCaseId($user_case_id)
    {
        $this->user_case_id = $user_case_id;
    }

    public function getUserCaseId()
    {
        return $this->user_case_id;
    }

    public function setQuestionsBotId($questionsbot_id)
    {
        $this->questionsbot_id = $questionsbot_id;
    }

    public function getQuestionsBotId()
    {
        return $this->questionsbot_id;
    }

    public function setQuickRepliesId($quickreplies_id)
    {
        $this->quickreplies_id = $quickreplies_id;
    }

    public function getQuickRepliesId()
    {
        return $this->quickreplies_id;
    }

    public function setUserResponse($user_response)
    {
        $this->user_response = $user_response;
    }

    public function getUserResponse()
    {
        return $this->user_response;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getConversation()
    {
        $query = "SELECT cv.`*` , qb.quick_result_id, qb.question_awswers, qb.`order`, qr.answeres FROM conversations cv
            INNER JOIN user_cases uc ON uc.id = cv.user_case_id
            LEFT JOIN questions_bot qb ON qb.id = cv.questionsbot_id
            LEFT JOIN quick_replies qr ON qr.id = cv.quickreplies_id
            WHERE cv.user_case_id = {$this->getUserCaseId()} ORDER BY cv.id;";

        $result = $this->db->query($query)->result();

        $response['user_case'] = $this->getUserCaseId();
        $response['conversations'] = array();
        foreach ($result as $key => $row) 
        {
            $key++;
            if($row->questionsbot_id)
            {
                $response['conversations'][$key]['bot_answer_id'] = $row->questionsbot_id;
            }

            $response['conversations'][$key]['bot_answer'] = (empty($row->question_awswers)) ? $row->user_response : $row->question_awswers;
            
            if($row->quickreplies_id)
            {
                $response['conversations'][$key]['bot_answer'] = $row->answeres;
            }
            
            $response['conversations'][$key]['type_user'] = 'Yana';
            if(empty($row->questionsbot_id))
            {
                $response['conversations'][$key]['type_user'] = 'user';
            }
            if($row->questionsbot_id)
            {
                $query = "SELECT id, answeres FROM quick_replies WHERE questions_bot_id = {$row->questionsbot_id}";
                $quick_replies = $this->db->query($query)->result();
                $response['conversations'][$key]['quick_replies'] = array();
                $response['conversations'][$key]['type_answer'] = 'user_input';
                if(!empty($quick_replies))
                {
                    foreach ($quick_replies as $keyqr => $rowqr) 
                    {
                        $response['conversations'][$key]['quick_replies'][$rowqr->id] = $rowqr->answeres;
                    }
                    $response['conversations'][$key]['type_answer'] = 'quick_replies';
                }
            }
            

        }

        return $response;
    }

    public function createConversationBot()
    {
        $response['success']        = FALSE;
        $response['message']        = "Communication error";

        $query = "SELECT * FROM questions_bot 
                    WHERE case_id = {$this->getUserCaseId()} AND `status` = 1 AND `order` = {$this->getOrder()} ";

        if($this->getQuickRepliesId())
        {
            $query .= "AND quick_result_id  = {$this->getQuickRepliesId()} ";
        }
        $getConversation = $this->db->query($query)->row();

        $data = array(
            'user_case_id'      => $this->getUserCaseId(),
            'questionsbot_id'     => $getConversation->id,
        );
        
        $result = $this->db->insert($this->getTable(), $data);

        if($result)
        {
            $response = array(
                'success'           =>  TRUE,
                'affected_rows' =>  $this->db->affected_rows(),
                'message'       =>  'Record inserted successfully',
                'insert_id'     =>  $this->db->insert_id(),
            );
        }

        return $response;
    }

    public function createConversation()
    {
        if(is_numeric( $this->getUserResponse() ))
        {
            $data = array(
                'user_case_id'      => $this->getUserCaseId(),
                'quickreplies_id'     => $this->getUserResponse(),
            );
        }
        else
        {
            $data = array(
                'user_case_id'      => $this->getUserCaseId(),
                'user_response'     => $this->getUserResponse(),
            );
        }
        return $result = $this->db->insert($this->getTable(), $data);

    }

    public function checkAnswer()
    {
        //verificar la dos ultimas respuesta
        $query = "SELECT 
            c.questionsbot_id, c.quickreplies_id, qb.`order`
            FROM conversations c
            LEFT JOIN questions_bot qb ON qb.id = c.questionsbot_id 
            WHERE c.user_case_id = {$this->getUserCaseId()}
            AND (c.questionsbot_id > 0  OR c.quickreplies_id > 0)
            ORDER BY c.id DESC LIMIT 1";

        $getConversation = $this->db->query($query)->row();
        $order = $getConversation->order;

        if($getConversation->quickreplies_id)
        {
            $query = "SELECT qb.`order` FROM quick_replies qr
                        INNER JOIN questions_bot qb ON qb.id = qr.questions_bot_id
                        WHERE qr.id = {$getConversation->quickreplies_id} ";
            $order  = $this->db->query($query)->row()->order;
        }

        $result = array(
            'order'             => $order+1,
            'quickreplies_id'   => $getConversation->quickreplies_id,
        );
        return $result;
    }
}
