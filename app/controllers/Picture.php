<?php
namespace app\controllers;

class Picture extends \app\core\Controller{
	private $folder='uploads/';
	public function index(){

		if(isset($_POST['action'])){
			if(isset($_FILES['newPicture'])){
				$check = getimagesize($_FILES['newPicture']['tmp_name']);

				$mime_type_to_extension = ['image/jpeg'=>'.jpg',
											'image/gif'=>'.gif',
											'image/bmp'=>'.bmp',
											'image/png'=>'.png'
											];

				if($check !== false && isset($mime_type_to_extension[$check['mime']])){
					$extension = $mime_type_to_extension[$check['mime']];
				}else{
					$this->view('Picture/index', ['error'=>"Bad file type",'picture'=>[]]);
					return;
				}

				$filename = uniqid().$extension;
				$filepath = $this->folder.$filename;

				if($_FILES['newPicture']['size'] > 4000000){
					$this->view('Picture/index', ['error'=>"File too large",'pictures'=>[]]);
					return;
				}
				if(move_uploaded_file($_FILES['newPicture']['tmp_name'], $filepath)){
					$picture = new \app\models\Picture();
					$picture->filename = $filename;
					$picture->insert();
					header('location:/Picture/index');
				}
				else
					echo "There was an error";
			}
		}else{
			$picture = new \app\models\Picture();
			$pictures = $picture->getAll();
			$this->view('Picture/index',['error'=>null,'pictures'=>$pictures]);
		}
	}

	public function edit($picture_id){
		$picture = new \app\models\Picture();
		$picture = $picture->get($picture_id);

		if(isset($_POST['action'])){
			$picture->setCaption($_POST['caption']);
			$picture->update();
			header('location:/Picture/index');
		} else
			$this->view('Profile/update')
	}
	
	public function delete($picture_id){
		$picture = new \app\models\Picture();
		$profile_id = $picture->get($picture_id);
		$profile_id = $profile_id->profile_id;
		$picture->delete($picture_id);
		header('location:/Profile/update/'.$_SESSION['user_id']);
	}
}