<?php
namespace app\controllers;

class Profile extends \app\core\Controller{
    //is called when loggs in and doesnt have a profile 
    #[\app\filters\Login]
    #[\app\filters\Validate]
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
    #[\app\filters\Validate]
    public function index(){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $message =  new \app\models\Message();
        $pictures = new \app\models\Picture();
        
        // $posts = new \app\models\MessagePicture();
        // echo $profile->profile_id;
        // var_dump($posts->get($profile->profile_id));
        $messages = $message->getAllMessagesFromProfileId($profile->profile_id);
        $pictures = $pictures->getByProfileId($profile->profile_id);
        
        if ($profile == false){
            header('location:'.BASE.'Profile/create');
        } else {
            $this->view('Profile/wall',['profile'=>$profile, 'messages'=>$messages, 'pictures'=>$pictures]);
        }

    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function goToProfile(){
        $user_id = $_SESSION['user_id'];
        $message =  new \app\models\Message();

        if(isset($_POST['action'])){
            $profile_id = $_POST['profile_id'];
            $profile = new \app\models\Profile();
            $profile = $profile->get($profile_id);

            if($user_id == $profile->user_id){
                $messages = $message->getAllMessagesFromProfileId($profile->profile_id);
                $this->view('Profile/wall',['profile'=>$profile, 'messages'=>$messages]);
            } else{
                $messages = $message->getPublicMessagesFromProfileId($profile->profile_id);
                $this->view('Profile/wall',['profile'=>$profile, 'messages'=>$messages]);
            }
		}else
			$this->view('Profile/goToProfile');

        
    }


    #[\app\filters\Login]
    public function update($profile_id){
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        
        if(isset($_POST['action'])){
            if($_POST['first_name'] != ''){
                $profile->setFirst_name($_POST['first_name']);
            }
            if($_POST['middle_name'] != ''){
                $profile->setMiddle_name($_POST['middle_name']);
            }
            if($_POST['last_name'] != ''){
                $profile->setLast_name($_POST['last_name']);
            }
			$profile->update();
			header('location:'.BASE.'Profile/index');
		}else
			$this->view('Profile/update',$profile);
    }

    #[\app\filters\Login]
    public function read(){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        
    }
}