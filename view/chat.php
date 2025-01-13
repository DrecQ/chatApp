<?php
  session_start();

  if(!isset($_SESSION['unique_id']))
  {
    header("location: login.php");
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
                    include_once "../model/config.php";
                    $id = htmlspecialchars(htmlentities($_GET['user_id']));
                    $req = $bdd->prepare("SELECT * FROM users WHERE unique_id =:unique_id");
                    $req->execute(["unique_id"=>$id]);

                    if($req ->rowCount() > 0)
                    {
                        $row = $req->fetch(PDO::FETCH_ASSOC);
                    }
                ?>
                    <a href="user.php" class="back-icon"><i>Retour</i></a>
                    <img src="../img/image_profil/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['nom'] . " ". $row['prenom']; ?></span>
                        <p><?php echo $row['statut']; ?></p>
                    </div>
            </header>
            <div class="chat-box">
                    
            </div>
            <form action="#" class="typing-area" method="post" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Entrez votre message ...">
                <button type="submit">Send</button>
            </form>
        </section>
    </div>

    <script src="../javascript/chat.js"></script>
</body>
</html>