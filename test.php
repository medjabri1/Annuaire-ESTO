<?php

    require_once('./config/functions.php');
    session_start();
    
    $chaine = htmlspecialchars('<script>alert("test")</script>', ENT_HTML5);
    
    echo $chaine;

?>