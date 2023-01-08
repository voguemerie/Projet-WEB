<?php
require_once("inscription.php");
require_once("auth.php");
?>

<!DOCTYPE html>
<html lang="fr">

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
			<form method="POST">
				<label for="chk" aria-hidden="true">Sign up</label>
				<input type="text" name="login" placeholder="User name" required="">
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<input class="submit" type="submit" name="signup" value="Sign up"><br>
				<?php
				if (isset($_POST['signup'])) {
					insertUser($_POST);
				}
				?>
			</form>
		</div>

		<div class="login">
			<form method="POST">
				<label for="chk" aria-hidden="true">Login</label>
				<input id="login" type="txt" name="login" placeholder="Identifiant" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<p id="forgotPass"><a href="forgot.php">Forgot your password ?</a></p>
				<input class="submit" type="submit" name="connexion" value="Login"><br>

				<?php
				if (isset($_POST['connexion'])) {
					$login = $_POST['login'];
					$password = $_POST['password'];
					$unUser= selectUser($login, $password);
					if($unUser!= null){
						header('LOCATION: index.php');
					}else{
						echo "<p style='text-align:center; color:red;'>mot de passe incorrect</p>";
					}
					
				}
				?>
			</form>
		</div>
	</main>
</body>

</html>