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

    if(isset($_POST['dept-submit'])) {

        $dept_name = htmlspecialchars($_POST['dept-name']);

        if(addDepartement($dept_name)) {

            //Departement ajouté avec succes
            header('Location: ./../scolarite/school.php?'. sha1('dept-added'));
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