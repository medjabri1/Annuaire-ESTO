<?php

    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    //Fichier qui contient les messages d'erreurs / succes
    require_once('./../config/modify-messages.php');

    session_start();
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    }

    //Type d'utilisateur
    $userType = [
        'ET' => 'Etudiant',
        'EN' => 'Enseignant',
        'FN' => 'Fonctionnaire',
        'AD' => 'Admin'
    ];

    //Deconnexion
    if(isset($_POST['logout'])) {

        session_destroy();
        header('Location: ./../index.php');
    }

    //Tous les filieres
    $filieres = getAllFilieres();

    //Utilisateur connecté
    $user = getUserBy($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètre : <?= $userType[$_SESSION['user_type']] ?> - <?= $_SESSION['nom'] ?></title>
    <link rel="icon" href="./../icons/annuaire.png">
    <link rel="stylesheet" href="./../css/home.css">
    <link rel="stylesheet" href="./../css/account.css">
</head>
<body>
    
    <!-- Bar de navigation principale -->
    <nav class="main-nav">

        <a href="./home.php" class="nav-logo">
            <img src="./../icons/annuaire.png">
            <h2>Annuaire<span>ESTO</span></h2>
        </a>

        <!-- Boutton d'affichage du menu responsive -->
        <span class="nav-toggler" onclick="showModal(this)" data-modal="menu">
            <img src="./../icons/menu.png">
        </span>

        <ul class="nav-menu modal" data-modal-name="menu">

            <!-- Boutton de fermeture du menu responsive -->
            <span class="modal-close-button">+</span>

            <li>
                <a href="./home.php">Acceuil</a>
            </li>

            <!-- Menu pour l'admin / les enseignants -->
            <?php if($_SESSION['user_type'] == 'AD' || $_SESSION['user_type'] == 'EN') : ?>
                <li>
                    <a href="./../scolarite/school.php">Scolarité</a>
                </li>
            <?php endif; ?>

            <!-- Menu Juste pour l'Admin -->
            <?php if($_SESSION['user_type'] == 'AD') : ?>
                <li>
                    <a href="./../admin/verify-users.php">Admin</a>
                    <ul class="sub-menu">
                        <li>
                            <a href="./../admin/verify-users.php">Verifier les utlisateurs</a>
                        </li>
                        <li>
                            <a href="./../admin/users.php">Gérer les utilisateurs</a>
                        </li>
                        <li>
                            <a href="./../admin/admins.php">Les admins</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="active">
                <a href="./account.php">Compte</a>
                <ul class="sub-menu">
                    <li>
                        <a href="./account.php">Paramètres</a>
                    </li>
                    <li>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <input type="submit" name="logout" value="Deconnecter">
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="container"> 
        
        <!-- Parametre du compte -->
        <div class="settings">

            <div class="alert-messages">
                <?php if(strlen($error) && $errorType != '') : ?>
                    <p class="error-message" title="CLICK TO HIDE" onclick="deleteMessage(this)"><?= $error ?></p>
                <?php endif; ?>

                <?php if(strlen($succes)) : ?>
                    <p class="succes-message" title="CLICK TO HIDE" onclick="deleteMessage(this)"><?= $succes ?></p>
                <?php endif; ?>
            </div>

            <h1 class="settings-title">
                Compte : <?= $userType[$_SESSION['user_type']] ?> - <span><?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?></span>
            </h1>

            <div class="modify-options">
                <h2 class="modify-choices <?= $errorType == 'D' || $errorType == '' ? 'active' : '' ?>" onclick="showModifyForm(this)" data-form="data">
                    Données personnelles
                </h2>
                <hr>
                <h2 class="modify-choices <?= $errorType == 'P' ? 'active' : '' ?>" onclick="showModifyForm(this)" data-form="password">
                    Mot de passe
                </h2>
            </div>
            
            <!-- Formulaire de modification des données personnels -->
            <form action="./../actions/modifyInfo.php" method="POST" class="modify-form personnal-data <?= $errorType == 'D' || $errorType == '' ? 'active' : '' ?>" id="modify-data">

                <div class="sub-form">
                    <div>
                        <label for="modify-nom">Nom :</label>
                        <input type="text" name="modify-nom" id="modify-nom" value="<?= $user['nom'] ?>">
                    </div>
                    <div>
                        <label for="modify-prenom">Prenom :</label>
                        <input type="text" name="modify-prenom" id="modify-prenom" value="<?= $user['prenom'] ?>">
                    </div>
                </div>

                <div class="sub-form">
                    <div>
                        <label for="modify-phone">Telephone :</label>
                        <input type="number" name="modify-phone" id="modify-phone"  value="<?= $user['telephone'] ?>">
                    </div>
                    <div>
                        <label for="modify-email">Adresse Email :</label>
                        <input type="email" name="modify-email" id="modify-email"  value="<?= $user['email'] ?>">
                    </div>
                </div>

                <div class="sub-form">

                    <!-- Pour l'etudiant -->
                    <?php if($_SESSION['user_type'] == 'ET') : ?>

                        <!-- La filiere / CNE de l'etudiant connecté -->
                        <?php
                            $filiere_id = getStudentByEmail($_SESSION['email'])['filiere_id'];
                            $cne = getStudentByEmail($_SESSION['email'])['cne'];
                        ?>
                        
                        <div>
                            <label for="modify-cne">CNE :</label>
                            <input type="text" name="modify-cne" id="modify-cne" value="<?= $cne ?>">
                        </div>
                        <div>
                            <label for="modify-filiere">Filiere :</label>
                            <select name="modify-filiere" id="modify-filiere">

                                <?php foreach($filieres as $filiere) : ?>
                                <option value="<?= $filiere['filiere_id'] ?>" <?= $filiere_id == $filiere['filiere_id'] ? 'selected' : '' ?>>
                                    <?= $filiere['filiere_name'] ?>
                                </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        
                    <!-- Pour les personnels -->
                    <?php elseif($_SESSION['user_type'] == 'EN' || $_SESSION['user_type'] == 'FN') : ?>

                        <!-- PPR de l'utilisateur conncté -->
                        <?php $ppr = getPersonnelByEmail($_SESSION['email'])['ppr']; ?>

                        <div>
                            <label for="modify-ppr">Numero PPR :</label>
                            <input type="number" name="modify-ppr" id="modify-ppr" value="<?= $ppr ?>">
                        </div>

                    <?php endif; ?>
                </div>

                <div class="sub-form">
                    <div>
                        <input type="hidden" name="modify-type" id="modify-type" value="<?= $user['description'] ?>">
                        <input type="submit" value="Modifier" name="modify-submit" onclick="verifyModifyForm('data')">
                    </div>
                </div>

                <div class="sub-form">
                    <div>
                        <p id="modify-errors">
                            <?php
                                if($errorType == 'D') echo $error;
                            ?>
                        </p>
                    </div>
                </div>

            </form>

            <form action="./../actions/modifyPassword.php" method="POST" class="modify-form password <?= $errorType == 'P' ? 'active' : '' ?>" id="modify-password">

                <div class="sub-form">
                    <div>
                        <label for="passwprd-old">Mot de passe actuel :</label>
                        <input type="password" name="password-old" id="password-old">
                    </div>
                </div>
                <div class="sub-form">
                    <div>
                        <label for="password-new">Nouveau mot de passe :</label>
                        <input type="password" name="password-new" id="password-new">
                    </div>
                </div>
                <div class="sub-form">
                    <div>
                        <label for="password-confirm">Confirmation :</label>
                        <input type="password" name="password-confirm" id="password-confirm">
                    </div>
                </div>
                <div class="sub-form">
                    <div>
                        <input type="submit" name="password-submit" id="password-submit" value="Valider" onclick="verifyModifyForm('password')">
                    </div>
                </div>
                <div class="sub-form">
                    <div>
                        <p id="password-errors">
                            <?php
                                if($errorType == 'P') echo $error;
                            ?>
                        </p>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script src="./../js/main.js" defer></script>
    <script src="./../js/admin.js" defer></script>
</body>
</html>