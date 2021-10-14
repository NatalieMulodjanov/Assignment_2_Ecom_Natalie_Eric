<?php
namespace Assignment_2_Ecom_Natalie_Eric\models;

class Picture extends \Assignment_2_Ecom_Natalie_Eric\core\Model{
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
        $STMT->setFetchMode(\PDO::FETCH_CLASS, '\\Assignment_2_Ecom_Natalie_Eric\\models\\Picture');
        return $STMT->fetchAll();
    }

    
}