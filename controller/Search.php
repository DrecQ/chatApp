<?php 
include_once("../model/config.php");

if (!isset($_POST['searchTerm']) || empty(trim($_POST['searchTerm']))) {
    exit("Veuillez entrer un terme de recherche !");
}

$searchTerm = trim($_POST['searchTerm']); 
$searchTerm = "%$searchTerm%"; // Ajoute les wildcards pour LIKE

$output = "";

try {
    $req = "SELECT * FROM users WHERE nom LIKE :searchTerm OR prenom LIKE :searchTerm"; 
    $stmt = $bdd->prepare($req);
    $stmt->execute(["searchTerm" => $searchTerm]);

    if ($stmt->rowCount() > 0) {
        include 'data.php';
    } else {
        $output .= "Aucun utilisateur trouvé";
    }

    echo $output;
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}
?>
