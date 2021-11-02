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

	public function getAllUnseenNotifications($profile_id) {
		$SQL = 'SELECT * FROM picture_like WHERE profile_id = :profile_id AND read_status = :read_status';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['profile_id' => $profile_id, 'read_status' => 'Unseen']);
		$STMT->setFetchMode(\PDO::FETCH_CLASS, '\\app\\models\\Picture');
		return $STMT->fetchAll();
	}

	public function updateReadStatus(){
        $SQL = 'UPDATE picture_like SET read_status = :read_status WHERE profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['read_status' => $this->read_status, 'profile_id' => $this->profile_id ]);
    }
}