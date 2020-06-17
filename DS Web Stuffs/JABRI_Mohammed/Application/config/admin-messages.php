<?php

    //les utilisateurs pas encore verifiés

    if(isset($_GET[sha1('already-verified')])) {
        $error = 'Ce utilisateur est deja verifié!';
    }

    if(isset($_GET[sha1('server-issues')])) {
        $error = 'Probleme du serveur merci de ressayer!';
    }

    if(isset($_GET[sha1('user-verified')])) {
        $succes = 'Utilisateur verifié avec succes!';
    }

    if(isset($_GET[sha1('user-rejected')])) {
        $succes = 'Utilisateur rejeté avec succes!';
    }

    //Les utilisateurs deja verifiés

    if(isset($_GET[sha1('user-deleted')])) {
        $succes = 'Utilisateur supprimé avec succes!';
    }

    if(isset($_GET[sha1('user-unverified')])) {
        $succes = 'Utilisateur unverifié avec succes!';
    }

    if(isset($_GET[sha1('user-notverified')])) {
        $error = 'Utilisateur pas encore verifié!';
    }
    
    //Administrateurs
    
    if(isset($_GET[sha1('admin-added')])) {
        $succes = 'Administrateur ajouté!';
    }

    if(isset($_GET[sha1('email-used')])) {
        $error = 'Email déjà utilisé par un autre utilisateur!';
        $newAdminError = 1;
    }
    
    if(isset($_GET[sha1('phone-used')])) {
        $error = 'Telephone déjà utilisé par un autre utilisateur!';
        $newAdminError = 1;
    }
    
    if(isset($_GET[sha1('admin-deleted')])) {
        $succes = 'Administrateur supprimé avec succés!';
    }

?>