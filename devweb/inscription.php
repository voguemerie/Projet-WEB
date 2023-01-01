<?php 
$pdo = null;

function insertUser($log, $email, $pass) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=devweb","root","root"); //pdo : connexion bdd
    } catch (PDOException $exp) {
        echo "Erreur de connexion à la base données";
        $exp->getMessage();
    }
    $sql = "INSERT INTO user VALUES(NULL, :login, :email, :password);";
    $donnees = array(
        ":login" => $log,
        ":email" => $email,
        ":password" => $pass
    );
    var_dump($donnees);
    $select = $pdo->prepare($sql);
    $select->execute($donnees);
}

?>