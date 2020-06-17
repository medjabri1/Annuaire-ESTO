//Fonction de recherche sur la page d'acceuil

let searchUsers = () => {

    event.preventDefault();

    let searchKey = document.getElementById('search-string').value.toLowerCase();
    let searchOption = document.getElementById('search-option').value;

    if(searchOption == 'E') var users = document.querySelectorAll('.user-data-email');
    else if(searchOption == 'N') var users = document.querySelectorAll('.user-data-nom');
    else if(searchOption == 'P') var users = document.querySelectorAll('.user-data-prenom');
    else if(searchOption == 'T') var users = document.querySelectorAll('.user-data-phone');

    //Masquer tout les utilisateurs
    users.forEach(user => {
        user.parentElement.style.display = 'none';
    });
    
    let cpt = 0;
    
    //Afficher les utilisateurs qui correspond a la recherche
    users.forEach(user => {
        
        //Le contenu du user.textContent contient une chaine similaire a celle de la recherche
        //On caompare le miniscule / pas sensible a la casse
        
        if(user.textContent.toLowerCase().indexOf(searchKey) > -1) {
            if(document.body.clientWidth > 900) {
                user.parentElement.style.display = 'table-row';
            } else {
                user.parentElement.style.display = 'flex';
            }
            cpt++;
        }

    });

    document.querySelector('.search-count span').textContent = "("+ cpt +")";
    if(cpt == 0) {
        document.querySelector('.users-list table thead th').parentElement.style.display = 'none';
    } else {
        if(document.body.clientWidth > 900) {
            document.querySelector('.users-list table thead th').parentElement.style.display = 'table-row';
        } else {
            document.querySelector('.users-list table thead th').parentElement.style.display = 'flex';
        }
    }
};