<?php
namespace app\controllers;

class Profile extends \app\core\Controller{
    //is called when loggs in and doesnt have a profile 
    #[\app\filters\Login]
    public function create(){
        if (isset($_POST['action'])){
            $profile = new \app\models\Profile();
            $profile->user_id =  $_SESSION['user_id'];
            $profile->first_name = $_POST['first_name'];
            $profile->middle_name = $_POST['middle_name'];
            $profile->last_name = $_POST['last_name'];
           
            $profile->create();
            header('location:'.BASE.'Profile/index');
        }else {
            $this->view('Profile/create');
        }

    }

	#[\app\filters\Login]
    public function index(){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->get($user_id);
        $allMessages = new \app\models\Message();
        $allMessages = $allMessages->getAll();
        $messages = new \app\models\Message();
        $messages = $messages->getAllFromReceiver($allMessages, $profile->profile_id);
        
        if ($profile == false){
            header('location:'.BASE.'Profile/create');
        } else {
            $this->view('Profile/wall', $profile, $messages);
        }

    }

    #[\app\filters\Login]
    public function update(){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->get($user_id);
        
        if(isset($_POST['action'])){
			$profile->setFirst_name($_POST['first_name']);
			$profile->setMiddle_name($_POST['middle_name']);
            $profile->setLast_name($_POST['last_name']);
			$profile->update();
			header('location:'.BASE.'Profile/wall');
		}else
			$this->view('Profile/update',$profile);
    }

    public function read(){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->get($user_id);
        
    }
}