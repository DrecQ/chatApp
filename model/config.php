<?php

    $dbname = 'chatApp';
    $user = 'root';
    $password = '';

    try
    {
        $bdd = new PDO("mysql:host=localhost;dbname=$dbname", $user, $password);

        $bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connexion réussie';
    }
    catch(Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

