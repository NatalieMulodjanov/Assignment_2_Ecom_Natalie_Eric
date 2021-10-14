<?php
namespace app\controllers;

class User extends \app\core\Controller{

	public function index(){
		$myUser = new \app\models\User();
		$results = $myUser->getAll();

		$this->view('User/index',$results);
	}
}