<?php

    while($row = $stmt ->fetch(PDO::FETCH_ASSOC))
    {
        $output .='
            <a href="chat.php?user_id='.$row['unique_id'].'">
                    <div class="content">
                        <img src="../img/image_profil/'.$row['img'].'" alt="">
                        <div class="details">
                            <span>'.$row['nom'].' '.$row['prenom'].'</span>
                            <p>Ceci est un message test</p>
                        </div>
                    </div>
                    <div class="status-dot"><i>ON</i></div>
                </a>';
    }



