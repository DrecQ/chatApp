<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once '../model/config.php';

    // Vérification de la présence des données POST
    if (!isset($_POST['outgoing_id'], $_POST['incoming_id'], $_POST['message'])) {
        exit("Données manquantes.");
    }

    // Validation et assainissement des entrées
    $outgoing_id = filter_var($_POST['outgoing_id'], FILTER_VALIDATE_INT);
    $incoming_id = filter_var($_POST['incoming_id'], FILTER_VALIDATE_INT);
    $message = trim($_POST['message']); // Supprime les espaces inutiles

    if (!$outgoing_id || !$incoming_id) {
        exit("Identifiants invalides.");
    }

    if (empty($message)) {
        exit("Message vide.");
    }

    try {
        // Requête préparée pour insérer le message
        $req = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) 
                VALUES (:incoming_id, :outgoing_id, :msg)";

        $stmt = $bdd->prepare($req);
        $success = $stmt->execute([
            "incoming_id" => $incoming_id,
            "outgoing_id" => $outgoing_id,
            "msg" => $message
        ]);

        if ($success) {
            echo "Message envoyé.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }
} else {
    header("Location: ../view/login.php");
    exit();
}
?>
