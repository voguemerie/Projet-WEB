<?php 

session_start();
$_SESSION["log"] ??= false;

if(!$_SESSION["log"]){
    header('Location:login.php');  //redirection sur le login lorsque l'on arrive sur la page
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bd 
$sql = "select * from comment ORDER BY date";
$comment = [];

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
    src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <form action="logout.php" >
        <input type="submit" value="Se deconnecter">
    </form>
    <p name="mess_log" id="mess_log">Bonjour vous êtes connecté</p>
    
    <?php 
        
        foreach($pdo->query($sql)  as $row){ // requête sql
            echo "<div class='comment'>".$row['content']." </div>";
        }
        
    ?>
    <textarea name="comment_area" id="comment_area" cols="30" rows="10" placeholder="taper votre commentaire ici"></textarea>
    <button id="post_comment">commenter</button>
    <script>
        $(document).ready(function(){
            $("#post_comment").click(function(){
                var ajaxURL = "addcomment.php";
                var data = {'content':$("#comment_area").val(), 'user':1, 'date':Date.now()}
                $.post(ajaxURL, data, function(res){});
            });
        });


    </script>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Roboto', sans-serif;
        background-image: url("gradienta-G084bO4wGDA-unsplash.jpg");
    }

    form[action='logout.php']{
        
    }
    form[action='logout.php'] input{
        border: 3px solid black;
        margin-bottom: 1rem;
        padding: 8px 16px;
        border-radius: 0.5rem;
        color: black;
        
        width: 150px;
        float: right;
        

        /* position: absolute;
        left: 95rem; */
    }
    form[action='logout.php'] input:hover{
        filter: brightness(90%);
    }

    #mess_log{
        text-align: center;
        font-size: larger;
        color: grey;
        /* position absolute; */
        /* top: 2rem;
        left:50%; */

    }
    /* #mess_log{
        font-size: large;
        color: grey;

        transition-duration: 7s;
        transition-delay: infinite;
        
        transform: translateX(0);
        transform: translateX(20%);
        transform: translateX(40%);
        transform: translateX(60%);
        transform: translateX(80%);
        transform: translateX(100%);
    } */
    
</style>

</html>