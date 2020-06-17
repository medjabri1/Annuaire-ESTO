<?php

//Messages d'erreur passer sur le lien de la page
//sous forme d'une chaine hashe pour des raisons de securité

$errorType = '';

if(isset($_GET[sha1('server_issues')])) $error = 'Probleme du serveur merci de ressayer!';
    
if(isset($_GET[sha1('email_used')])) {
    $errorType = 'up';
    $signError = 'Adresse email entre est deja utilisé!';
}

if(isset($_GET[sha1('phone_used')])) {
    $errorType = 'up';
    $signError = 'Numero de telephone entre est deja utilisé!';
}

if(isset($_GET[sha1('cne_used')])) {
    $errorType = 'up';
    $signError = 'Numero de CNE entre est deja utilisé!';
}

if(isset($_GET[sha1('ppr_used')])) {
    $errorType = 'up';
    $signError = 'Numero de PPR entre est deja utilisé!';
}

if(isset($_GET[sha1('not_verified')])) {
    $errorType = 'in';
    $signError = "Votre compte n'est pas encore verifié!";
}

if(isset($_GET[sha1('wrong_password')])) { 
    $errorType = 'in';
    $signError = 'Le mot de passe entre est incorrecte!';
}

if(isset($_GET[sha1('email_not_found')])) {
    $errorType = 'in';
    $signError = "L'adresse email entre n'existe pas!";
}


?>