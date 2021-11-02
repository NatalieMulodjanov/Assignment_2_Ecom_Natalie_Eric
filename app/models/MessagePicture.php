<?php
namespace app\models; 

class MessagePicture extends \app\core\Model{

    public $message_id;
    public $sender;
    public $receiver;
    public $message;
    public $timestamp;
    public $read_status;
    public $private_status;
    public $picture_id;
    public $profile_id;
    public $file_name;
    public $caption;
    // public $modelType=$this->getModelType($this->message_id);

    public function __construct(){
        parent::__construct();
    }

    private function getModelType($message_id) {
        return isset($message_id) ? "message" : "picture";
    }

    public function get($profile_id){
		$SQL = 'SELECT * FROM message FULL JOIN picture ON picture.profile_id = message.receiver WHERE message.receiver = :profile_id';
		$STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\MessagePicture');
		return $STMT->fetch();
	}
}