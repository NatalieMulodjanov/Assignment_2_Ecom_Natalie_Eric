<?php
namespace app\controllers;

class User extends \app\core\Controller{

	#[\app\filters\Login]
	public function index(){
		$this->view('Account/login');
	}

	public function login(){
		$this->view('Account/login');
	}

	public function register(){
		if(isset($_POST['action']) && $_POST['password'] == $_POST['password_confirm']){
			$user = new \app\models\User();
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];
			$user->insert();
			header('location:/User/login');

		}else 
			$this->view('Account/register');
	}
	
}