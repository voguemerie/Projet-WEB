<?php 
$pdo = null;

function insertUser($tab) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bdd
    } catch (PDOException $exp) {
        echo "Erreur de connexion à la base données";
        $exp->getMessage();
    }
    $sql = "INSERT INTO user VALUES(NULL, :login, :email, :password);";
    $donnees = array(
        ":login" => $tab["login"],
        ":email" => $tab["email"],
        ":password" => $tab["password"]
    );
    $select = $pdo->prepare($sql);
    $select->execute($donnees);
}

function forgotPass($tab){
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bdd
    } catch (PDOException $exp) {
        echo "Erreur de connexion à la base données";
        $exp->getMessage();
    }
    $req = "UPDATE user SET password=:password WHERE login=:login AND email=:email;";
    $donnees = array(
        ":password" => $tab["password"],
        ":login" => $tab["login"],
        ":email" => $tab["email"]
    );
    $select = $pdo->prepare($req);
    $select->execute($donnees);
}

?>