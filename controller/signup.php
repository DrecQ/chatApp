<?php
session_start();
include_once '../model/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $req = $bdd->prepare("SELECT email FROM users WHERE email = :email");
            $req->execute(['email' => $email]);

            if ($req->rowCount() > 0) {
                echo "$email - Cette adresse mail existe déjà";
            } else {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $img_name = $_FILES['image']['name'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $img_size = $_FILES['image']['size'];

                    $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                    $extensions = ['png', 'jpeg', 'jpg'];

                    if (in_array($img_ext, $extensions)) {
                        if ($img_size < 2 * 1024 * 1024) { // 2MB max
                            $new_image_name = uniqid() . '.' . $img_ext;
                            $img_path = "../img/image_profil/" . $new_image_name;

                            if (move_uploaded_file($tmp_name, $img_path)) {
                                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                $random_id = rand(time(), 10000000);
                                $status = "Active now";

                                try {
                                    $insert = $bdd->prepare("INSERT INTO users (unique_id, nom, prenom, email, password, img, statut) 
                                            VALUES (:unique_id, :nom, :prenom, :email, :password, :img, :statut)");
                                    $insert->execute([
                                        'unique_id' => $random_id,
                                        'nom' => htmlspecialchars($nom),
                                        'prenom' => htmlspecialchars($prenom),
                                        'email' => $email,
                                        'password' => $hashed_password,
                                        'img' => $new_image_name,
                                        'statut' => $status
                                    ]);

                                    if ($insert) {
                                        $_SESSION['unique_id'] = $random_id;
                                        echo "success";
                                    }
                                } catch (PDOException $e) {
                                    echo "Erreur d'insertion : " . $e->getMessage();
                                }
                            } else {
                                echo "Échec de l'importation de l'image.";
                            }
                        } else {
                            echo "L'image est trop volumineuse (max 2MB).";
                        }
                    } else {
                        echo "Format d'image invalide (jpg, jpeg, png uniquement).";
                    }
                } else {
                    echo "Veuillez importer une image.";
                }
            }
        } else {
            echo "$email - Ceci n'est pas un email valide";
        }
    } else {
        echo "Veuillez remplir tous les champs !";
    }
}
