<?php 

class Room{
	public $db;

	function __construct(){
		include('config.php');
		$this->db = $db;
	}

	function get_max_level(){
		$query = "SELECT fn_get_max_level();";
		$res = $this->db->query($query);
		$row = $res->fetch_array(MYSQLI_BOTH);
		var_dump($row);
		return rand(0,$row[0]);
	}

	function create_room($name,$password){
		$level = $this->get_max_level();
		$query = "CALL sp_create_room($level,$name,$password);";
		$res = $this->db->query($query);
		echo $this->db->error;
		$row = $res->fetch_array(MYSQLI_BOTH);
	}

	function insert_to_room($room,$user_id){
		$query = "CALL sp_insert_into_room($room,$user_id);";
		$res = $this->db->query($query);
		echo $this->db->error;
		$row = $res->fetch_array(MYSQLI_BOTH);
	}

	function get_all_room(){
		$query = "SELECT * FROM room_detail WHERE avaiable = 1;";
		$res = $this->db->query($query);
		$row = $res->fetch_all(MYSQLI_BOTH);
		return $row;
	}

	function get_room($user){
		$query = "SELECT * FROM room WHERE user_id = $user;";
		$res = $this->db->query($query);
		$row = $res->fetch_all(MYSQLI_BOTH);
		return $row;
	}
	

	function __destruct(){
		$this->db->close();
	}
}

?>