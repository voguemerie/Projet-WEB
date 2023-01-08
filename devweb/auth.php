<?php

function selectUser($login, $password)
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=devweb", "root", ""); //pdo : connexion bd 
    } catch (PDOException $exp) {
        echo "Erreur";
        echo $exp->getMessage();
    }
    $req = "SELECT * FROM user WHERE login=? AND password=?;";
    if ($pdo != null) {
        // session_start();
        $select = $pdo->prepare($req);
        $select->execute(array($login, $password));
        // fetch retourn un tableau (pour 1 valeur)
        // fetchAll retourn un tableau (pour toutes les valeurs)
        $unUser= $select->fetch(); 
        session_start();
        $_SESSION["log"] = true;
        return $unUser;
    } else {
        return null;
    }
}
