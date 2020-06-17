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

    if(isset($_POST['admin-submit'])) {

        $nom = htmlspecialchars($_POST['admin-nom']);
        $prenom = htmlspecialchars($_POST['admin-prenom']);
        $email = htmlspecialchars($_POST['admin-email']);
        $phone = htmlspecialchars($_POST['admin-phone']);
        $password = htmlspecialchars($_POST['admin-password']);

        $data = [
            $nom,
            $prenom,
            $email,
            $phone,
            sha1($password),
            'AD',
            1
        ];

        if(getUserBy($email, 'email')) {
            //Email utilisé
            header('Location: ./../admin/admins.php?'. sha1('email-used'));
            die();
        }

        if(getUserBy($phone, 'telephone')) {
            //telephone utilisé
            header('Location: ./../admin/admins.php?'. sha1('phone-used'));
            die();
        }

        if(addAdmin($data)) {

            //Admin ajouté avec succes
            header('Location: ./../admin/admins.php?'. sha1('admin-added'));
            die();
            
        } else {
            
            //Probleme du serveur
            header('Location: ./../admin/admins.php?'. sha1('server-issues'));
            die();

        }

    } else {

        header('Location: ./../admin/admins.php');

    }

?>