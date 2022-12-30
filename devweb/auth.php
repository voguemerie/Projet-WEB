<?php 
$pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bd 
$sql = "select * from user where login = \"".$_GET["login"]."\"";

foreach($pdo->query($sql)  as $row){ // requête sql
    if($_GET["password"]===$row["password"]){
        session_start();
        $_SESSION["log"] = true;
    }
    else{
        echo $row["Identifiant ou mot de passe incorrect."].style("color:white");
    }
        

}
    
    echo $row["login"]; 

header("Location:indexng.php");
exit;


?>