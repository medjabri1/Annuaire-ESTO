<?php

    require_once('./../config/functions.php');
    session_start();

    if(!isset($_SESSION['user_id'])) {
        //Utilisateur n'est pas connecté
        header('Location: ./../index.php');
        die();
    } else if($_SESSION['user_type'] != 'AD') {
        //Utilisateur n'est pas un administrateur
        header('Location: ./../home/home.php');
        die();
    }

    if(isset($_POST['verify-submit'])) {

        $user_id = $_POST['verify-id'];
        $user = getUserBy($user_id);

        if($user['verified'] == '1') {
            //Utilisateur deja verifié
            header('Location: ./../admin/verify-users.php?'. sha1('already-verified'));
            die();
        }

        if($_POST['verify-decision'] == 'A') {
            
            //Accepter l'utilisateur
            if(verifyUser($user)) {
                //Utilisateur accepté
                header('Location: ./../admin/verify-users.php?'. sha1('user-verified'));
                die();
            } else {
                //Probleme du serveur
                header('Location: ./../admin/verify-users.php?'. sha1('server-issues'));
                die();
            }

        } else if($_POST['verify-decision'] == 'R') {

            //Rejeter l'utilisateur
            if(rejectUser($user)) {
                //Utilisateur rejeté
                header('Location: ./../admin/verify-users.php?'. sha1('user-rejected'));
                die();
            } else {
                //Probleme du serveur
                header('Location: ./../admin/verify-users.php?'. sha1('server-issues'));
                die();
            }

        }
        

    } else {
        header('Location: ./../admin/verify-users.php');
        die();
    }

?>