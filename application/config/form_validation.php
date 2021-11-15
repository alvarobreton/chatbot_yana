<?php 
if( ! defined('BASEPATH') ) exit('No direct script access allowed');


$config = array(

	'create_post' => array(
			array( 'field'=> 'email', 'label'=>'email','rules'=>'trim|required|valid_email' ),
			array( 'field'=> 'name', 'label'=>'name','rules'=>'trim|required|min_length[2]' ),
			array( 'field'=> 'password', 'label'=>'password','rules'=> 'trim|required' )
	),

	'login_post' => array(
			array( 'field'=> 'email', 'label'=>'email','rules'=>'trim|required|valid_email' ),
			array( 'field'=> 'password', 'label'=>'password','rules'=> 'trim|required' )
	),

	'conversation_post' => array(
			array( 'field'=> 'user_case', 'label'=>'user_case','rules'=>'trim|required' ),
			array( 'field'=> 'answer', 'label'=>'answer','rules'=> 'trim' ),
			array( 'field'=> 'answer_quick_replies', 'label'=>'answer_quick_replies','rules'=> 'trim' )
	),
);




?>