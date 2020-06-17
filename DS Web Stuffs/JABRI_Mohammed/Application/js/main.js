// Fermer les formulaire de connexion / inscription
let closeButtons = document.querySelectorAll('.close-sign');

let signinForm = document.getElementById('sign-in-div');
let signupForm = document.getElementById('sign-up-div');

// class = "active" --> afficher la formulaire

closeButtons.forEach(button => {
    button.addEventListener('click', ()=>{

        signinForm.classList.remove('active');
        signupForm.classList.remove('active');

        //Initialiser les champs des formulaires
        signupForm.querySelectorAll('form').forEach(form => {
            form.reset();
        });
        signinForm.querySelectorAll('form').forEach(form => {
            form.reset();
        });
    });
});

//Fermer les formulaires lorsque l'utilisateur appuie sur la touche echap
// 27 c'est le code de la boutton Esc dans le clavier

window.addEventListener('keydown', (event)=>{

    if(event.keyCode == 27) {
        signinForm.classList.remove('active');
        signupForm.classList.remove('active');
        
        //Initialiser les champs des formulaires
        signupForm.querySelectorAll('form').forEach(form => {
            form.reset();
        });
        signinForm.querySelectorAll('form').forEach(form => {
            form.reset();
        });
    }
});

//Afficher les formulaire de connexion / d'inscription

let showSign = (key) => {
    if(key == 'in') signinForm.classList.add('active');
    if(key == 'up') signupForm.classList.add('active');
};

//Afficher les champs de formulaire par rapport au type d'utilisateur
// Enseignant / Fonctionnaire --> Afficher PPR
//Etudiant --> Afficher Filiere / CNE

let changeSignInfo = (select) => {

    //select.value == ET --> Etudiant
    //select.value == EN --> Enseignant
    //select.value == FN --> Fonctionnaire

    if(select.value == 'ET') {

        //CNE
        document.getElementById('signup-cne').type = 'text';
        document.getElementById('signup-cne').required = true;
        document.getElementById('signup-cne-label').style.display = 'unset';

        //Filiere
        document.getElementById('signup-filiere').style.display = 'unset';
        document.getElementById('signup-filiere').required = true;
        document.getElementById('signup-filiere-label').style.display = 'unset';

        //PPR
        document.getElementById('signup-ppr').type = 'hidden';
        document.getElementById('signup-ppr').required = false;
        document.getElementById('signup-ppr-label').style.display = 'none';
        
    } else if(select.value == 'EN' || select.value == 'FN') {
        
        //CNE
        document.getElementById('signup-cne').type = 'hidden';
        document.getElementById('signup-cne').required = false;
        document.getElementById('signup-cne-label').style.display = 'none';

        //Filiere
        document.getElementById('signup-filiere').style.display = 'none';
        document.getElementById('signup-filiere').required = false;
        document.getElementById('signup-filiere-label').style.display = 'none';

        //PPR
        document.getElementById('signup-ppr').type = 'number';
        document.getElementById('signup-ppr').required = true;
        document.getElementById('signup-ppr-label').style.display = 'unset';

    }

};

//Verifier les champs des formulaire connexion / inscription avant l'envoie des données

let verifyForm = (form) => {

    //Empecher la formulaire de la soumission par default sur le click
    event.preventDefault();

    if(form == 'signin') {

        let email = document.getElementById('signin-email').value;
        let password = document.getElementById('signin-password').value;
        let error = document.getElementById('signin-errors');

        if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {

            //Email non valide
            error.textContent = '* Email entere non valide!';

        } else if(password.length < 8) {
            
            //Password court
            error.textContent = '* Mot de passe entre trop court!';

        } else {

            //Tous les champs sont valide --> submit Formulaire
            document.forms['signin-form'].submit();
        }
        

    } else if(form == 'signup') {

        let nom = document.getElementById('signup-nom').value;
        let prenom = document.getElementById('signup-prenom').value;
        let phone = document.getElementById('signup-phone').value;
        let email = document.getElementById('signup-email').value;
        let password = document.getElementById('signup-password').value;
        let ppr = document.getElementById('signup-ppr').value;
        let type = document.getElementById('signup-type').value;
        let cne = document.getElementById('signup-cne').value;

        let error = document.getElementById('signup-errors');

        if(nom.length < 2) {

            //Nom entre trop court
            error.textContent = '* Le nom entre est trop court!';

        } else if(prenom.length < 2) {

            //Prenom entre trop court
            error.textContent = '* Le prenom entre est trop court!';            

        } else if(phone.length != 10 || phone[0] != '0') {

            //Telephone non valide
            error.textContent = '* Telephone entre non valide!';

        } else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {

            //Email non valide
            error.textContent = '* Email entere non valide!';

        } else if(password.length < 8) {

            //Mot de passe entre est trop court
            error.textContent = '* Mot de passe entre est trop court!';

        } else {

            if(type == 'ET') {
                //C'est un(e) etudiant(e)
                if(cne.length != 10) {

                    //CNE entre non valide
                    error.textContent = '* CNE entre non valide!';

                } else {
                    //Tous les champs sont valide --> submit Formulaire
                    document.forms['signup-form'].submit();
                }

            } else if(type == 'EN' || type == 'FN') {
                //Enseignant ou bien fonctionnaire
                if(ppr.length < 1) {

                    //PPR entre non valide
                    error.textContent = '* PPR entre non valide!';

                } else {
                    //Tous les champs sont valide --> submit Formulaire
                    document.forms['signup-form'].submit();
                }
            }

        }
        
    }

};

