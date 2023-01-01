<?php 

?>

<!DOCTYPE html>
<htmllang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mon petit musée</title>
	<!-- <link rel="stylesheet" type="text/css" href="slide navbar style.css"> -->
	<link rel="stylesheet" href="style_login.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<main class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form>
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pass" placeholder="Password" required="">
					<input id ="submit" type="submit" value="Sign up"><br>
				</form>
			</div>
			
			<?php

				if(isset($_POST['SubmitSign'])) {
					insertUser($_POST['txt'], $_POST['email'], $_POST['pass']);
				}
			?>
			<div class="login">
				<form action="auth.php">
					<label for="chk" aria-hidden="true">Login</label>
					<input id="login" type="txt" name="login" placeholder="Identifiant" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<a href=""><p id="forgotPass" >Forgot your password ?</p></a>
					<input id ="submit" type="submit" value="Login"><br>
					
				</form>
			</div>
		</main>
</body>
</html>