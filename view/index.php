<?php
    require_once 'header.php';
?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat en ligne</header>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label for="">Votre nom</label>
                        <input type="text" placeholder="Entrez votre nom" name="nom" id="nom" required>
                    </div>
                    <div class="field input">
                        <label for="">Votre prenom</label>
                        <input type="text" placeholder="Entrez votre prenom" name="prenom" id="prenom" required>
                    </div>
                </div>
                <div class="field input">
                    <label for="">Votre email</label>
                    <input type="email" placeholder="Entrez votre email" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label for="">Votre mot de passe</label>
                    <input type="password" placeholder="Entrez votre mot de passe" name="password" id="password" required>
                </div>
                <div class="field image">
                    <label for="">Choisissez une photo de profil</label>
                    <input type="file" name="image">
                </div>
                <div class="field button">
                    <input type="submit" value="Continuer vers le chat" name="Envoyer">
                </div>
            </form>
            <div class="link">Déjà inscrit ? <a href="../index.php">Se connecter</a></div>
        </section>
    </div>

    <script src="../javascript/sign.js"></script>
</body>
</html>