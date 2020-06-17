<?php
    
    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    //Fichier qui contient les messages d'erreur / succes pour l'administrateur
    require_once('./../config/admin-messages.php');

    session_start();
    
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
    } else if(strtoupper($_SESSION['user_type']) != 'AD') {
        //Utilisateur ce n'est pas un administrateur
        header('Location: ./../home/home.php');
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

    //Les utilisateurs non verifiés
    $notVerifiedUsers = getNotVerifiedUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire ESTO - Nouveaux utilisateurs</title>
    <link rel="icon" href="./../icons/annuaire.png">
    <link rel="stylesheet" href="./../css/admin.css">
    <link rel="stylesheet" href="./../css/home.css">
</head>
<body>
    
    <!-- Bar de navigation principale -->
    <nav class="main-nav">

        <a href="./../home/home.php" class="nav-logo">
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
                <a href="./../home/home.php">Acceuil</a>
            </li>

            <li>
                <a href="./../scolarite/school.php">Scolarité</a>
            </li>

            <li class="active">
                <a href="./verify-users.php">Admin</a>
                <ul class="sub-menu">
                    <li>
                        <a href="./verify-users.php">Verifier les utlisateurs</a>
                    </li>
                    <li>
                        <a href="./users.php">Gérer les utilisateurs</a>
                    </li>
                    <li>
                        <a href="./admins.php">Les admins</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="./../home/account.php">Compte</a>
                <ul class="sub-menu">
                    <li>
                        <a href="./../home/account.php">Paramètres</a>
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

        <!-- Message d'erreur / succes -->
        <div class="messages">
            <?php if(isset($error)) : ?>
                
                <p class="error-messages" title="CLICK TO HIDE" onclick="deleteMessage(this)"><?= $error ?></p>
            
            <?php elseif(isset($succes)) : ?>
                
                <p class="succes-messages" title="CLICK TO HIDE" onclick="deleteMessage(this)"><?= $succes ?></p>
            
            <?php endif; ?>
        </div>

        <div class="verify-users">

            <h2 class="section-title">Les utilisateurs non verifiés 
                <span class="users-count">(<?= $notVerifiedUsers != null ? count($notVerifiedUsers) : '0' ?>)</span> : 
            </h2>

            <?php if($notVerifiedUsers == null) : ?>

                <p class="no-users">Pas de nouveaux utilisateurs inscrit</p>

            <?php else : ?>

                <div class="show-options">
                    <p>Afficher : </p>
                    <select id="show-choice" onchange="showUsers(this)">
                        <option value="T" selected>Tous</option>
                        <option value="ET">Etudiants</option>
                        <option value="EN">Enseignants</option>
                        <option value="FN">Fonctionnaires</option>
                    </select>
                </div>

                <table class="user-table">
                    <p class="table-no-users">Pas d'utilisateurs pour ce choix</p>
                    <thead>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Fonction</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Inscrit le</th>
                        <th>Decision</th>
                    </thead>
                    <tbody>
                        <?php foreach($notVerifiedUsers as $user) : ?>
                            
                            <tr>
                                <td data-label="Nom"><?= $user['nom'] ?></td>
                                <td data-label="Prenom"><?= $user['prenom'] ?></td>
                                <td data-label="Fonction" class="user-type" data-type="<?= $user['description'] ?>"><?= $userType[$user['description']] ?></td>
                                <td data-label="Email"><?= $user['email'] ?></td>
                                <td data-label="Telephone"><?= $user['telephone'] ?></td>
                                <td data-label="Inscrit le"><?= $user['created_at'] ?></td>
                                <td data-label="Action">
                                    <form action="./../actions/verifyUser.php" method="POST">
                                        <select name="verify-decision" required>
                                            <option></option>
                                            <option value="A">Accepter</option>
                                            <option value="R">Rejeter</option>
                                        </select>

                                        <input type="hidden" name="verify-id" value="<?= $user['user_id'] ?>">
                                        
                                        <input type="submit" name="verify-submit" value="Confirmer">
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>

        </div>
    </div>

    <script src="./../js/admin.js" defer></script>
</body>
</html>