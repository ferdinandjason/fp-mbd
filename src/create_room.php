<?php 
require('Session.php');
include('Room.php');
$room = new Room();
$room->create_room($_POST['name'],$_POST['password']);
?>