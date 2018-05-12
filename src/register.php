<?php 
require('Session.php');
include('Auth.php');
$auth = new Auth();
if($_POST['password'] == $_POST['password-repeat']){
	$auth->daftar($_POST['username'],$_POST['email'],$_POST['password']);
}

?>