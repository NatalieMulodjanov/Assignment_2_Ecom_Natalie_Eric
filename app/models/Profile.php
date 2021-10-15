<?php
namespace app\models; 

class Profile extends \app\core\Model{

    public $profile_id;
    public $user_id;
    public $first_name;
    public $middle_name;
    public $last_name;

    public function __construct(){
        parent::__construct();
    }
    
    public function create(){
        $SQL = 'INSERT INTO profile (user_id, first_name, middle_name, last_name) VALUES :user_id, :first_name, :middle_name, :last_name,';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['user_id' => $this->user_id, 'first_ name' => $this->first_name, 'moddle_name' => $this->middle_name, 'last_name' => $this->last_name]);
    }


    



}