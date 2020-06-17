<?php

    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    session_start();
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    } else if($_SESSION['user_type'] != 'AD') {
        //Utilisateur n'est pas un administrateur
        header('Location: ./../home/home.php');
        die();
    }

    if(isset($_POST['action-submit'])) {

        $user_id = $_POST['action-id'];
        $decision = $_POST['action-decision'];

        $user = getUserBy($user_id);

        if($decision == 'U') {

            if($user['verified'] == '0') {
                //Utilisateur pas encore verifié
                header('Location: ./../admin/users.php?'. sha1('user-notverified'));
                die();
            }

            //Unverification d'utilisateur
            if(unverifyUser($user)) {
                //Utilisateur unverifié
                header('Location: ./../admin/users.php?'. sha1('user-unverified'));
                die();
            } else {
                //Probleme du serveur
                header('Location: ./../admin/users.php?'. sha1('server-issues'));
                die();
            }
        }

        if($decision == 'S') {
            
            //Suppression d'utilisateur
            if(rejectUser($user)) {
                //Utilisateur supprimé
                header('Location: ./../admin/users.php?'. sha1('user-deleted'));
                die();
            } else {
                //Probleme du serveur
                header('Location: ./../admin/users.php?'. sha1('server-issues'));
                die();
            }
        }
        

    } else {

        //Redirection
        header('Location: ./../admin/users.php');
        die();

    }

?>