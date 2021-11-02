<html>
<head>
	<title>Picture upload</title>
</head>
<body>

	<h1>Upload a picture</h1>
	<form method="post" enctype="multipart/form-data">
		Select an image to upload: <input type="file" name="newPicture"><br><br>
		Enter caption: <input type='text' name='caption'/><br><br>
		<input type="submit" name="action">
	</form>
	<br><br>
	<a href="<?=BASE?>Profile/index"><button>Back</button></a>
</body>
</html>