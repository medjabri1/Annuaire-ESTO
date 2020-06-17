<?php

    //Fichier qui contient les fonctions
    require_once('./../config/functions.php');

    //Fichier qui contient les messages d'erreurs / succes
    require_once('./../config/school-messages.php');

    session_start();
    if(!isset($_SESSION['user_id'])) {
        //Utilisateur non connecté
        header('Location: ./../index.php');
        die();
    } else if($_SESSION['user_type'] != 'AD' && $_SESSION['user_type'] != 'EN') {
        //Utilisateur n'est pas un administrateur / n'est pas un enseignant
        header('Location: ./../home/home.php');
        die();
    }

    //Deconnexion
    if(isset($_POST['logout'])) {

        session_destroy();
        header('Location: ./../index.php');
    }

    //Tous les filieres
    $filieres = getAllFilieres();

    //Tous les departement
    $departements = getAllDepartements();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire ESTO - Administration</title>
    <link rel="icon" href="./../icons/annuaire.png">
    <link rel="stylesheet" href="./../css/home.css">
    <link rel="stylesheet" href="./../css/school.css">
    <link rel="stylesheet" href="./../css/admin.css">
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
            
            <li class="active">
                <a href="./school.php">Scolarité</a>
            </li>

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

        <!-- Bouttons d'affichages des formulaires d'ajout d'une filiere / departement -->
        <!-- Ces liens sont affiché juste pour l'admin -->
        <?php if($_SESSION['user_type'] == 'AD') : ?>
            <div class="add-buttons-box">
                <h2 data-modal="filiere" onclick="showModal(this)">Ajouter filiere</h2>
                <h2 data-modal="dept" onclick="showModal(this)">Ajouter departement</h2>
            </div>
        <?php endif; ?>

        <!-- Ces fenetres flottantes d'ajout et de modification de filiere / departement sont disponibles juste pour l'admin -->
        <?php if($_SESSION['user_type'] == 'AD') : ?>
        
            <!-- Fenetre flottantes d'ajout d'une filiere -->
            <div class="modal float" data-modal-name="filiere">
                <form action="./../actions/addFiliere.php" method="POST">
                    <p>Ajouter une nouvelle filiere</p>

                    <label for="filiere-name">Nom</label>
                    <input type="text" name="filiere-name" id="filiere-name" placeholder="Exemple: DAI" required>

                    <label for="filiere-dept">Departement</label>
                    <select name="filiere-dept" id="filiere-dept" required>
                        <?php foreach($departements as $dept) : ?>
                            <option value="<?= $dept['dept_id'] ?>"><?= $dept['dept_name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="filiere-desc">Description</label>
                    <textarea name="filiere-desc" id="filiere-desc" rows="3" placeholder="Exemple: Developpeur d'Applications Informatiques" required></textarea>

                    <input type="submit" value="Ajouter" name="filiere-submit">
                </form>
                <span class="modal-close-button">+</span>
            </div>

            <!-- Fenetre flottantes d'ajout d'un departement -->
            <div class="modal float" data-modal-name="dept">
                <form action="./../actions/addDept.php" method="POST">
                    <p>Ajouter un nouveau departement</p>

                    <label for="dept-name">Nom</label>
                    <input type="text" name="dept-name" id="dept-name" placeholder="Exemple: Génie Informatique" required>

                    <input type="submit" value="Ajouter" name="dept-submit">
                </form>
                <span class="modal-close-button">+</span>
            </div>

            <!-- Fenetre flottante de modification d'une filiere -->
            <div class="modal float" data-modal-name="modify-filiere">
                <form action="./../actions/updateFiliere.php" method="POST">
                    <p>Modifier la filiere : <span id="current-filiere-name"></span></p>

                    <label for="modify-filiere-name">Nom</label>
                    <input type="text" name="modify-filiere-name" id="modify-filiere-name" placeholder="Exemple: DAI" required>

                    <label for="modify-filiere-dept">Departement</label>
                    <select name="modify-filiere-dept" id="modify-filiere-dept" required>
                        <?php foreach($departements as $dept) : ?>
                            <option value="<?= $dept['dept_id'] ?>"><?= $dept['dept_name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="modify-filiere-desc">Description</label>
                    <textarea name="modify-filiere-desc" id="modify-filiere-desc" rows="3" placeholder="Exemple: Developpeur d'Applications Informatiques" required></textarea>

                    <input type="hidden" name="modify-filiere-id" id="modify-filiere-id">
                    <input type="submit" value="Modifier" name="modify-filiere-submit">
                </form>
                <span class="modal-close-button">+</span>
            </div>

            <!-- Fenetre flottante de modification d'un departement -->
            <div class="modal float" data-modal-name="modify-dept">
                <form action="./../actions/updateDept.php" method="POST">
                    <p>Modifier le departement : <span id="current-dept-name"></span></p>

                    <label for="modify-dept-name">Nom</label>
                    <input type="text" name="modify-dept-name" id="modify-dept-name" placeholder="Exemple: Génie Informatique" required>

                    <input type="hidden" name="modify-dept-id" id="modify-dept-id">
                    <input type="submit" value="Modifier" name="modify-dept-submit">
                </form>
                <span class="modal-close-button">+</span>
            </div>

        <?php endif; ?>

        <!-- La liste de departement > Filiere > Etudiants -->
        <div class="dept-list">

            <?php foreach($departements as $dept) : ?>
                <div class="dept">

                    <!-- Nom du departement ( nbr de filiere dans ce dept ) -->
                    <h2 class="dept-name">
                        <?= $dept['dept_name'] . ' (' . count(getFiliereInDept($dept['dept_id'])) . ') : ' ?>

                        <!-- Icon de modification affiché juste pour l'administrateur -->
                        <?php if($_SESSION['user_type'] == 'AD') : ?>
                            <span class="edit-dept-icon" onclick="showModal(this); loadDeptContent(<?= $dept['dept_id'] ?>, `<?= $dept['dept_name'] ?>`)" data-modal="modify-dept">
                                <img src="./../icons/edit.png">
                            </span>
                        <?php endif; ?>
                    </h2>

                    <?php foreach(getFiliereInDept($dept['dept_id']) as $filiere) : ?>

                        <div class="filiere">

                            <h2 class="filiere-name">
                                <?= $filiere['filiere_description'] ?>
                                <span class="nbr-students"> - 
                                    <?= $filiere['filiere_name'] ?>
                                    (<?= count(getStudentsInFiliere($filiere['filiere_id'])) ?>)
                                </span>

                                <?php if(count(getStudentsInFiliere($filiere['filiere_id']))) : ?>
                                    <img src="./../icons/arrow.png" class="students-toggler">
                                <?php endif; ?>

                                <!-- Icon de modification affiché juste pour l'administrateur -->
                                <?php if($_SESSION['user_type'] == 'AD') : ?>
                                    <span 
                                        class="edit-filiere-icon" 
                                        title="<?= $filiere['filiere_description'] ?>"
                                        onclick="
                                            showModal(this);
                                            loadFiliereContent(
                                                <?= $filiere['filiere_id'] ?>,
                                                `<?= $filiere['filiere_name'] ?>`,
                                                <?= $dept['dept_id'] ?>,
                                                `<?= $filiere['filiere_description'] ?>`
                                            );
                                        " 
                                        data-modal="modify-filiere">
                                        <img src="./../icons/edit.png">
                                    </span>
                                <?php endif; ?>

                            </h2>

                            <?php if(count(getStudentsInFiliere($filiere['filiere_id']))) : ?>
                                <div class="students-list">
                                    <table>
                                        <thead>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>CNE</th>
                                            <th>Email</th>
                                            <th>Telephone</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach(getStudentsInFiliere($filiere['filiere_id']) as $student) : ?>

                                                <?php $user = getUserBy($student['email'], 'email'); ?>
                                                <tr>
                                                    <td data-label="Nom"><?= $user['nom'] ?></td>
                                                    <td data-label="Prenom"><?= $user['prenom'] ?></td>
                                                    <td data-label="CNE"><?= $student['cne'] ?></td>
                                                    <td data-label="Email"><?= $user['email'] ?></td>
                                                    <td data-label="Telephone"><?= $user['telephone'] ?></td>
                                                </tr>
        
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>

                        </div>
                        
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

        </div>

    </div>

    <script src="./../js/admin.js" defer></script>
</body>
</html>