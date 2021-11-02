<?php

namespace app\controllers;

class Picture_like extends \app\core\Controller
{

    public function like($picture_id)
    {
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $likes = new \app\models\Picture_like();
        $likes->profile_id = $profile->profile_id;
        $likes->picture_id = $picture_id;
        $likes->read_status = "Unseen";
        $likes->timestamp = date('Y-m-d H:i:s');
        $likes->like();

        header('location:' . BASE . 'Profile/index');
    }

    public function unlike($picture_id)
    {
        $user_id = $_SESSION['user_id'];
        $profile = new \app\models\Profile();
        $profile = $profile->getByUserId($user_id);
        $likes = new \app\models\Picture_like();
        $likes->profile_id = $profile->profile_id;
        $likes->picture_id = $picture_id;
        $likes = $likes->unlike();
        
        header('location:' . BASE . 'Profile/index');
    }
}
