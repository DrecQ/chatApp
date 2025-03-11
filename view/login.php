<?php
    // Assurez-vous que la session a démarré
    session_start();

    // Si l'utilisateur est déjà connecté, on le redirige vers la page de chat
    if (isset($_SESSION['unique_id'])) {
        header("Location: view/chat.php?user_id=" . $_SESSION['unique_id']);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat en ligne</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Chat en ligne</header>
            <form id="login-form" method="post">
                <div class="error-txt" style="display: none;"></div> <!-- Initialement caché -->
                <div class="field input">
                    <label for="email">Votre email</label>
                    <input type="email" placeholder="Entrez votre email" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label for="password">Votre mot de passe</label>
                    <input type="password" placeholder="Entrez votre mot de passe" name="password" id="password" required>
                </div>
                <div class="field button">
                    <input type="submit" value="Continuer vers le chat">
                </div>
            </form>
            <div class="link">Sans compte ? <a href="view/index.php">S'inscrire</a></div>
        </section>
    </div>

    <script src="javascript/login.js"></script>
</body>
</html>
