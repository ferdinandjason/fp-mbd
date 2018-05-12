<?php 
	require_once 'src/Session.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
	<?php include('src/head.php'); ?>
	<title>MBD</title>
</head>
<body>
	<!-- <?php include('src/RegisterForm.php'); ?> -->
	<?php include('src/LoginForm.php'); ?>
</body>
</html>
