<?php

    require_once('./../config/functions.php');

    session_start();

    if(isset($_SESSION['user_id'])) {

        //Session deja ouverte --> Redirection
        header('Location: ./../home/home.php');
        die();
    }

    //Verfifier si tous les champs ne sont pas vides
    if ( isset($_POST['signin-email']) || isset($_POST['signin-password'])) {

        $email = htmlspecialchars($_POST['signin-email']);
        $password = htmlspecialchars($_POST['signin-password']);

        //Chek if email exists
        if(getUserBy($email, 'email')) {

            //Email trouvé
            $user = getUserBy($email, 'email');
            
            if($user['password'] == sha1($password)) {

                //Mot de passe correcte
                if($user['verified'] == 1 || strtoupper($user['description']) == 'AD') {

                    //Utilisateur verifié
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['telephone'] = $user['telephone'];
                    $_SESSION['user_type'] = $user['description'];

                    header('Location: ./../home/home.php');
                    die();

                } else {

                    //Utilisateur non verifié
                    header('Location: ./../index.php?'. sha1('not_verified'));
                    die();
                }
            } else {

                //Mot de passe incorrecte
                header('Location: ./../index.php?'. sha1('wrong_password'));
                die();
            }
        } else {

            //Email introuvable
            header('Location: ./../index.php?'. sha1('email_not_found'));
            die();
        }
        
    }

?>