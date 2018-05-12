<?php 
require('Session.php');
include('Auth.php');
$auth = new Auth();
$auth->login($_POST['email'],$_POST['password']);

?>