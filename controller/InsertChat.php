<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once '../model/config.php';

    // Sanitize and validate input data
    $outgoing_id = htmlspecialchars(htmlentities($_POST['outgoing_id']));
    $incoming_id = htmlspecialchars(htmlentities($_POST['incoming_id']));
    $message = htmlspecialchars(htmlentities($_POST['message']));

    if (!empty($message)) {
        // Préparer la requête d'insertion
        $req = "INSERT INTO messages(incoming_msg_id, outgoing_msg_id, msg)
                VALUES (:incoming_msg_id, :outgoing_msg_id, :msg)";
        
        // Préparer et exécuter la requête
        $stmt = $bdd->prepare($req);
        $stmt->execute([
            "incoming_msg_id" => $incoming_id, 
            "outgoing_msg_id" => $outgoing_id, 
            "msg" => $message
        ]);
    } else {
        echo "Message vide.";
    }
} else {
    header("Location: ../view/login.php");
    exit(); 
}
?>
