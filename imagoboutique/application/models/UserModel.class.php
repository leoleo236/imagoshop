<?php

/*  Initialisation de la classe UserModel.
    Contient les fonctions relatives aux utilisateurs 
    qui intéragissent avec la base de données
    (requêtes SQL).  */
class UserModel {

//  Fonction d'inscription de l'utilisateur. 
     public function signUp(
        $firstName,
        $lastName,
        $email,
        $password,
        $address,
        $city,
        $zipCode)
    {
        $database = new Database();

/*  Vérification que l'adresse e-mail spécifiée 
    existe dans la bdd. */
        $user = $database->queryOne
        (
            "SELECT Id FROM User WHERE Email = ?", [ $email ]
        );

// Si l'email existe déjà:
        if(empty($user) == false) {
            var_dump('Erreur: cet utilisateur existe déjà');
        }

// Si l'email est nouveau on ajoute l'utilisateur à la bdd.
        $sql = 'INSERT INTO users
        (
            firstName,
            lastName,
            email,
            password,
            creationTimeStamp,
            address,
            city,
            zipCode,
            role
        ) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, "user")';


        $passwordHash = $this->hashPassword($password);

        $database->executeSql($sql,
        [
            $firstName,
            $lastName,
            $email,
            $passwordHash,
            $address,
            $city,
            $zipCode
        ]);

 // Ajout d'un message de notification qui s'affichera sur la page d'accueil. 
    }

    
    
// Vérification du mot de passe protégé/hashé.
    private function verifyPassword($password, $hashedPassword) {
        return crypt($password, $hashedPassword) == $hashedPassword;
    }

// Protection/Hachage du mot de passe.
    private function hashPassword($password) {
        $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);
        
        return crypt($password, $salt); 
    }

    public function findWithEmailPassword($email, $password)
    {
        $database = new Database();

// Récupération de l'utilisateur ayant l'email spécifié en argument.
        $user = $database->queryOne
        (
            "SELECT
                *
            FROM users
            WHERE email = ?",
            [ $email ]
        );

        var_dump($user);

// Si l'utilisateur n'existe pas: 
        if(empty($user) == true) {
            var_dump('Utilisateur non trouvé');
        }

/*  S'il existe déjà on vérifie le mot de passe spécifié
    par rapport à celui stocké par l'utilisateur.   */

// Si le mot de passe spécifié est incorrect.
        if($this->verifyPassword($password, $user['password']) == false) {
                var_dump('Le mot de passe spécifié est incorrect');
        } 
// Si le mot de passe spécifié est correct.
// Récupération des données de l'utilisateur:
        else {
            $_SESSION['user']['id'] = $user['Id'];
            $_SESSION['user']['firstname'] = $user['firstName'];
            $_SESSION['user']['lastname'] = $user['lastName'];
            $_SESSION['user']['email'] = $user['email'];
            $_SESSION['user']['role'] = $user['role'];
        }
        var_dump($_SESSION);
    }

//  Liste des utilisateurs.
    public function listAllUsers() {
        $database = new Database();
        $sql = 'SELECT
                    *
                FROM users';
        return $database->query($sql, []);
    }

/*  Changement du rôle d' un utilisateurs (client/admin)
    (et donc de ses attributs). */
    public function changeUserRole($id, $role) {
        $database = new Database();
        $sql = 'UPDATE users SET role=? WHERE Id=?';
        $database->executeSql($sql, [$role, $id]);
    }

// Suppression de l'utilisateur dans la bdd.
    public function deleteUser($id) {
        $database = new Database();
        $sql = 'DELETE FROM users WHERE Id=?';
        $database->executeSql($sql, [ $id ]);
    }

//  Sélection d'un utilisateur.
    public function findOneUser($id) {
        $database = new Database();
        $sql = 'SELECT * FROM users WHERE Id=?';
        return $database->queryOne($sql, [ $id ]);
    }

//  Fonction de modification d'un utilisateur.
    public function changeUserProfil($post, $id) {
        $database = new Database();
        $sql = 'UPDATE users SET firstName=?, lastName=?, email=?, address=?, city=?, zip=? WHERE Id=?';
        $database->executeSql($sql, [ $post['firstname'], $post['lastname'], $post['email'], $post['address'], $post['city'], $post['zip'], $id]);
    }
    
}
