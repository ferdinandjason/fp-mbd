<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('Auth.php');
$auth = new Auth();
if($_POST['password'] == $_POST['password-repeat']){
	$auth->daftar($_POST['username'],$_POST['email'],$_POST['password']);
}

?>