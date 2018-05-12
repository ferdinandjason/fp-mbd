<?php 

class Auth{
	public $db;

	function __construct(){
		include('config.php');
		$this->db = $db;
	}

	function login($email,$password){
		if(!isset($_COOKIE['auth_session'])){
			$query = "";
			$query.= "CALL sp_login('$email','$password');";
			$query.= "SELECT * FROM `user` WHERE email='".$email."';";
			$row = [];

			if(!$this->db->multi_query($query)){
				echo "Multi query failed: (" . $this->db->errno . ") " . $this->db->error;
			}
			do{
				if ($res = $this->db->store_result()) {
			        array_push($row,$res->fetch_all(MYSQLI_BOTH));
			        $res->close();
			    }
			} while ($this->db->more_results() && $this->db->next_result());
			if($row[0][0][0] == 1){ // success
				$this->setSession($row[1][0]);
			}
		}
	}

	function logout(){
		session_destroy();
	}

	function daftar($username,$email,$password){
		$query = "CALL sp_daftar('$username','$email','$password')";
		$res = $this->db->query($query);
		$row = $res->fetch_array(MYSQLI_BOTH);
		if($row[0] == 1){ // success

		}
	}

	function __destruct(){
		$this->db->close();
	}

	function setSession($row){
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['level'] = $row['level_level'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['exp'] = $row['exp'];
	}
}

?>