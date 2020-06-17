<?php

    require_once('./../config/functions.php');

    session_start();

    if(isset($_SESSION['user_id'])) {

        //Session deja ouverte --> Redirection
        header('Location: ./../home/home.php');
        die();
    }

    //Verfifier si tous les champs ne sont pas vides
    if (
        isset($_POST['signup-nom']) || isset($_POST['signup-prenom']) || 
        isset($_POST['signup-phone']) || isset($_POST['signup-email']) ||
        isset($_POST['signup-password']) || isset($_POST['signup-type'])
    ) {

        $nom = htmlspecialchars($_POST['signup-nom']);
        $prenom = htmlspecialchars($_POST['signup-prenom']);
        $phone = htmlspecialchars($_POST['signup-phone']);
        $email = htmlspecialchars($_POST['signup-email']);
        $password = htmlspecialchars($_POST['signup-password']);
        $type = htmlspecialchars($_POST['signup-type']);
        $filiere = htmlspecialchars($_POST['signup-filiere']);
        $cne = htmlspecialchars($_POST['signup-cne']);
        $ppr = htmlspecialchars($_POST['signup-ppr']);

        if($type == 'ET') {
            $num = htmlspecialchars($cne);
        } else {
            $num = htmlspecialchars($ppr);
        }

        //Chek if email exists
        if(getUserBy($email, 'email')) {

            //Email deja utilisé
            header('Location: ./../index.php?'. sha1('email_used'));
            die();
        }

        //Check if phone number exists
        if(getUserBy($phone, 'telephone')) {

            //Numero telephone deja utilisé
            header('Location: ./../index.php?'. sha1('phone_used'));
            die();
        }

        //chekc if cne is used
        if(getStudentByCne($cne)) {

            //CNE Deja utilisé
            header('Location: ./../index.php?'. sha1('cne_used'));
            die();
        }

        //check if ppr is used
        if(getPersonnelByPPR($ppr)) {

            //PPR Deja utilisé
            header('Location: ./../index.php?'. sha1('ppr_used'));
            die();
        }

        $data = [
            $nom,
            $prenom,
            $phone,
            $email,
            sha1($password),
            $type
        ];

        if(adduser($data, $type, $email, $num, $filiere)) {

            //Utilisateur ajouté
            header('Location: ./../index.php?'. sha1('user_signup_succes'));
            die();
            
        } else {

            //Probleme de serveur
            header('Location: ./../index.php?'. sha1('server_issues'));
            die();
            
        }
        
    }

?>