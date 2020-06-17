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

    if(isset($_POST['modify-dept-submit'])) {

        $dept_name = htmlspecialchars($_POST['modify-dept-name']);
        $dept_id = htmlspecialchars($_POST['modify-dept-id']);

        if(updateDepartement($dept_id, $dept_name)) {

            //Departement mis a jour avec succes
            header('Location: ./../scolarite/school.php?'. sha1('dept-updated'));
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