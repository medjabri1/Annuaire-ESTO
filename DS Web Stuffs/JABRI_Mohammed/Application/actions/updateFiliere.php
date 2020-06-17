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

    if(isset($_POST['modify-filiere-submit'])) {

        $filiere_id = htmlspecialchars($_POST['modify-filiere-id']);
        $filiere_name = htmlspecialchars($_POST['modify-filiere-name']);
        $dept_id = htmlspecialchars($_POST['modify-filiere-dept']);
        $filiere_desc = htmlspecialchars($_POST['modify-filiere-desc']);

        if(updatedFiliere($filiere_id, $filiere_name, $dept_id, $filiere_desc)) {

            //Filiere mis à jour avec succes
            header('Location: ./../scolarite/school.php?'. sha1('filiere-updated'));
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