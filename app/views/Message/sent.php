<html>

<head>
	<title>Sent Messages</title>
</head>

<a href="<?=BASE?>Profile/index">return</a><br><br>

<body>
	<table>
		<tr>
			<th>From</th>
			<th>Message</th>
			<th>Timestamp</th>
			<th>Read Status</th>
			<th>Private Status</th>
		</tr>
		<?php
		foreach ($data as $message) {
			$convertedTimeStamp = \app\core\helpers\Helper::ConvertDateTime($message->timestamp);
			$senderProfile = new \app\models\Profile();
			$senderProfile = $senderProfile->get($message->sender);
			
			echo "<tr>
			<td>$senderProfile->first_name $senderProfile->last_name</td>
			<td>$message->message</td>
			<td>$convertedTimeStamp</td>
			<td>$message->read_status</td>
			<td>$message->private_status</td>
		</tr>";
		}
		?>
	</table>
</body>

</html>