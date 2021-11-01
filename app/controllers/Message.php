<?php
namespace app\controllers;

class Message extends \app\core\Controller{

    #[\app\filters\Login]
    public function create($profile_id){
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
        }else {
            $this->view('Message/create');
        }

    }
}