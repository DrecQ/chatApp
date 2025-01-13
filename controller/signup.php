<?php
session_start();
include_once '../model/config.php';

$nom = htmlspecialchars(htmlentities($_POST['nom']));
$prenom = htmlspecialchars(htmlentities($_POST['prenom']));
$email = htmlspecialchars(htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'));
$password = htmlspecialchars(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'));

if(!empty($nom) && !empty($prenom) && !empty($email) && !empty($password))
{
    //Verification de l'email
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        //Vérifions si l'émail existe déjà dans la base de données
        $req = $bdd->prepare("SELECT email FROM users WHERE email = :email");
        $req->execute(['email' => $email]);

        if($req->rowCount() > 0)
        {
            echo "$email - Cette adresse mail existe déjà";
        }else{
            //Vérifions l'envoi de l'image
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
            {
                $img_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];

                //Gestion des extensions
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ['png', 'jpeg', 'jpg'];
                if(in_array($img_ext, $extensions) === true)
                { 
                    //Gestion du temps de création
                    $time = time();

                    //Deplacement de l'image vers le dossier de stockage
                    $new_image_name = $time.'_'.$img_name;
                    
                    if(move_uploaded_file($tmp_name, "../img/image_profil/". $new_image_name))
                    {
                            //Cryptage du mot de passe
                            //$pass = password_hash($password, PASSWORD_BCRYPT);

                            //Creation d'un identifiant unique aux utilisateurs
                            $random_id = rand(time(), 10000000);

                             // Gestion du statut 
                             $status = "Active now";


                            //Insertion des informations des utilisateurs

                            $insert = $bdd ->prepare("INSERT INTO users(unique_id, nom, prenom, email, password, img, statut)
                                                                  VALUES(:unique_id, :nom, :prenom, :email, :password, :img, :statut)");
                            $insert->execute([
                                'unique_id' => $random_id,
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'password' => $password,
                                'img' => $new_image_name,
                                'statut' => $status
                            ]);


                            if($insert)
                            {
                                $requete = $bdd ->prepare("SELECT * FROM users WHERE email =:email ");
                                $requete ->execute(['email' => $email]);

                                if($requete-> rowCount() > 0)
                                {
                                    $row = $requete->fetch(PDO::FETCH_ASSOC);
                                    $_SESSION['unique_id'] = $row['unique_id'];

                                    echo "success";
                                }

                            }else{
                                echo "Vos informations sont incorrectes";
                            }
                    }

                  

                }else{
                    echo "Choisissez une image au format jpg, jpeg, png";
                }

            }else{
                echo "Veuillez importer une image";
            }
        }

    }else{
        echo "$email. Ceci n'est pas un email valide";
    }

}else{
    echo "Veuillez remplir tous les champs !";
}