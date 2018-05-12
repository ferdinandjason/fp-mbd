<?php 
	require_once 'src/Session.php';
	require_once 'src/Function.php';
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


	<form action="src/create_room.php" method="POST">
		<label for="name"><b>Room Name</b></label>
		<input type="text" placeholder="Enter Username" name="name" required>
		<button type="submit">CREATE ROOM</button>
	</form>
</body>
</html>
