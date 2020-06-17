<?php

    //Fichier qui contient tout les fonctions
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

    if(isset($_POST['filiere-submit'])) {

        $filiere_name = htmlspecialchars($_POST['filiere-name']);
        $dept_id = htmlspecialchars($_POST['filiere-dept']);
        $filiere_desc = htmlspecialchars($_POST['filiere-desc']);

        if(addFiliere($filiere_name, $dept_id, $filiere_desc)) {

            //Filiere ajouté avec succes
            header('Location: ./../scolarite/school.php?'. sha1('filiere-added'));
            die();
            
        } else {
            
            //Probleme du serveur
            header('Location: ./../scolarite/school.php?'. sha1('server-issues'));
            die();

        }

    } else {

        header('Location: ./../scolarite/school.php');

    }

?>