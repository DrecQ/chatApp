<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    
    include_once '../model/config.php';

    // Validate and sanitize input data
    if (isset($_POST['outgoing_id']) && isset($_POST['incoming_id'])) {
        $outgoing_id = (int) $_POST['outgoing_id']; // casting to integer
        $incoming_id = (int) $_POST['incoming_id'];
    } else {
        // Handle invalid input
        exit('Invalid input.');
    }
    
    $output = "";

    // Fixed SQL query with proper parameter binding
    $req = "SELECT * FROM messages
            LEFT JOIN users ON users.unique_id = messages.incoming_msg_id
            WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id) 
            OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id)";
    
    $stmt = $bdd->prepare($req);
    $stmt->execute([
        "outgoing_id" => $outgoing_id, 
        "incoming_id" => $incoming_id
    ]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                            </div>';
            }
        }

        echo $output;
    }

} else {
    header("Location: ../view/login.php");
    exit(); 
}
?>
