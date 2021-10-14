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

    public function getAll(){
        $SQL = 'SELECT * FROM picture';
        $STMT = self::$_connection->query($SQL);
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

    public function insert(){
        $SQL = 'INSERT INTO picture(profile_id, file_name, caption) VALUES :profile_id, :file_name, :caption';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $this->profile_id, 'file_name' => $this->file_name, 'caption' => $this->caption]);
    }

    public function delete($picture_id){
        $SQL = 'DELETE FROM picture WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id]);
    }
}