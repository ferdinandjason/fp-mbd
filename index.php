<?php 
	require_once 'src/Session.php';
	require_once 'src/Function.php';
	require('src/Room.php');
	$room_control = new Room();
	$rooms = $room_control->get_all_room();
	if(isset($_SESSION['user_id'])){
		$my_rooms = $room_control->get_room($_SESSION['user_id']);
	}
	else{
		$my_rooms = [];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include('src/head.php'); ?>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
	<title>MBD</title>
</head>
<body>

	<div class="page-intro">
		<div class="vertical-center">
			<div class="page-container">
				<img src="images/coc2.png" alt>
				<div class="button-login">
					<button type="button" class="btn btn-outline-dark btn-block" data-toggle="modal" data-target="#loginModal">Log In</button>
					<button type="button" class="btn btn-outline-dark btn-block" data-toggle="modal" data-target="#signupModal">Sign Up</button>
				</div>
			</div>
		</div>

		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	<div class="modal-header">
			    		<h5 class="modal-title" id="modaltitle">Log In</h5>
			    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    			<span aria-hidden="true">&times;</span>
				        </button>
			    	</div>
			   		
			   		<div class="modal-body">
			   			<form>
			   				<div class="form-group">
			   					<label for="inputemail">Email</label>
			   					<input type="email" class="form-control" id="inputemail" aria-describedby="emailHelp" placeholder="Enter your email">
			   				</div>

			   				<div class="form-group">
			   					<label for="inputpassword">Password</label>
			   					<input type="password" class="form-control" id="inputpassword" placeholder="Password">
			   				</div>

			   				<div class="form-check">
			   					<input type="checkbox" class="form-check-input" id="remembermecheck">
			   					<label class="form-check-label" for="remembermecheck">Remember Me</label>
			   				</div>
						</form>
			    	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-primary">Log In</button>
			       	</div>
			    </div>
			</div>
		</div>

		<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	<div class="modal-header">
			    		<h5 class="modal-title" id="modaltitle">Sign Up</h5>
			    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    			<span aria-hidden="true">&times;</span>
				        </button>
			    	</div>
			   		
			   		<div class="modal-body">
			   			<form>
			   				<div class="form-group">
			   					<label for="inputusernamesu">Username</label>
			   					<input type="text" class="form-control" id="inputusernamesu" placeholder="Enter your username">
			   				</div>

			   				<div class="form-group">
			   					<label for="inputemailsu">Email</label>
			   					<input type="email" class="form-control" id="inputemailsu" aria-describedby="emailHelp" placeholder="Enter your email">
			   				</div>

			   				<div class="form-group">
			   					<label for="inputpasswordsu">Password</label>
			   					<input type="password" class="form-control" id="inputpasswordsu" placeholder="Password">
			   				</div>

						</form>
			    	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-primary">Sign Up</button>
			       	</div>
			    </div>
			</div>
		</div>

	</div>

	<?php if(!isset($_SESSION['user_id'])): ?>
		<?php include('src/LoginForm.php'); ?>
	<?php else :?>
		Welcome <?php echo $_SESSION['username']; ?>
	<?php endif; ?>

	<p> AVAIABLE ROOM </p>
	<ul>
		<?php foreach ($rooms as $room) : ?>
			<?php if(!is_joined_room($_SESSION['user_id'],$room['room_id'])): ?>
				<li>
					Nama : <?php echo $room['name']."<br>" ?>
					Level : <?php echo $room['level_id']."<br>" ?>
					<form action="src/join_room.php" method="POST">
						<input type="hidden" name="room" value="<?php echo $room['room_id'] ?>">
						<button type="submit">Join ROOM</button>
					</form>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<p> JOINED ROOM </p>
	<ul>
		<?php foreach ($my_rooms as $room) : ?>
			<li>
				ID Room : <?php echo $room['room_id']."<br>" ?>
			</li>
		<?php endforeach; ?>
	</ul>


	<form action="src/create_room.php" method="POST">
		<label for="name"><b>Room Name</b></label>
		<input type="text" placeholder="Enter Username" name="name" required>
		<label for="password"><b>Password</b></label>
		<input type="password" placeholder="Kosong apabila public" name="password" required>
		<button type="submit">CREATE ROOM</button>
	</form>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
