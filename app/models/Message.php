<?php
namespace app\models; 

class Message extends \app\core\Model{

    public $message_id;
    public $sender;
    public $receiver;
    public $message;
    public $timestamp;
    public $read_status;
    public $private_status;

    public function __construct(){
        parent::__construct();
    }

    public function create(){
        $SQL = 'INSERT INTO message (message_id, sender, receiver, message, timestamp, read_status, private_status) VALUES (:message_id, :sender, :receiver, :message, :timestamp, :read_status, :private_status)';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['message_id' => $this->message_id,'sender' => $this->sender, 'receiver' => $this->receiver, 'message' => $this->message, 'timestamp' => $this->timestamp, 'read_status' => $this->read_status, 'private_status' => $this->private_status]);
    }

    //Pointless
    public function getAll(){
		$SQL = 'SELECT * FROM message';
		$STMT = self::$_connection->query($SQL);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Message');
		return $STMT->fetchAll();
	}

    public function getAllMessagesFromProfileId($profile_id){
        $SQL = 'SELECT * FROM message WHERE receiver = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    public function getPrivateMessagesFromProfileId($profile_id){
        $SQL = "SELECT * FROM message WHERE receiver = :profile_id AND private_status = 'private' ";
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }
}