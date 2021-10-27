<?php
namespace app\controllers;

class User extends \app\core\Controller{

	#[\app\filters\Login]
	public function index(){
		$this->view('Account/login');
	}

	public function login(){
		if(isset($_POST['action'])){
			$user = new \app\models\User();
			$user = $user->get($_POST['username']);

			if($user!=false && password_verify($_POST['password'], $user->password_hash)){
				$_SESSION['user_id'] = $user->user_id;
				$_SESSION['username'] = $user->username;
				echo 'go to wall';
			}else{
				$this->view('Account/login','Wrong username and password combination!');
			}

		}else
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