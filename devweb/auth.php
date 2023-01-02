<?php 
$pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bd 
$sql = "select * from user where login = \"".$_GET["login"]."\"";
$err_login ="mess_err";

foreach($pdo->query($sql)  as $row){ // requête sql
    if($_GET["password"]===$row["password"]){
        session_start();
        $_SESSION["log"] = true;
    }
    else{
        echo $row["Identifiant dede ou mot de passe incorrect."];
        // style("color:white");
        header("Location:login.php");
        exit;
    }
}
    
    echo $row["login"]; 

header("Location:index.php");
exit;
?>