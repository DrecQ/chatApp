<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once '../model/config.php';

    // Vérification des données POST
    if (!isset($_POST['outgoing_id'], $_POST['incoming_id'])) {
        exit('Données manquantes.');
    }

    // Validation et assainissement des entrées
    $outgoing_id = filter_var($_POST['outgoing_id'], FILTER_VALIDATE_INT);
    $incoming_id = filter_var($_POST['incoming_id'], FILTER_VALIDATE_INT);

    if (!$outgoing_id || !$incoming_id) {
        exit('Identifiants invalides.');
    }

    $output = "";

    // Requête SQL sécurisée
    $req = "SELECT * FROM messages 
            WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id) 
            OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id)
            ORDER BY id ASC"; // Trier les messages dans l'ordre chronologique

    $stmt = $bdd->prepare($req);
    $stmt->execute([
        "outgoing_id" => $outgoing_id,
        "incoming_id" => $incoming_id
    ]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $msg = htmlspecialchars($row['msg']); // Protection XSS

            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $msg . '</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>' . $msg . '</p>
                                </div>
                            </div>';
            }
        }
    } else {
        $output = '<p class="no-message">Aucun message pour cette conversation.</p>';
    }

    echo $output;

} else {
    header("Location: ../view/login.php");
    exit();
}
?>
