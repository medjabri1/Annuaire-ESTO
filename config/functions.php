<?php

    //Focntion qui retoune une Connexion PDO
    function getConnection() {
        
        $dsn = 'mysql:host=localhost;dbname=annuaireESTO';
		$pdo = new PDO($dsn, 'root', '');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }

    // ---------------------------------- Fonctions des utlisateurs -----------------------------------------

    //Focntion d'ajout d'un nouveau utilisateur
    function adduser($data, $type, $email, $num, $filiere = '') {
        
        $pdo = getConnection();
        $query1 = 'insert into user (nom, prenom, telephone, email, password, description) values (?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($query1);
        $stmt->execute($data);
        
        if($type == 'ET') {
            $query2 = 'insert into etudiant (cne, email, filiere_id) values (?, ?, ?)';
            $stmt2 = $pdo->prepare($query2);
            return $stmt2->execute([ $num, $email, $filiere ]);
        } else {
            $query2 = 'insert into personnel (ppr, email) values (?, ?)';
            $stmt2 = $pdo->prepare($query2);
            return $stmt2->execute([ $num, $email ]);
        }
    }

    //Fonction de recuperation d'utilisateur par valeur du colonne specifique
    function getUserBy($value, $column = 'user_id') {

        $pdo = getConnection();
        $query = "select * from user where $column = ?";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$value]);

        $user = $stmt->fetchAll();

        if(count($user)) return $user[0];
        else return null;
    }

    //Fonction de recuperation d'utilisateurs non verifiés
    function getNotVerifiedUsers() {

        $pdo = getConnection();
        $query = "select * from user where verified = 0 order by created_at desc";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $users = $stmt->fetchAll();

        if(count($users)) return $users;
        else return null;
    }

    //Fonction de recuperation de tous les utilisateurs
    function getVerifiedUsers() {

        $pdo = getConnection();
        $query = "select * from user where verified = 1 and description != 'AD' order by nom, created_at desc";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $users = $stmt->fetchAll();

        if(count($users)) return $users;
        else return null;
    }

    //Fonction de verification d'un utilisateur
    function verifyUser($user) {

        $pdo = getConnection();
        $query = "update user set verified = 1 where user_id = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$user['user_id']]);
    }

    //Fonction d'unverification d'un utilisateur
    function unverifyUser($user) {

        $pdo = getConnection();
        $query = "update user set verified = 0 where user_id = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$user['user_id']]);
    }

    //Fonction de rejection d'un utilisateur / Fonction de suppression d'utilisateur
    function rejectUser($user) {

        $pdo = getConnection();
        if($user['description'] == 'ET') {
            $query1 = 'delete from etudiant where email = ?';
            $stmt1 = $pdo->prepare($query1);
            $stmt1->execute([ $user['email'] ]);
        } else {
            $query1 = 'delete from personnel where email = ?';
            $stmt1 = $pdo->prepare($query1);
            $stmt1->execute([ $user['email'] ]);
        }

        $query2 = 'delete from user where user_id = ?';
        $stmt2 = $pdo->prepare($query2);
        return $stmt2->execute([ $user['user_id'] ]);
    }

    //Fonction de modification d'informations d'utilisateurs
    function updateUser($user_id, $data, $email, $type, $filiere = '', $num) {

        $pdo = getConnection();
        $query = 'update user set nom = ?, prenom = ?, telephone = ?, email = ? where user_id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute($data);

        if($type == 'ET') {
            $query = 'update etudiant set cne = ?, email = ?, filiere_id = ? where email = ?';
            $stmt = $pdo->prepare($query);
            $result =$stmt->execute([ $num, $email, $filiere, $_SESSION['email'] ]);
        } else {
            $query = 'update personnel set ppr = ?, email = ? where email = ?';
            $stmt = $pdo->prepare($query);
            $result = $stmt->execute([ $num, $email, $_SESSION['email'] ]);
        }

        $user = getUserBy($_SESSION['user_id']);
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['telephone'] = $user['telephone'];
        $_SESSION['email'] = $user['email'];

        return $result;
    }

    //Fonction du modification du mot de passe
    function updatePassword($user_id, $password) {

        $pdo = getConnection();
        $query = 'update user set password = ? where user_id = ?';
        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $password, $user_id ]);
    }

    // ----------------------------- Fonctions des etudiants ------------------------------------
    
    //Fonction de recuperation d'un etudiant par CNE
    function getStudentByCne($cne) {

        $pdo = getConnection();
        $query = 'select * from etudiant where cne = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $cne ]);

        $students = $stmt->fetchAll();

        if(count($students)) return $students[0];
        else return null;

    }

    //Fonction de recuperation d'un etudiant par EMail
    function getStudentByEmail($email) {

        $pdo = getConnection();
        $query = 'select * from etudiant where email = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $email ]);

        $students = $stmt->fetchAll();

        if(count($students)) return $students[0];
        else return null;

    }

    //Fonction de recuperation de tout les etudiants
    function getAllStudents() {

        $pdo = getConnection();
        $query = 'select * from etudiant';
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $students = $stmt->fetchAll();

        return $students;

    }

    //Fonction de recuperation des etudiants d'une filiere par filiere_id
    function getStudentsInFiliere($filiere_id) {

        $pdo = getConnection();
        $query = 'select * from etudiant where filiere_id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $filiere_id ]);

        $students = $stmt->fetchAll();

        return $students;
    }

    // ----------------------------- Fonctions des personnels -------------------------------------

    //Fonction de recuperation d'un personnel par CNE
    function getPersonnelByPPR($ppr) {

        $pdo = getConnection();
        $query = 'select * from personnel where ppr = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $ppr ]);
        
        $personnels = $stmt->fetchAll();

        if(count($personnels)) return $personnels[0];
        else return null;

    }

    //Fonction de recuperation d'un personnel par Email
    function getPersonnelByEmail($email) {

        $pdo = getConnection();
        $query = 'select * from personnel where email = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $email ]);
        
        $personnels = $stmt->fetchAll();

        if(count($personnels)) return $personnels[0];
        else return null;

    }

    // ----------------------------- Fonctions des filieres -------------------------------------

    //Fonction de recuperation des adminstrateurs
    function getAllAdmins() {

        $pdo = getConnection();
        $query = "select * from user where description = 'AD' order by created_at desc";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $admins = $stmt->fetchAll();

        if(count($admins)) return $admins;
        else return null;
    }

    //Fonction d'ajout d'un administrateur
    function addAdmin($data) {

        $pdo = getConnection();
        $query = 'insert into user (nom, prenom, email, telephone, password, description, verified) values (?, ?, ?, ?, ?, ?, ?)';

        $stmt = $pdo->prepare($query);
        return $stmt->execute($data);
    }

    //Fonction de suppression d'un administrateur
    function deleteAdmin($admin) {

        $pdo = getConnection();
        $query = 'delete from user where user_id = ?';

        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $admin['user_id'] ]);
    }

    // ----------------------------- Fonctions des filieres -------------------------------------
    
    //Fonction de recuperation de tous les filiere
    function getAllFilieres() {
        
        $pdo = getConnection();
        $query = 'select * from filiere order by filiere_name';
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $filieres = $stmt->fetchAll();
        
        return($filieres);
    }

    //Fonction de recuperation de filiere par filiere_id
    function getFiliereById($filiere_id) {

        $pdo = getConnection();
        $query = 'select * from filiere where filiere_id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$filiere_id]);
        
        $filieres = $stmt->fetchAll();
        
        if(count($filieres)) return $filieres[0];
        else return null;
    }
    
    //Fonction de recuperation des filiere d'un departement par dept_id
    function getFiliereInDept($dept_id) {
        
        $pdo = getConnection();
        $query = 'select * from filiere where dept_id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([ $dept_id ]);
        
        $filieres = $stmt->fetchAll();
        
        return $filieres;
    }
    
    //Fonction d'ajout du nouvelle filiere
    function addFiliere($filiere_name, $dept_id, $filiere_desc) {

        $pdo = getConnection();
        $query = 'insert into filiere (filiere_name, dept_id, filiere_description) values (?, ?, ?)';
        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $filiere_name, $dept_id, $filiere_desc ]);
    }

    //Fonction de modification d'une filiere
    function updatedFiliere($filiere_id, $filiere_name, $dept_id, $filiere_desc) {

        $pdo = getConnection();
        $query = 'update filiere set filiere_name = ?, dept_id = ?, filiere_description = ? where filiere_id = ?';
        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $filiere_name, $dept_id, $filiere_desc, $filiere_id ]);
    }

    // ----------------------------- Fonctions des Departements -------------------------------------
    
    //Fonction de recuperation de tout les departement
    function getAllDepartements() {

        $pdo = getConnection();
        $query = 'select * from departement order by dept_name';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $departements = $stmt->fetchAll();
     
        return $departements;
    }

    //Fonction d'ajout du nouveau departement
    function addDepartement($dept_name) {

        $pdo = getConnection();
        $query = 'insert into departement (dept_name) values (?)';
        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $dept_name ]);
    }

    //Fonction de modification d'un departement
    function updateDepartement($dept_id, $dept_name) {

        $pdo = getConnection();
        $query = 'update departement set dept_name = ? where dept_id = ?';
        $stmt = $pdo->prepare($query);
        return $stmt->execute([ $dept_name, $dept_id ]);
    }

?>