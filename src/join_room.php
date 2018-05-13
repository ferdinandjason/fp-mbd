<?php 
require('Session.php');
include('Room.php');
$room = new Room();
$room->insert_to_room($_POST['room'],$_SESSION['user_id']);
?>