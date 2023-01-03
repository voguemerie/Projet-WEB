<?php 
    require_once("inscription.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_forgot.css">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <table>
            <tr>
                <td>
                    <input type="text" name="login" placeholder="username">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="email" name="email" placeholder="email">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="password2" placeholder="Nouveau mot de passe">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="password" placeholder="Confirmer le mot de passe">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="confirmer" value="confirmer">
                </td>
            </tr>
        </table>
        <?php
            if(isset($_POST["confirmer"])){
                if(!empty($_POST['login']) && (!empty($_POST['email'])) && (!empty($_POST['password'])) && (!empty($_POST['password2']))){
                    if($_POST["password"] == $_POST["password2"]){
                        forgotPass($_POST);
                        header("Location: login.php");
                    } else{
                        echo "<p> Les deux mots de passe ne sont pas identiques </p>";
                    }
                }else{
                    echo"<p> Veuillez remplir tous les champs </p>";
                }
            }
        ?>
    </form>

</body>
</html>
