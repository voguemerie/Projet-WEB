<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <title>Inscription</title>
</head>
</html>

<body>
    <section>
        <h2>Inscrivez-vous</h2>
        <form action="">
            <input type="text" name="id" placeholder="identifiant"><br>
            <input type="password" name="password" placeholder="mot de passse"><br>
            <input class="material-symbols-outlined" name="submit" type="submit" value="done_outline">
        </form>
        <div  class="erreur"><?php  echo  $erreur  ?></div>
    </section>

</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Roboto', sans-serif;
        background-image: url("gradienta-G084bO4wGDA-unsplash.jpg");
    }    

    h2{
        color: grey;
    }

    section{
        /* width: 100%; */
        /* margin-top: 25%; trouver la bonne marge pour placer au milieu */
        /* text-align: center; */
        /* display: flex;
        flex-wrap: nowrap;
        flex-direction: column;
        text-align: center; */
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -150px;
        margin-top: -100px;
        
    }
    section a{
        text-decoration: none;
        color: grey;
    }
    section a:visited{
        text-decoration: none;
        color: grey;
    }
    input{
        
        padding: 8px 16px;
        border-radius: 0.5rem;
        border: 3px solid black;
        margin-bottom: 1rem;
        
        
    }
    input[type=text]{
        color: black;
        outline: none;
        padding: 12px 12px;
        width: 350px;
    }

    input[type=button]{
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
</style>