<?php
namespace app\models;


class Picture_like extends \app\core\Model{

	public $picture_id;
	public $profile_id;
	public $timestamp;
	public $read_status;

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$SQL = 'SELECT * FROM picture_like';
		$STMT = self::$_connection->query($SQL);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Picture_like');
		return $STMT->fetchAll();
	}

	public function create(){
        $SQL = 'INSERT INTO message (picture_id, profile_id, timestamp, read_status) VALUES (:picture_id, :profile_id, :timestamp, :read_status)';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $this->picture_id,'profile_id' => $this->profile_id, 'timestamp' => $this->timestamp, 'read_status' => $this->read_status]);
    }

	public function delete($picture_id,$profile_id){
		$SQL = 'DELETE FROM picture_like WHERE picture_id = :picture_id AND profile_id = :profile_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['picture_id'=>$picture_id]);
	}
}