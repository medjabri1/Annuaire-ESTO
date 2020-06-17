<?php

    require_once('./../config/functions.php');

    session_start();

    if(!isset($_SESSION['user_id'])) {

        //Utlisateur non connecté
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

    //Utilisateur verifiés
    $verifiedUsers = getVerifiedUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire ESTO - <?= strtoupper($userType[$_SESSION['user_type']]) ?></title>
    <link rel="icon" href="./../icons/annuaire.png">
    <link rel="stylesheet" href="./../css/home.css">
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

            <li class="active">
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

            <li>
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

        <!-- Formulaire de recherche -->
        <div class="search-box">
            <form>
                <div>
                    <input type="text" id="search-string" placeholder="Clé de recherche..">
                    <select id="search-option">
                        <option value="E">Adresse email</option>
                        <option value="N" selected>Nom</option>
                        <option value="P">Prenom</option>
                        
                        <?php if($_SESSION['user_type'] != 'ET') : ?>
                            <option value="T">Telephone</option>
                        <?php endif; ?>
                    </select>
                </div>
                <input type="submit" value="Rechercher" id="search-button" onclick="searchUsers()">
            </form>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="users-list">

            <p class="search-count">
                Resultat de recherche 
                <span>(<?= $verifiedUsers != null ? count($verifiedUsers) : 0 ?>)</span>
            </p>

            <?php if($verifiedUsers != null) : ?>

                <table>

                    <thead>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Fonction</th>
                        <th>Email</th>
                        <!-- Numero de telephone ca va pas etre affiche aux etudiants -->
                        <?php if($_SESSION['user_type'] != 'ET') : ?>
                            <th>Telephone</th>
                        <?php endif; ?>
                    </thead>

                    <tbody>
                        <?php foreach($verifiedUsers as $user) : ?>

                            <!-- Pour ne pas afficher aussi l'utilisateur connecté dans la liste -->
                            <?php if($user['user_id'] == $_SESSION['user_id']) continue; ?>
                            <tr>
                                <td class="user-data-nom" data-label="Nom"><?= $user['nom'] ?></td>
                                <td class="user-data-prenom" data-label="Prenom"><?= $user['prenom'] ?></td>
                                <td data-label="Fonction"><?= $userType[$user['description']] ?></td>
                                <td class="user-data-email" data-label="Email"><?= $user['email'] ?></td>

                                <?php if($_SESSION['user_type'] != 'ET') : ?>
                                    <td class="user-data-phone" data-label="Telephone"><?= $user['telephone'] ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            <?php else : ?>

                <p class="no-users">Pas d'utilisateurs pour l'instant!</p>

            <?php endif; ?>

        </div>

    </div>

    <script src="./../js/search.js" defer></script>
    <script src="./../js/admin.js" defer></script>

</body>
</html>