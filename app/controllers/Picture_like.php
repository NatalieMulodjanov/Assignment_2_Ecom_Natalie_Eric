<?php
namespace app\controllers;

class Picture_like extends \app\core\Controller{

    public function like($picture_id){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $likes = new \app\models\Picture_like();
        $likes = $likes->getAll();
        $found = false;

        foreach ($likes as $like){
            if($like->picture_id = $picture_id){
                if($like->profile_id = $profile->profile_id){
                    $found = true;
                }
            }
        }

        if (isset($_POST['action'])){
            $message = new \app\models\Message();
            $message->sender = $profile_id;
            $message->receiver = $_POST['receiver'];
            $message->message = $_POST['message'];
            $message->timestamp = date('Y-m-d H:i:s');
            $message->read_status = 'unread';
            $message->private_status = $_POST['private_status'];
           
            $message->create();
            header('location:'.BASE.'Profile/index');
        }
    }

    public function unlike($picture_id){
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $likes = new \app\models\Picture_like();
        $likes = $likes->getAll();
        $found = false;

        foreach ($likes as $like){
            if($like->picture_id = $picture_id){
                if($like->profile_id = $profile->profile_id){
                    $found = true;
                }
            }
        }

        if($found){
            $picture_like = new \app\models\Picture_like();
            $picture_like->delete($picture_id,$profile_id);
            header('location:'.BASE.'Profile/index');
        }
	}
}