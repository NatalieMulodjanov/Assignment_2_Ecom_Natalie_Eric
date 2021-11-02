<?php
namespace app\models;

class Picture extends \app\core\Model{
    public $picture_id;
    public $profile_id;
    public $file_name;
    public $caption;

    public function __construct(){
        parent::__construct();
    }

    public function getCaption(){
		return $this->caption;
	}

    public function setCaption($caption){
		$this->caption = $caption;
	}

    public function getAll($profile_id){
        $SQL = 'SELECT * FROM picture WHERE profile_id = :profile_id';
        $STMT = self::$_connection->query($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, '\\app\\models\\Picture');
        return $STMT->fetchAll();
    }

    public function get($picture_id){
        $SQL = 'SELECT * FROM picture WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, '\\app\\models\\Picture');
        return $STMT->fetch();
    }

    public function getByProfileId($profile_id){
        $SQL = 'SELECT * FROM picture WHERE profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, '\\app\\models\\Picture');
        return $STMT->fetchAll();
    }

    public function getLikeAmount($picture_id){
        $SQL = 'SELECT * FROM picture_like WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id]);
        $rows = $STMT->fetchAll();
        $likeAmount = 0;
        foreach ($rows as $picture_like){
            $likeAmount++;
        }
        return $likeAmount;
    }

    public function insert(){
        $SQL = 'INSERT INTO picture(profile_id, file_name, caption) VALUES (:profile_id, :file_name, :caption)';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $this->profile_id, 'file_name' => $this->file_name, 'caption' => $this->caption]);
    }

    public function delete($picture_id){
		$SQL = 'DELETE FROM picture WHERE picture_id = :picture_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['picture_id'=>$picture_id]);
	}

    public function update(){
        $SQL = 'UPDATE picture SET caption = :caption WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['caption' => $this->caption,'picture_id' => $this->picture_id]);
    }


}