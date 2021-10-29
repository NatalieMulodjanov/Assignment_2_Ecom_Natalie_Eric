<html>

<head>
	<title>Profile</title>
</head>

<a href="<?=BASE?>Profile/update">Update Profile</a>
<a href="<?=BASE?>User/logout">Logout</a>

<body>
	<h2>First name</h2>
	<?php
		echo "<h3>$data->first_name</h3>"
	?>

<table>
	<tr><th>From</th><th>Message</th><th>Timestamp</th><th>Actions</th></tr>
<?php
foreach($data(messages) as $message){

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