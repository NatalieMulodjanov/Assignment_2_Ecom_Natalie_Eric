<?php

namespace app\controllers;

class Profile extends \app\core\Controller
{
    //is called when loggs in and doesnt have a profile 
    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function create()
    {
        if (isset($_POST['action'])) {
            $profile = new \app\models\Profile();
            $profile->user_id =  $_SESSION['user_id'];
            $profile->first_name = $_POST['first_name'];
            $profile->middle_name = $_POST['middle_name'];
            $profile->last_name = $_POST['last_name'];

            $profile->create();
            header('location:' . BASE . 'Profile/index');
        } else {
            $this->view('Profile/create');
        }
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function index()
    {
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $message =  new \app\models\Message();
        $pictures = new \app\models\Picture();
        $picture_likes = new \app\models\Picture_like();

        $messages = $message->getAllMessagesFromProfileId($profile->profile_id);
        $pictures = $pictures->getByProfileId($profile->profile_id);
        $notifications = $picture_likes->getAllUnseenNotifications($profile->profile_id);
        foreach ($notifications as $notification) {
            $notification->read_status = 'seen';
            $notification->updateReadStatus();
        }
        if ($profile == false) {
            header('location:' . BASE . 'Profile/create');
        } else {
            $this->view('Profile/wall', ['profile' => $profile, 'messages' => $messages, 'pictures' => $pictures, 'notifications' => $notifications]);
        }
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function GoToProfile($profile_id)
    {
        $message =  new \app\models\Message();
        $profile = new \app\models\Profile();
        $pictures = new \app\models\Picture();
        $profile = $profile->get($profile_id);
        $pictures = $pictures->getByProfileId($profile->profile_id);

        if ($profile->user_id == $_SESSION['user_id']) {
            $messages = $message->getAllMessagesFromProfileId($profile->profile_id);
            $this->view('Profile/wall', ['profile' => $profile, 'messages' => $messages, 'pictures'=>$pictures]);
        } else {
            $messages = $message->getPublicMessagesFromProfileId($profile->profile_id);
            $this->view('Profile/wall', ['profile' => $profile, 'messages' => $messages, 'pictures'=>$pictures]);
        }
    }


    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function update()
    {
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);

        if (isset($_POST['action'])) {
            if ($_POST['first_name'] != '') {
                $profile->setFirst_name($_POST['first_name']);
            }
            if ($_POST['middle_name'] != '') {
                $profile->setMiddle_name($_POST['middle_name']);
            }
            if ($_POST['last_name'] != '') {
                $profile->setLast_name($_POST['last_name']);
            }
            $profile->update();
            header('location:' . BASE . 'Profile/index');
        } else
            $this->view('Profile/update', $profile);
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function read()
    {
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
    }

    #[\app\filters\Login]
    #[\app\filters\Validate]
    public function search()
    {
        $profile = new \app\models\Profile();
        $results = $profile->searchByName($_POST['searchTerm']);
        $this->view('Profile/searchResults', $results);
    }
}
