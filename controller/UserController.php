<?php
session_start();
include_once "../model/config.php";

$req = "SELECT * FROM users";
$stmt = $bdd->prepare($req);
$stmt->execute();

$output = "";

if ($stmt->rowCount() == 0) { // Vérifier si aucun utilisateur n'est trouvé
    $output = "Aucun utilisateur disponible";
} else {
    ob_start(); // Démarrer la mise en tampon pour capturer la sortie
    include 'data.php'; 
    $output = ob_get_clean(); // Récupérer le contenu de data.php et l'affecter à $output
}

echo $output;
