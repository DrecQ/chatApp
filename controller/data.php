<?php

$output = ''; // Initialisation

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Protection contre XSS
    $nom = htmlspecialchars($row['nom']);
    $prenom = htmlspecialchars($row['prenom']);
    $unique_id = htmlspecialchars($row['unique_id']);
    $img = !empty($row['img']) ? htmlspecialchars($row['img']) : 'default.jpg';

    $output .= '
        <a href="chat.php?user_id=' . $unique_id . '">
            <div class="content">
                <img src="../img/image_profil/' . $img . '" alt="Photo de profil">
                <div class="details">
                    <span>' . $nom . ' ' . $prenom . '</span>
                    <p>Ceci est un message test</p>
                </div>
            </div>
            <div class="status-dot"><i>ON</i></div>
        </a>';
}
