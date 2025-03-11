<?php
  session_start();

  // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
  if(!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
  }
?>

<?php
    require_once 'header.php';
?>

</head>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                    // Inclusion de la configuration pour la base de données
                    include_once "../model/config.php";

                    // Vérifier si 'user_id' est présent dans l'URL
                    if(isset($_GET['user_id'])) {
                        // Assainir la valeur de 'user_id'
                        $id = htmlspecialchars(htmlentities($_GET['user_id']));

                        // Requête SQL pour récupérer les informations de l'utilisateur
                        $req = $bdd->prepare("SELECT * FROM users WHERE unique_id = :unique_id");
                        $req->execute(["unique_id" => $id]);

                        // Si l'utilisateur existe dans la base de données
                        if($req->rowCount() > 0) {
                            // Récupérer les informations de l'utilisateur
                            $row = $req->fetch(PDO::FETCH_ASSOC);
                        } else {
                            // Si l'utilisateur n'est pas trouvé, redirige vers une page d'erreur ou une autre page
                            echo "Utilisateur non trouvé.";
                            exit();
                        }
                    } else {
                        // Si 'user_id' n'est pas défini dans l'URL, redirige vers une autre page
                        echo "ID utilisateur manquant.";
                        exit();
                    }
                ?>
                
                <!-- Bouton retour -->
                <a href="user.php" class="back-icon"><i>Retour</i></a>
                
                <!-- Affichage de l'image de profil de l'utilisateur -->
                <img src="../img/image_profil/<?php echo $row['img']; ?>" alt="">

                <!-- Détails de l'utilisateur -->
                <div class="details">
                    <span><?php echo $row['nom'] . " ". $row['prenom']; ?></span>
                    <p><?php echo $row['statut']; ?></p>
                </div>
            </header>
            
            <div class="chat-box">
                <!-- Messages de chat s'afficheront ici -->
            </div>
            
            <!-- Formulaire de saisie de message -->
            <form action="#" class="typing-area" method="post" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Entrez votre message ...">
                <button type="submit">Envoyer</button>
            </form>
        </section>
    </div>

    <!-- Inclusion du fichier JavaScript -->
    <script src="../javascript/chat.js"></script>
</body>
</html>
