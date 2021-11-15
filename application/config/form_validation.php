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
);




?>