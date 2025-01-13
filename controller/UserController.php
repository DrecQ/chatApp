<?php
session_start();

include_once "../model/config.php";

$req = "SELECT * FROM users";
$stmt = $bdd->prepare($req);
$stmt-> execute();

$output = "";

if($stmt->rowCount() == 1)
{
    $output .= "Aucun utilisateur disponible";

}elseif($stmt->rowCount() > 0){
    include 'data.php'; 
}

echo $output;
