<?php

namespace app\controllers;

class User extends \app\core\Controller
{

	#[\app\filters\Login]
	#[\app\filters\Validate]
	public function index()
	{
		//session_destroy();
		header('location:' . BASE . 'Profile/login');
	}

	public function login()
	{
		if (isset($_POST['action'])) {
			$user = new \app\models\User();
			$user = $user->get($_POST['username']);
			if ($user != false && password_verify($_POST['password'], $user->password_hash)) {
				$_SESSION['user_id'] = $user->user_id;
				$_SESSION['username'] = $user->username;
				$_SESSION['secretkey'] = $user->two_factor_authentication_token;
				header('location:' . BASE . 'Profile/index');
			} else {
				$this->view('Account/login', 'Wrong username and password combination!');
			}
		} else
			$this->view('Account/login');
	}

	public function register()
	{
		if (isset($_POST['action']) && $_POST['password'] == $_POST['password_confirm']) {
			$user = new \app\models\User();
			if ($user->get($_POST['username']) == false) {
				$user->username = $_POST['username'];
				$user->password = $_POST['password'];
				$user->insert();
				header('location:' . BASE . 'User/login');
			}
		} else
			$this->view('Account/register');
	}

	// Use: /Default/makeQRCode/pro?data=protocol://address
	#[\app\filters\Login]
	public function makeQRCode()
	{
		$data = $_GET['data'];
		\QRcode::png($data);
	}

	#[\app\filters\Login]
	public function setup2fa()
	{
		$secretkey = "";
		if (isset($_POST['action'])) {
			$currentcode = $_POST['currentCode'];
			if (\app\core\TokenAuth6238::verify($_SESSION['secretkey'], $currentcode)) {
				//the user has verified their proper 2-factor authentication setup
				$user = new \app\models\User();
				$user->user_id = $_SESSION['user_id'];
				$user->two_factor_authentication_token = $_SESSION['secretkey'];
				$user->update2fa();
				header('location:' . BASE . 'Profile/index');
			} else {
				header('location:' . BASE . 'User/setup2fa?error=token not verified!'); //reload
			}
		} else {
			$secretkey = \app\core\TokenAuth6238::generateRandomClue();
			$_SESSION['secretkey'] = $secretkey;

			$url = \app\core\TokenAuth6238::getLocalCodeUrl($_SESSION['username'], 'localhost', $secretkey, 'Awesome App');
			$this->view('Account/twofasetup', $url);
		}
	}

	#[\app\filters\Login]
	public function validateSecretKey()
	{
		$user = new \app\models\User();
		$user = $user->get($_SESSION['username']);

		if (!isset($user->two_factor_authentication_token) || empty($user->two_factor_authentication_token)) {
			header('location:' . BASE . 'Profile/index');
		}

		if (isset($_POST['action'])) {
			$currentcode = $_POST['currentCode'];
			if (\app\core\TokenAuth6238::verify($user->two_factor_authentication_token, $currentcode)) {
				unset($_SESSION['secretkey']);
				header('location:' . BASE . 'Profile/index');
			} else {
				$this->view('Account/verifyCode', "try again");
			}
		} else {
			$this->view('Account/verifyCode');
		}
	}

	#[\app\filters\Login]
	public function logout()
	{
		session_destroy();
		header('location:' . BASE . 'User/login');
	}
}
