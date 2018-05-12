<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('Auth.php');
$auth = new Auth();
$auth->login($_POST['email'],$_POST['password']);

?>