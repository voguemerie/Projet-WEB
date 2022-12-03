<?php 
$pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bd 
$sql = "insert into user (login, password) values( \"".$_GET["id"]."\", \"".$_GET["password"]."\";
foreach($pdo->query($sql)  as $row){ // requête sql
    if($_GET["password"]===$row["password"]){
        session_start();
        $_SESSION["log"] = true;
        

    }
    echo $row["Félicitations, ".$id." vous êtes inscrit"]; 
}
header("Location:index.php");
exit;


?>