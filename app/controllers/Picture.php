<?php

namespace app\controllers;

class Picture extends \app\core\Controller
{
	private $folder = 'uploads/';

	#[\app\filters\Login]
	#[\app\filters\Validate]
	public function index()
	{
		$profile = new \app\models\Profile();
		$profile = $profile->getByUserId($_SESSION['user_id']);

		if (isset($_POST['action'])) {
			if (isset($_FILES['newPicture'])) {
				$check = getimagesize($_FILES['newPicture']['tmp_name']);

				$mime_type_to_extension = [
					'image/jpeg' => '.jpg',
					'image/gif' => '.gif',
					'image/bmp' => '.bmp',
					'image/png' => '.png'
				];

				if ($check !== false && isset($mime_type_to_extension[$check['mime']])) {
					$extension = $mime_type_to_extension[$check['mime']];
				} else {
					$this->view('Picture/index', ['error' => "Bad file type", 'picture' => []]);
					echo 'error';
					return;
				}

				$filename = uniqid() . $extension;
				$filepath = $this->folder . $filename;
				echo 'here';

				if ($_FILES['newPicture']['size'] > 4000000) {
					$this->view('Picture/index', ['error' => "File too large", 'pictures' => []]);
					return;
				}
				if (move_uploaded_file($_FILES['newPicture']['tmp_name'], $filepath)) {
					$picture = new \app\models\Picture();
					$picture->file_name = $filename;
					$picture->profile_id = $profile->profile_id;
					$picture->caption = $_POST['caption'];
					$picture->insert();
					header('location:' . BASE . '/Profile/index');
				} else {
					$this->view('Picture/index');
				}
			}
		} else {
					$this->view('Picture/index');
				}
	}

	#[\app\filters\Login]
	#[\app\filters\Validate]
	public function edit($picture_id)
	{
		$picture = new \app\models\Picture();
		$picture = $picture->get($picture_id);

		if (isset($_POST['action'])) {
			$picture->setCaption($_POST['caption']);
			$picture->update();
			header('location:' . BASE . 'Profile/index');
		} else
			$this->view('Picture/edit');
	}

	#[\app\filters\Login]
	#[\app\filters\Validate]
	public function delete($picture_id)
	{
		$picture = new \app\models\Picture;
		$picture->delete($picture_id);
		header('location:' . BASE . 'Profile/index');
	}
}
