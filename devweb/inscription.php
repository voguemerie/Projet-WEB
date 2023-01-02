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

// function comment($tab){
//     try {
//         $pdo = new PDO("mysql:host=localhost;dbname=devweb","root",""); //pdo : connexion bdd
//     } catch (PDOException $exp) {
//         echo "Erreur de connexion à la base données";
//         $exp->getMessage();
//     }
//     $sql = "INSERT INTO comment VALUES(NULL, :content, :user, :date);";
//     $donnees = array(
//         ":content" => $tab["content"],
//         ":user" => $_SESSION["id"],
//         ":date" => "sysdate()"
//     );
//     var_dump($donnees);
//     $select = $pdo->prepare($sql);
//     $select->execute($donnees);
// }
// et dans la page y'aurait eu ça
// <?php 
// var_dump($_SESSION["id"]);
// if(isset($_POST["commenter"])){
//     var_dump($_POST);
//     if(!empty($_POST["content"])){
//         comment($_POST);
//     }
// } ? >
// 

/*trim enlève les espaces, chevrons + guillemets = entités html
	$login = trim(htmlspecialchars($_POST['login']));
	$password = trim(htmlspecialchars($_POST['password']));
	$email = trim(htmlspecialchars($_POST['email']));
	var_dump($login, $password);
	$req = "INSERT INTO user VALUES(NULL, :login, :email, :password);";
	$donnees = array(
		":login"=>$login,
		"password"=>$password,
		"email"=>$email
	);
$insert*/

?>