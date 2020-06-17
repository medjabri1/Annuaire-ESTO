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

        $admin_id = $_POST['action-id'];
        $decision = $_POST['action-decision'];

        $admin = getUserBy($admin_id);

        if($decision == 'S') {
            
            //Suppression d'utilisateur
            if(deleteAdmin($admin)) {
                //admin supprimé
                header('Location: ./../admin/admins.php?'. sha1('admin-deleted'));
                die();
            } else {
                //Probleme du serveur
                header('Location: ./../admin/admins.php?'. sha1('server-issues'));
                die();
            }
        }
        

    } else {

        //Redirection
        header('Location: ./../admin/admins.php');
        die();

    }

?>