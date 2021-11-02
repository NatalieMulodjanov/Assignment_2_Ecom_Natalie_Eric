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
}