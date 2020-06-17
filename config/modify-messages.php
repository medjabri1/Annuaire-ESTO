<?php

    $errorType = $error = $succes = '';

    if(isset($_GET[sha1('info_updated')])) {
        $succes = 'Les informations sont mis à jour!';
    }

    if(isset($_GET[sha1('email_used')])) {
        $error = 'Adresse email deja utilisé!';
        $errorType = 'D';
    }

    if(isset($_GET[sha1('phone_used')])) {
        $error = 'Numero du telephone deja utilisé!';
        $errorType = 'D';
    }

    if(isset($_GET[sha1('cne_used')])) {
        $error = 'CNE deja utilisé!';
        $errorType = 'D';
    }

    if(isset($_GET[sha1('ppr_used')])) {
        $error = 'Numero PPR deja utilisé!';
        $errorType = 'D';
    }

    if(isset($_GET[sha1('server_issues')])) {
        $error = 'Probleme du serveur merci de ressayer!';
        $errorType = 'D';
    }

    if(isset($_GET[sha1('wrong_password')])) {
        $error = 'Mot de passe entree est incorrecte!';
        $errorType = 'P';
    }

    if(isset($_GET[sha1('password_updated')])) {
        $succes = 'Mot de passe est mis à jour avec succes!';
        $errorType = 'P';
    }


?>