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
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                    include_once "../model/config.php";
                    $req = $bdd->prepare("SELECT * FROM users WHERE unique_id =:unique_id");
                    $req->execute(["unique_id"=>$_SESSION['unique_id']]);

                    if($req ->rowCount() > 0)
                    {
                        $row = $req->fetch(PDO::FETCH_ASSOC);
                    }
                ?>
                <div class="content">
                    <img src="../img/image_profil/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['nom'] . " ". $row['prenom']; ?></span>
                        <p><?php echo $row['statut']; ?></p>
                    </div>
                </div>
                <a href="#" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Commencer à discuter avec</span>
                <input type="text" placeholder="Rechercher un utilisateur">
                <button>Go</button>
            </div>        
            <div class="users-list">
                
            </div>
        </section>
    </div>

    <script src="../javascript/users.js"></script>
</body>
</html>