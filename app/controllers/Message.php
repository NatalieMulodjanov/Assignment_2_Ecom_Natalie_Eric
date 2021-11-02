<?php
namespace app\controllers;

class Message extends \app\core\Controller{

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function create(){
        if (isset($_POST['action'])){
            $message = new \app\models\Message();
            $profile = new \app\models\Profile();
            $profile = $profile->getByUserId($_SESSION['user_id']);
            $message->sender = $profile->profile_id;
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

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function sent(){
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($_SESSION['user_id']);
        $message = new \app\models\Message();
        $messages = $message->getAllMessagesSentFromProfileId($profile->profile_id);

        $this->view('Message/sent',$messages);
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function read($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $message->read_status = 'read';
        $message->updateRead_status();
        header('location:'.BASE.'Profile/index');
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function to_reread($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $message->read_status = 'to_reread';
        $message->updateRead_status();
        header('location:'.BASE.'Profile/index');
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function delete($message_id){
		$message = new \app\models\Message;
		$message->delete($message_id);
		header('location:'.BASE.'Profile/index');
	}
}