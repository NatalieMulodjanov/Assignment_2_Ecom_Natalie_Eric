<html>

<head>
	<title>Profile</title>
</head>

<a href="<?=BASE?>Profile/update">Update Profile</a>
<a href="<?=BASE?>Message/create/$data[profile]">Create Message</a>
<a href="<?=BASE?>Profile/goToProfile">Search Profile</a>
<a href="<?=BASE?>User/logout">Logout</a><br><br>



<body>
	<h2>Profile Name</h2>
	<?php
		$profile = $data['profile'];
		echo "<h3>$profile->first_name $profile->middle_name $profile->last_name</h3>";
	?>

<table>
	<tr><th>From</th><th>Message</th><th>Timestamp</th><th>Actions</th></tr>
<?php
foreach($data['messages'] as $message){

	echo "<tr>
			<td>$message->sender</td>
			<td>$message->message</td>
			<td>$message->timestamp</td>
			<td>$message->read_status</td>
			<td>
				<a href='".BASE."Message/read/$message->message_id'>read</a>
				<a href='".BASE."Message/to_reread/$message->message_id'>to reread</a>
			</td>
		</tr>";
}
?>
</table>



</body>
</html>