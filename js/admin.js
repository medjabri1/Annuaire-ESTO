//Afficher les utilisateurs non verifiés selon le choix / La page admin/verify-users.php
//et aussi Afficher les utilisateurs verifiés selon le choix / la page admin/users.php 
//avec la même fonction

let users = document.querySelectorAll('.user-type');

let showUsers = (element) => {
    let value = element.value;
    cpt = 0;
    if(value == 'T') {
        users.forEach(user => {
            if(document.body.clientWidth > 900) {
                user.parentElement.style.display = 'table-row';
            } else {
                user.parentElement.style.display = 'flex';
            }
            cpt++;
        });
    } else {
        users.forEach(user => {
            if(user.dataset.type == value) {
                if(document.body.clientWidth > 900) {
                    user.parentElement.style.display = 'table-row';
                } else {
                    user.parentElement.style.display = 'flex';
                }
                cpt++;
            } else {
                user.parentElement.style.display = 'none';
            }
        });
    }
    document.querySelector('.users-count').textContent = "("+ cpt +")";
    if(cpt == 0) {
        document.querySelector('.user-table thead th').parentElement.style.display = 'none';
        document.querySelector('.table-no-users').style.display = 'block';
    } else {
        document.querySelector('.user-table thead th').parentElement.style.display = 'table-row';
        document.querySelector('.table-no-users').style.display = 'none';
    }
};

//Masquer les messages d'erreur / succes

let deleteMessage = (element) => {
    let parent = element.parentElement;
    parent.removeChild(element);
};

//Afficher les formulaires d'ajout d'un departement / filiere

let showModal = (element) => {
    let modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if(modal.dataset.modalName == element.dataset.modal) {
            modal.classList.add('active');
        } else {
            modal.classList.remove('active');
        }
    });
};

//Fermer tout les fentre flottant qui ont la classe 'modal' avec le clic du boutton fermer

document.querySelectorAll('.modal-close-button').forEach(button => {

    button.addEventListener('click', ()=>{
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('active');
            //Initialiser la formulaire
            modal.querySelector('form').reset();
        });
    });
    
});

//Fermer tout les fenetres flottantes avec la touche echap

window.addEventListener('keydown', ()=>{
    if(event.keyCode == 27) {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('active');
            //Initialiser la formulaire
            modal.querySelector('form').reset();
        });
    }
});

//Afficher la table des etudiants de chaque filiere dans le click du fleche 

document.querySelectorAll('.students-toggler').forEach(fleche => {
    fleche.addEventListener('click', ()=>{
        
        let parent = fleche.parentElement.parentElement;
        parent.classList.toggle('active');

    });
});

//Charger les informations dans les modals de modification du filiere / departement

let loadDeptContent = (id, deptName) => {

    document.getElementById('modify-dept-id').value = id;
    document.getElementById('modify-dept-name').value = deptName;
    
    document.getElementById('current-dept-name').textContent = deptName;

}

let loadFiliereContent = (id, filiereName, deptId, filiereDesc) => {
    
    document.getElementById('modify-filiere-id').value = id;
    document.getElementById('modify-filiere-name').value = filiereName;
    document.getElementById('modify-filiere-dept').value = deptId;
    document.getElementById('modify-filiere-desc').value = filiereDesc;
    
    document.getElementById('current-filiere-name').textContent = filiereName;
        
};