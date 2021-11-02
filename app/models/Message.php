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

    public function get($message_id){
		$SQL = 'SELECT * FROM message WHERE message_id = :message_id';
		$STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['message_id' => $message_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Message');
		return $STMT->fetch();
	}

    public function updateRead_status(){
		$SQL = 'UPDATE message SET read_status = :read_status WHERE message_id = :message_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['read_status'=>$this->read_status, 'message_id' => $this->message_id]);
	}

    public function getAllMessagesFromProfileId($profile_id){
        $SQL = 'SELECT * FROM message WHERE receiver = :profile_id ORDER BY timestamp ASC';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    public function getAllMessagesSentFromProfileId($profile_id){
        $SQL = 'SELECT * FROM message WHERE sender = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    public function getPublicMessagesFromProfileId($profile_id){
        $SQL = "SELECT * FROM message WHERE receiver = :profile_id AND private_status = 'public' ";
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    public function delete($message_id){
		$SQL = 'DELETE FROM message WHERE message_id = :message_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['message_id'=>$message_id]);
	}
}