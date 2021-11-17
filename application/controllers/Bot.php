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
        $this->load->model('usercases_model');
    }

    /**
     * @author: hola@alvarobreton.com
     * @method: POST
     * Endpoint: http://localhost/chatbot_yana/bot/conversation
     * Headers: X-API-KEY = It is obtained from the database [Table: keys]
     * Body form-data: user_case, response
     * Status documentation: https://restfulapi.net/http-status-codes/
     * 
     * Desarrolla un endpoint que maneje la lógica conversacional entre el usuario y la máquina.
     */
    public function conversation_post()
    {
        $api = $this->_head_args['X-API-KEY'];
        $response['success'] = FALSE;

        if ($this->form_validation->run('conversation_post')) 
        {
            $user_case      = $this->input->post('user_case');
            $user_response  = $this->input->post('response');
            $users = new Users_model();
            $users->setApi($api);

            $getUser = $users->getUser();

            if($getUser->id)
            {
                $userCases = new UserCases_model();
                $userCases->setUserId($getUser->id);
                $userCases->setCaseId($user_case);
                $userCase = $userCases->getUserCases();

                if(empty($userCase))
                {
                    $response['message'] = 'There is no registered case';
                    $status = 406;
                }
                else
                {
                    #conversation
                    $status = 200;
                    $conversation = new Conversation_model();
                    $conversation->setUserCaseId($user_case);
                    $result = $conversation->getConversation();

                    if(empty($result['conversations']))
                    {
                        $conversation->setOrder(1);
                        $response = $conversation->createConversationBot();


                        // get conversation
                        $response = $conversation->getConversation();
                    }
                    else 
                    {
                        if(!empty($user_response))
                        {
                            $conversation->setUserResponse($user_response);
                            $conversation->createConversation();
                            $response = $conversation->checkAnswer();
                            $conversation->setOrder($response['order']);
                            $conversation->setQuickRepliesId($response['quickreplies_id']);
                            $conversation->createConversationBot();
                        }

                        
                        
                        // get conversation
                        $response = $conversation->getConversation();
                    }

                }
            }
            else
            {
                $status = 401;
                $response['message'] = 'User not found';
            }
        }
        else
        {
            $status = 400;
            $response['errors'] = $this->form_validation->get_errores_arreglo();
        }

        $this->response($response, $status);


    }
}