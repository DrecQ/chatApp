<?php
session_start();
include_once '../model/config.php';

$email = htmlspecialchars(htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'));
$password = htmlspecialchars(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'));

// echo "The file run good";

if(!empty($email) && !empty($password))
{

    //$pass = password_hash($password, PASSWORD_BCRYPT);
    
    //Gestion de l'authentification
    $req = $bdd ->prepare("SELECT * FROM users WHERE email =:email AND password =:password ");
    $req->execute(["email"=>$email, "password"=>$password]);

    if($req->rowCount() > 0)
    {
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $_SESSION['unique_id'] = $row['unique_id'];
        echo "success";

    }else{
        echo "Vos identifiants sont incorrectes!";
    }

}else{
    echo "Remplissez tous les champs !";
}