//Message de succes / erreur dans l'index

let hideMessage = (element) => {
    let parent = element.parentElement;
    
    parent.removeChild(element);
};

//Changer les formulaire de modiciation de données / Mot de passe

let changeModifyForm = (element) => {

    let parent = element.parentElement;

    let forms = document.querySelectorAll('.modify-form');
    forms.forEach(form => {
        form.classList.add('active');
    });

    parent.classList.remove('active');

};

//Afficher et masquer les formulaires de modification des donnes / mot de passe

let showModifyForm = (element) => {
    if(element.dataset.form == 'data') {
        document.getElementById('modify-data').classList.add('active');
        document.getElementById('modify-password').classList.remove('active');

    } else if(element.dataset.form == 'password') {
        document.getElementById('modify-data').classList.remove('active');
        document.getElementById('modify-password').classList.add('active');
    }

    let buttons = document.querySelectorAll('.modify-choices');
    buttons.forEach(button => {
        button.classList.remove('active');
    });
    element.classList.add('active');
};

//Verifier les champs des formulaires de modification des donnees / mot de passe

let verifyModifyForm = (form) => {
    event.preventDefault();

    if(form == 'data') {

        var nom = document.getElementById('modify-nom').value;
        var prenom = document.getElementById('modify-prenom').value;
        var phone = document.getElementById('modify-phone').value;
        var email = document.getElementById('modify-email').value;
        var type = document.getElementById('modify-type').value;

        if(type == 'ET') {
            var cne = document.getElementById('modify-cne').value;
        } else if(type == 'FN' || type == 'EN') {
            var ppr = document.getElementById('modify-ppr').value;
        }

        var errors = document.getElementById('modify-errors');

        if(nom.length < 3) {
            errors.textContent = 'Nom entree trop court!';
        }
        else if(prenom.length < 3) {
            errors.textContent = 'Prenom entree trop court!';
        }
        else if(phone.length !=10 || phone[0] != '0') {
            errors.textContent = 'Numero de telephone entree invalide!'
        }
        else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
            errors.textContent = 'Adresse Email entree invalide!';
        }
        else if(type == 'ET') {
            if(cne.length != 10) {
                errors.textContent = 'CNE entree est invalide!';
            } else {
                document.forms['modify-data'].submit();
            }
        } else if(type == 'EN' || type == 'FN') {
            if(ppr.length < 2) {
                errors.textContent = 'Numero ppr entree est invalide!';
            } else {
                document.forms['modify-data'].submit();
            }
        } else if(type='AD') {
            document.forms['modify-data'].submit();
        } else {
            document.forms['modify-data'].submit();
        }

    } else if(form == 'password') {

        let old_password = document.getElementById('password-old').value;
        let new_password = document.getElementById('password-new').value;
        let confirm_password = document.getElementById('password-confirm').value;

        let errors = document.getElementById('password-errors');

        if(old_password.length < 8 || new_password.length < 8 || confirm_password.length < 8) {
            errors.textContent = 'Les mot de passes entrees sont trop courts, min = 8!';
        }
        else if(new_password != confirm_password) {
            errors.textContent = 'La confirmation n\'est pas correcte!';
        }
        else {
            document.forms['modify-password'].submit();
        }

    }
};