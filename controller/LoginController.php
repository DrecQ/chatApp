<?php
session_start();
include_once '../model/config.php';

if (!isset($_POST['email'], $_POST['password'])) {
    exit("Données manquantes.");
}

// Nettoyage et validation des entrées
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$password = trim($_POST['password']);

if (!$email || empty($password)) {
    exit("Remplissez tous les champs correctement !");
}

try {
    // Récupérer l'utilisateur avec l'email uniquement
    $req = $bdd->prepare("SELECT * FROM users WHERE email = :email");
    $req->execute(["email" => $email]);

    if ($req->rowCount() > 0) {
        $row = $req->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if (password_verify($password, $row['password'])) {
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        } else {
            echo "Vos identifiants sont incorrects !";
        }
    } else {
        echo "Vos identifiants sont incorrects !";
    }
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}
?>
