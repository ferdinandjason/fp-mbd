<?php 

require('config.php');

function is_joined_room($user_id,$room_id){
	global $db;
	$query = "SELECT fn_is_joined_room($room_id,$user_id);";
	$res = $db->query($query);
	var_dump($res);
	return $res->fetch_array(MYSQLI_BOTH)[0];
}

?>