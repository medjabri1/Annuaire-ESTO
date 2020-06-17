<?php

    if(isset($_GET[sha1('server-issues')])) {
        $error = 'Probleme du serveur, Merci de ressayer!';
    }

    //les messages pour les filieres

    if(isset($_GET[sha1('filiere-added')])) {
        $succes = 'Filiere ajouté avec succes!';
    }

    if(isset($_GET[sha1('filiere-updated')])) {
        $succes = 'Filiere mis à jour avec succes!';
    }

    //Les messages pour les departements

    if(isset($_GET[sha1('dept-added')])) {
        $succes = 'Departement ajouté avec succes!';
    }

    if(isset($_GET[sha1('dept-updated')])) {
        $succes = 'Departement mis à jour avec succes!';
    }

?>