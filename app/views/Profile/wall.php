<html>

<head>
	<title>Profile</title>
</head>

<a href="<?=BASE?>Profile/update">Update Profile</a>
<a href="<?=BASE?>Message/create/$data[profile]">Create Message</a>
<a href="<?=BASE?>User/logout">Logout</a><br><br>

<a>Search Profile</a>
<form action="" method ="post">
    <label>Enter Profile ID</label><input type="text" name="profile_id"> <br>
    <input type="submit" name='action' value='Enter'>
</form>

<body>
	<h2>Profile Name</h2>
	<?php
		$profile = $data['profile'];
		echo "<h3>$profile->first_name ($profile->middle_name) $profile->last_name</h3>";
	?>

<table>
	<tr><th>From</th><th>Message</th><th>Timestamp</th><th>Actions</th></tr>
<?php
foreach($data['messages'] as $message){

	echo "<tr>
			<td>$message->sender</td>
			<td>$message->message</td>
			<td>$message->timestamp</td>
			<td>
				<a href='".BASE."Profile/read/$message->message_id'>read</a>
			</td>
		</tr>";
}
?>
</table>



</body>
</html>