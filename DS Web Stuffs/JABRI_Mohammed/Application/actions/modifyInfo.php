<?php

    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    session_start();
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    }

    if(isset($_POST['modify-nom']) && isset($_POST['modify-prenom']) && isset($_POST['modify-phone']) && isset($_POST['modify-email'])) {

        $nom = htmlspecialchars($_POST['modify-nom']);
        $prenom = htmlspecialchars($_POST['modify-prenom']);
        $phone = htmlspecialchars($_POST['modify-phone']);
        $email = htmlspecialchars($_POST['modify-email']);
        $type = htmlspecialchars($_POST['modify-type']);
        
        if($type == 'ET') {
            $num = htmlspecialchars($_POST['modify-cne']);
            $filiere = htmlspecialchars($_POST['modify-filiere']);
        } else {
            $num = htmlspecialchars($_POST['modify-ppr']);
        }

        if(getUserBy($email, 'email') && $email != $_SESSION['email']) {
            //EMail deja utilisé
            header('Location: ./../home/account.php?'. sha1('email_used'));
            die();
        }

        if(getUserBy($phone, 'telephone') && $phone != $_SESSION['telephone']) {
            //telephone deja utilisé
            header('Location: ./../home/account.php?'. sha1('phone_used'));
            die();
        }

        if($type == 'ET') {
    
            if(getStudentByCne($num) && $num != getStudentByEmail($_SESSION['email'])['cne']) {
                //CNE Deja utilisé
                header('Location: ./../home/account.php?'. sha1('cne_used'));
                die();
            }
        } else if($type == 'EN' || $type == 'FN') {

            if(getPersonnelByPPR($num) && $num != getPersonnelByEmail($_SESSION['email'])['ppr']) {
                //PPR Deja utilisé
                header('Location: ./../home/account.php?'. sha1('ppr_used'));
                die();
            }
        }


        $data = [
            $nom,
            $prenom,
            $phone,
            $email,
            $_SESSION['user_id']
        ];

        if(updateUser($_SESSION['user_id'], $data, $email, $type, $filiere, $num)) {
            //Informations modifiés avec succes
            header('Location: ./../home/account.php?'. sha1('info_updated'));
            die();
        } else {
            //Erreur du serveur
            header('Location: ./../home/account.php?'. sha1('server_issues'));
            die();
        }

    } else {
        header('Location: ./../home/home.php');
    }

?>