<?php
namespace app\controllers;

class Profile extends \app\core\Controller{
    //is called when loggs in and doesnt have a profile 
    public function create($user_id){
        if (isset($_POST['action'])){
            $profile = new \app\models\Profile();
            $profile->user_id = $user_id;
            $profile->first_name = $_POST['first_name'];
            $profile->middle_name = $_POST['middle_name'];
            $profile->last_name = $_POST['last_name'];

            $profile->create();
            header('location:'.BASE.'Profile/index');
        }else {
            $this->view('Profile/create');
        }

    }

    public function index(){

    }
}