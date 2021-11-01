<?php
namespace app\controllers;

class Message extends \app\core\Controller{

    #[\app\filters\Login]
    #[\app\filters\Validate]
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

    public function read($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $message->read_status = 'read';
        $message->updateRead_status();
        header('location:'.BASE.'Profile/index');
    }

    public function to_reread($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $message->read_status = 'to_reread';
        $message->updateRead_status();
        header('location:'.BASE.'Profile/index');
    }

    public function delete($message_id){
		$message = new \app\models\Message;
		$message->delete($message_id);
		header('location:'.BASE.'Profile/index');
	}
}