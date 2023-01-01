<?php 



?>

<!DOCTYPE html>
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
            <!-- <label for="login">Login :</label> -->
            <input id ="login" type="text" name="login" placeholder="identifiant"><br>
            <!-- <label for="password">Password :</label> -->
            <input id ="password" type="pass" name="password" placeholder="mot de passe"><br>
            
            <input class="material-symbols-outlined" id ="submit" type="submit" value="done_outline"><br>
        </form>
        <a href="signin.php">Vous n'êtes pas encore inscrit ?</a>
        <div id="mess_err">Identifiant ou mot de passe incorrect.</div>
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
        color: red;
        font-size: 12px;
        font-weight: bold;
    }
    
</style>
</html>