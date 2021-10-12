<?php
namespace Assignment_2_Ecom_Natalie_Eric\core;
//this is the base controller class to be extended by all controllers

class Controller{
	public function view($name,$data=null){
		include 'app/views/' . $name . '.php';
	}
}