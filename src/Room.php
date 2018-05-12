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

	function create_room($name,$id){
		$level = $this->get_max_level();
		echo $level;
		$query = "CALL sp_create_room($level,$id,NOW(),'$name');";
		$res = $this->db->query($query);
		echo $this->db->error;
		$row = $res->fetch_array(MYSQLI_BOTH);
	}

	function insert_to_toom($room,$level_id,$user_id){
		$query = "CALL sp_insert_into_room($room,$level_id,$user_id);";
		$res = $this->db->query($query);
		$row = $res->fetch_array(MYSQLI_BOTH);
	}
	

	function __destruct(){
		$this->db->close();
	}
}

?>