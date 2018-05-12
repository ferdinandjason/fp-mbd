<form action="src/register.php" method="POST">
	<label for="username"><b>Username</b></label>
	<input type="text" placeholder="Enter Username" name="username" required>

	<label for="email"><b>Email</b></label>
	<input type="text" placeholder="Enter Email" name="email" required>

	<label for="password"><b>Password</b></label>
	<input type="password" placeholder="Enter Password" name="password" required>

	<label for="password-repeat"><b>Repeat Password</b></label>
	<input type="password" placeholder="Repeat Password" name="password-repeat" required>
	
	<label><input type="checkbox" checked="checked" name="remember"> Remember me</label>

	<button type="button">Cancel</button>
	<button type="submit">Sign Up</button>
</form> 