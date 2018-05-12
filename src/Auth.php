<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Auth{
	public $db;

	function __construct(){
		include('config.php');
		$this->db = $db;
		echo 'asd';
	}

	function login($username,$password){
		if(!isset($_COOKIE['auth_session'])){
			$query = "CALL sp_login('$username','$password')";
			$res = $this->db->query($query);
			$row = $res->fetch_array(MYSQLI_NUM);
			if($row[0] == 1){ // success
				echo 'asdasd';
				$this->setSession($row);
			}
		}
	}

	function logout(){
		session_destroy();
	}

	function daftar($username,$email,$password){
		$query = "CALL sp_daftar('$username','$email','$password')";
		echo $query;
		$res = $this->db->query($query);
		echo '---------------<br>';
		var_dump($res);
		echo '---------------<br>';
		$row = $res->fetch_array(MYSQLI_NUM);
		if($row[0] == 1){ // success
			echo 'asdasdasdasd';
		}
	}

	function __destruct(){
		$this->db->close();
	}

	function setSession($row){

	}
}

?>