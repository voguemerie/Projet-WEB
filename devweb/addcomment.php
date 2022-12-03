<?php 
    echo("j'ai trouvé la page");
    if(!isset($_POST['content'])){
        throw new ErrorException("commentaire manquant");
    }

    $pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bd 
    $sql = "INSERT INTO comment VALUES(".$_POST['content'].",".$_POST['user']. ",". $_POST['date'].")"; 
    $sql = "INSERT INTO comment (content, user, date) VALUES (?, ?, ?)"; 
    $statment = $pdo->prepare($sql); //préparer la reqûete
    $statment->execute([$_POST['content'], $_POST['user'], $_POST['date']]);
    echo("ça marche");
    return 0;

?>