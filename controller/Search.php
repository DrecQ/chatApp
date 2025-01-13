<?php 

include_once("../model/config.php");

$searchTerm = htmlspecialchars(htmlentities($_POST['searchTerm']));
$output = "";
// echo $searchTerm;
    $req = "SELECT * FROM users WHERE nom LIKE :searchTerm OR prenom LIKE :searchTerm"; 
    $stmt = $bdd->prepare($req);
    $stmt->execute(["searchTerm"=>$searchTerm]);

    if($stmt->rowCount() > 0)
    {
        include 'data.php';
    }else{
        $output .= "Aucun utilsateur trouvé";
    }

    echo $output;