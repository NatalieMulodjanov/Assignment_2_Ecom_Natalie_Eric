<html>

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Profile</title>

</head>

<?php
$user = new \app\models\User();
$user = $user->get($_SESSION['username']);
if (!isset($user->two_factor_authentication_token)) {
	echo "<a href=" . BASE . "User/setup2fa>Set up Two Factor Authentication</a>";
}
?>

<a href="<?= BASE ?>Profile/update">Update Profile</a>
<a href="<?= BASE ?>Picture/index/<?= $data['profile']->profile_id ?>">Post a picture</a>
<a href="<?= BASE ?>Message/create">Create Message</a>
<a href="<?= BASE ?>Message/sent/<?= $data['profile']->profile_id ?>">Sent Messages</a>
<a href="<?= BASE ?>User/logout">Logout</a>

<body>
	<?php
	$profile = $data['profile'];
	echo "<h1>Welcome $profile->first_name $profile->middle_name $profile->last_name</h1>";
	?>

	<h2>Notifications</h2>
	<?php
		if ($data['notifications'] == false) {
			echo "<span>No new notifications.</span>";
		} else {
			foreach($data['notifications'] as $notification) {
				$profile = new \app\models\Profile();
				$profile = $profile->get($notification->profile_id);
				$picture = new \app\models\Picture();
				$picture = $picture->get($notification->picture_id);
				echo "<span>You have a new notification. $profile->first_name $profile->last_name liked your picture captioned $picture->caption</span>";
			}
		}
	?>

	</br>
	</br>
	<table>
		<tr>
			<th>From</th>
			<th>Message</th>
			<th>Timestamp</th>
			<th>Read Status</th>
			<th>Private Status</th>
			<th>Actions</th>
		</tr>
		<?php
		foreach ($data['messages'] as $message) {
			$convertedTimeStamp = \app\core\helpers\Helper::ConvertDateTime($message->timestamp);
			$senderProfile = new \app\models\Profile();
			$senderProfile = $senderProfile->get($message->sender);

			echo "<tr>
			<td>$senderProfile->first_name $senderProfile->last_name</td>
			<td>$message->message</td>
			<td>$convertedTimeStamp</td>
			<td>$message->read_status</td>
			<td>$message->private_status</td>
			<td>
				<a href='" . BASE . "Message/read/$message->message_id'>read</a>
				<a href='" . BASE . "Message/to_reread/$message->message_id'>to reread</a>
				<a href='" . BASE . "Message/delete/$message->message_id'>delete</a>
			</td>
		</tr>";
		}
		?>
	</table>
	
	<h2>Pictures</h2>
	<?php
	foreach ($data['pictures'] as $picture) {
		echo "</br>";
		echo "<img src='" . BASE . "uploads/$picture->file_name' width=300 height=250 />";
		echo "</br>";
		echo "<caption>$picture->caption</caption>";
		$picture_like = new \app\models\Picture_like();
		$likeAmount = $picture_like->getLikeCount($picture->picture_id);

		echo "</br>";
		echo "<form style='display: inline-block' action='".BASE."Picture_like/like/".$picture->picture_id."' method='post'>
		<button type='submit'>$likeAmount <i class='fa fa-thumbs-up' style='color: red; font-size: 20px' aria-hidden='true'></i></button>
		</form>";

		echo "<form style='display: inline-block' action='".BASE."Picture_like/unlike/".$picture->picture_id."' method='post'>
		<button type='submit'><i class='fa fa-thumbs-down' style='color: blue; font-size: 20px' aria-hidden='true'></i> </button>
		</form>";

		echo "<td>
			<a href='" . BASE . "Picture/edit/$picture->picture_id'>edit</a>
			<a href='" . BASE . "Picture/delete/$picture->picture_id'>delete</a>
		</td>";
		
		echo "</br>";
		echo "</br>";
		
	}
	?>

	<h3>Search</h3>
	<form action="search" method='post'>
		<input type='text' name='searchTerm' value='' />
		<input type='submit' name='action' value='Search' />
	</form>
</body>
</html>
