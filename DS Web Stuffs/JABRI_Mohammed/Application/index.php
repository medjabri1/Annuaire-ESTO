<?php

    //Fichier qui contient les fonctions
    require_once('./config/functions.php');

    session_start();

    if(isset($_SESSION['user_id'])) {
        
        // L'utilisateur deja connecté --> Redirection
        header('Location: ./home/home.php');
        die();
    }

    //SUCCESS-Messages
    if(isset($_GET[sha1('user_signup_succes')])) $success = 'Vous êtes inscrit maintenant!';
    
    //ERROR-Messages
    require_once('./config/errors.php');

    //Tous les filieres
    $filieres = getAllFilieres();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire ESTO</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="icons/annuaire.png">
</head>
<body>

    <div class="showcase">

        <img src="icons/annuaire.png" class="showcase-logo">
        <h1>Bienvenue dans annuaire <span>ESTO</span></h1>

        <p>Vous trouvez ici tous les <span>adresses email</span> et <span>numeros de telephone</span> de tous les <span>etuditans, enseignants et fonctionnaires</span> de l'ESTO</p>

        <div class="sign">
            <h2 onclick="showSign('in')">Se connecter</h2>
            <h2 onclick="showSign('up')">S'inscrire</h2>
        </div>

        <!-- Message de succes -->

        <?php if(isset($success)) : ?>
            <p class="succes-messages" onclick="hideMessage(this)" title="CLIQUER POUR MASQUER">
                <?= $success ?>
            </p>
        <?php endif; ?>
        
        <!-- Message d'erreur -->
        
        <?php if(isset($error)) : ?>
            <p class="succes-messages" onclick="hideMessage(this)" title="CLIQUER POUR MASQUER">
                <?= $error ?>
            </p>
        <?php endif; ?>

        <!-- Formulaire de connexion -->

        <div class="sign-in-div <?= $errorType == 'in' ? ' active' : '' ?>" id="sign-in-div">

            <form action="actions/signin.php" method="POST" id="signin-form">

                <label for="signin-email">Adresse Email :</label>
                <input type="email" id="signin-email" name="signin-email" placeholder="exemple@esto.com" required>

                <label for="signin-password">Mot de passe :</label>
                <input type="password" id="signin-password" name="signin-password" required>

                <input type="submit" name="signin-submit" value="Se connecter" onclick="verifyForm('signin')">

                <p id="signin-errors"><?= $errorType == 'in' ? $signError : '' ?></p>

            </form>

            <span class="close-sign">+</span>

        </div>

        <!-- Formulaire d'inscription -->

        <div class="sign-up-div <?= $errorType == 'up' ? ' active' : '' ?>" id="sign-up-div">


            <form action="actions/signup.php" method="POST" id="signup-form">

                <!-- La class sub-form pour minimiser l'espace dans l'affichage du formulaire -->

                <div class="sub-form">
                    <div>
                        <label for="signup-nom">Nom :</label>
                        <input type="text" id="signup-nom" name="signup-nom" required>
                    </div>

                    <div>
                        <label for="signup-prenom">Prenom :</label>
                        <input type="text" id="signup-prenom" name="signup-prenom" required>
                    </div>
                </div>

                <label for="signup-phone">Telephone :</label>
                <input type="number" id="signup-phone" name="signup-phone" placeholder="0999999999" required>

                <label for="signup-email">Adresse Email :</label>
                <input type="email" id="signup-email" name="signup-email" placeholder="exemple@esto.com" required>

                <label for="signup-password">Mot de passe :</label>
                <input type="password" id="signup-password" name="signup-password" required>

                <label for="signup-type">Vous êtes ?</label>

                <!-- changeSignInfo() -> nous permet de changer la visiblite des champs (cne, ppr, filiere)  -->

                <select name="signup-type" id="signup-type" required onchange="changeSignInfo(this)">
                    <option value="ET">Etudiant(e)</option>
                    <option value="EN" selected>Enseignant</option>
                    <option value="FN">Fonctionnaire</option>
                </select>

                <label for="signup-ppr" id="signup-ppr-label">Numero PPR :</label>
                <input type="number" id="signup-ppr" name="signup-ppr">

                <div class="sub-form">
                    <div>
                        <label for="signup-cne" id="signup-cne-label" style="display: none">CNE :</label>
                        <input type="hidden" id="signup-cne" name="signup-cne" max="10">
                    </div>

                    <div>
                        <label for="signup-filiere" id="signup-filiere-label" style="display: none">Filiere :</label>
                        <select name="signup-filiere" id="signup-filiere" style="display: none">
                            <?php foreach($filieres as $filiere) : ?>
                                <option value="<?= $filiere['filiere_id'] ?>"><?= $filiere['filiere_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <input type="submit" name="signup-submit" value="S'inscrire" onclick="verifyForm('signup')">

                <p id="signup-errors"><?= $errorType == 'up' ? $signError : '' ?></p>

            </form>

            <span class="close-sign">+</span>

        </div>
        
    </div>

    <!-- Javascript -->

    <script src="js/main.js" defer></script>
    
</body>
</html>