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

    public function getAll(){
		$SQL = 'SELECT * FROM message';
		$STMT = self::$_connection->query($SQL);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Message');
		return $STMT->fetchAll();
	}

    public function getAllMessagesFromProfileId($profile_id){
        $SQL = 'SELECT * FROM message WHERE profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    public function getPublicMessagesFromProfileId($profile_id){
        $SQL = "SELECT * FROM messges WHERE profile_id = :profile_id AND private_status = 'public' ";
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Message');
        return $STMT->fetchAll();
    }

    // public function getAllFromReceiver($allMessages,$profile_id){
    //     $results = new Message();
    //     foreach($allMessages as $message){
    //         if($message->receiver == $profile_id){
    //             $results = $message;
    //         }
    //     }
    //     return $results;
	// }
    
    // public function create(){
    //     $SQL = 'INSERT INTO profile (user_id, first_name, middle_name, last_name) VALUES (:user_id, :first_name, :middle_name, :last_name)';
    //     $STMT = self::$_connection->prepare($SQL);
    //     $STMT->execute(['user_id' => $this->user_id, 'first_name' => $this->first_name, 'middle_name' => $this->middle_name, 'last_name' => $this->last_name]);
    // }
}