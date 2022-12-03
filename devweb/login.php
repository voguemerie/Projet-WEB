<?php 

   
    

?>

<!DOCTYPE html>
<html>
<head>
	<title>Mon petit musée</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    

</body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form>
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<input id ="submit" type="submit" value="Logon"><br>
				</form>
			</div>
			<div class="login">
				<form action="auth.php">
					<label for="chk" aria-hidden="true">Login</label>
					<input id="login" type="txt" name="login" placeholder="Identifiant" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<input id ="submit" type="submit" value="Login"><br>
				</form>
			</div>
	</div>
</body>
<style>
body{
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Lucida Bright', sans-serif;
	background-image: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
    background-image: url("fond_form.jpg");
    background-size: cover;
}
.main{
	width: 350px;
	height: 500px;
	background: red;
	overflow: hidden;
	background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 20px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
    font-family: 'Lucida Bright', sans-serif;
}
#submit{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #573b8a;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
    font-family: 'Lucida Bright', sans-serif;
}
button:hover{
	background: #6d44b8;
}
.login{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color: #573b8a;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);	
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}
</style>
</html>



<!-- <--!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


    <title>Document</title>
</head>
<body>
    <section>
        <h2>Connectez-vous</h2>
        <form action="auth.php">
            <label for="login">Login :</label> 
            <input id ="login" type="text" name="login" placeholder="identifiant"><br>
            <label for="password">Password :</label>
            <input id ="password" type="password" name="password" placeholder="password"><br>
            
            <input class="material-symbols-outlined" id ="submit" type="submit" value="done_outline"><br>
        </form>
        <a href="signin.php">Vous n'êtes pas encore inscrit ?</a>
        <p id="mess_err"></p>
    </section>

</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Roboto', sans-serif;
        background-image: url("gradienta-G084bO4wGDA-unsplash.jpg");
    }   
    section{
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -150px;
        margin-top: -150px;
    }
    section h2{
        color: grey;
        font-size: 2rem;   
    }
    section a{
        color: grey;
        text-decoration: none;
    }
    input{
        
        padding: 8px 16px;
        border-radius: 0.5rem;
        border: 3px solid black;
        margin-bottom: 1rem;
    }
    input[type=text], input[type=password]  {
        color: black;
        outline: none;
        padding: 12px 12px;
        width: 350px;
    }
    input[type=submit   ]{
        color: black;
        outline: none;
        width: 90px;
        float: right;

        /* margin-left: 25%; */
    }
    input[type=button]:hover{
        filter: brightness(90%);
    }
    .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
    }
    #mess_err{
        color: white;
    }
    
</style>
</html>-->