<?php 
	require_once 'src/Session.php';
	require_once 'src/Function.php';
	require('src/Room.php');
	$room_control = new Room();
	$rooms = $room_control->get_all_room();
	$my_rooms = $room_control->get_room($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
	<?php include('src/head.php'); ?>
	<title>MBD</title>
</head>
<body>
	<?php if(!isset($_SESSION['user_id'])): ?>
		<?php include('src/LoginForm.php'); ?>
	<?php else :?>
		Welcome <?php echo $_SESSION['username']; ?>
	<?php endif; ?>

	<p> AVAIABLE ROOM </p>
	<ul>
		<?php foreach ($rooms as $room) : ?>
			<?php if(!is_joined_room($_SESSION['user_id'],$room['room_id'])): ?>
				<li>
					Nama : <?php echo $room['name']."<br>" ?>
					Level : <?php echo $room['level_id']."<br>" ?>
					<form action="src/join_room.php" method="POST">
						<input type="hidden" name="room" value="<?php echo $room['room_id'] ?>">
						<button type="submit">Join ROOM</button>
					</form>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<p> JOINED ROOM </p>
	<ul>
		<?php foreach ($my_rooms as $room) : ?>
			<li>
				ID Room : <?php echo $room['room_id']."<br>" ?>
			</li>
		<?php endforeach; ?>
	</ul>


	<form action="src/create_room.php" method="POST">
		<label for="name"><b>Room Name</b></label>
		<input type="text" placeholder="Enter Username" name="name" required>
		<label for="password"><b>Password</b></label>
		<input type="password" placeholder="Kosong apabila public" name="password" required>
		<button type="submit">CREATE ROOM</button>
	</form>
</body>
</html>
