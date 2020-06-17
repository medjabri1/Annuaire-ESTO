<?php

    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    session_start();

    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    }

    if(isset($_POST['password-old']) && isset($_POST['password-new']) && isset($_POST['password-confirm'])) {

        $user = getUserBy($_SESSION['user_id']);

        if(sha1($_POST['password-old']) != $user['password']) {
            //Mot de passe entree est incorrecte
            header('Location: ./../home/account.php?'. sha1('wrong_password'));
            die();
        }

        if(updatePassword($_SESSION['user_id'], sha1(htmlspecialchars($_POST['password-new'])))) {
            //Mot de passe changé avec succe
            header('Location: ./../home/account.php?'. sha1('password_updated'));
            die();

        } else {
            //Probleme du serveur
            header('Location: ./../home/account.php?'. sha1('server_issues'));
            die();
        }

    } else {

        header('Location: ./../home/home.php');
        die();

    }

?>