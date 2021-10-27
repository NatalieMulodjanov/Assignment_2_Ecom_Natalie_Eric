<?php
namespace app\models;

class User extends \app\core\Model{
	public $user_id;
	public $username;
	public $password_hash;
	public $password;
	public $two_factor_authentication_token;

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$SQL = 'SELECT * FROM user';
		$STMT = self::$_connection->query($SQL);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\User');
		return $STMT->fetchAll();
	}

	public function get($username){
		$SQL = 'SELECT * FROM user WHERE username = :username';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$username]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\User');
		return $STMT->fetch();
	}

	public function insert(){
		$this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
		$SQL = 'INSERT INTO user(username, password_hash) VALUES (:username, :password_hash)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$this->username,'password_hash'=>$this->password_hash]);
	}

	public function update(){
		$SQL = 'UPDATE `user` SET `username`=:username,`password_hash`=:password_hash,`two_factor_authentication_token`=:two_factor_authentication_token WHERE user_id = :user_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$this->username,'password_hash'=>$this->password_hash,'two_factor_authentication_token'=>$this->two_factor_authentication_token,'user_id'=>$this->user_id]);
	}

	public function delete($user_id){
		$SQL = 'DELETE FROM `user` WHERE user_id = :user_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['user_id'=>$user_id]);
	}

}