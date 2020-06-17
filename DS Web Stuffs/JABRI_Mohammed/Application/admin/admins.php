<?php

    //Fichier qui contient les focntions
    require_once('./../config/functions.php');

    //Fichier qui contient les messages d'erreur / succes pour l'administrateur
    require_once('./../config/admin-messages.php');

    session_start();
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    } else if($_SESSION['user_type'] != 'AD') {
        //Utilisateur n'est pas un administrateur
        header('Location: ./../home/home.php');
        die();
    }

    //Deconnexion
    if(isset($_POST['logout'])) {

        session_destroy();
        header('Location: ./../index.php');
    }

    //les utilisateur dèja verifiés
    $admins = getAllAdmins();

    //Pour supprimer l'admin connecté de la liste affichée
    for($i = 0; $i < count($admins); $i++) {
        if($admins[$i]['email'] == $_SESSION['email']) {
            unset($admins[$i]);
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire ESTO - Administrateurs</title>
    <link rel="icon" href="./../icons/annuaire.png">
    <link rel="stylesheet" href="./../css/admin.css">
    <link rel="stylesheet" href="./../css/school.css">
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

        <!-- Boutton d'affichage de la fenetre flottante d'ajout d'un nouvau admin -->
        <div class="add-buttons-box">
            <h2 data-modal="new-admin" onclick="showModal(this)">Ajouter nouveau administrateur</h2>
        </div>

        <!-- Fenetre flottantes d'ajout d'un admin -->
        <div class="modal float <?= isset($newAdminError) ? 'active' : '' ?>" data-modal-name="new-admin">
            <form action="./../actions/addAdmin.php" method="POST">
                <p>Ajouter une nouveau adminstrateur</p>

                <label for="admin-nom">Nom</label>
                <input type="text" name="admin-nom" id="admin-nom" placeholder="Exemple: JABRI" required>

                <label for="admin-prenom">Prenom</label>
                <input type="text" name="admin-prenom" id="admin-prenom" placeholder="Exemple: Mohammed" required>
                
                <label for="admin-email">Email</label>
                <input type="email" name="admin-email" id="admin-email" placeholder="Exemple: admin@gmail.com" required>

                <label for="admin-phone">Telephone</label>
                <input type="number" name="admin-phone" id="admin-phone" placeholder="Exemple: 0XX-XXX-XXXX" required>

                <label for="admin-password">Mot de passe</label>
                <input type="password" name="admin-password" id="admin-password" required>

                <input type="submit" value="Ajouter" name="admin-submit">
            </form>
            <span class="modal-close-button">+</span>
        </div>

        <div class="verified-users">

            <h2 class="section-title">Les administrateurs
                <span class="users-count">(<?= $admins != null ? count($admins) : '0' ?>)</span> : 
            </h2>

            <?php if($admins == null) : ?>

                <p class="no-users">Pas d'autres administrateurs</p>

            <?php else : ?>

                <table class="user-table">
                    <thead>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Ajoutée le</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach($admins as $admin) : ?>
                            
                            <tr>
                                <td data-label="Nom"><?= $admin['nom'] ?></td>
                                <td data-label="Prenom"><?= $admin['prenom'] ?></td>
                                <td data-label="Email"><?= $admin['email'] ?></td>
                                <td data-label="Telephone"><?= $admin['telephone'] ?></td>
                                <td data-label="Inscrit le"><?= $admin['created_at'] ?></td>
                                <td data-label="Action">
                                    <form action="./../actions/actionAdmin.php" method="POST">
                                        <select name="action-decision" required>
                                            <option></option>
                                            <option value="S">Supprimer</option>
                                        </select>

                                        <input type="hidden" name="action-id" value="<?= $admin['user_id'] ?>">
                                        
                                        <input type="submit" name="action-submit" value="Valider">
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