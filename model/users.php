<?php

class users {

    public $id = 0;
    public $alias = '';
    public $password = '';
    public $mail = '';
    public $id_jero_status = '';
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=vulgarcom;charset=utf8', 'ravaux', 'Ravaux.02');
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    //Méthode permettant la création d'un utilisateur via son pseudo son mot de passe  et son adresse mail
    public function createUsers() {
        //  on effectue une requéte pour insérer les informations de mon utilisateur dans la base de données
        // le 4 correspond au status utilisateur qu' on attibut 
        $query = 'INSERT INTO `jero_users` ( `alias`, `password`, `mail`, `id_jero_status`) VALUES (:alias, :password, :mail, 4)';
        // on prépare la requéte
        $queryResult = $this->db->prepare($query);
        //  on associe les valeurs insérer a un marqueur nominatif correspondant 
        $queryResult->bindValue(':alias', $this->alias, PDO::PARAM_STR);
        $queryResult->bindValue(':password', $this->password, PDO::PARAM_STR);
        $queryResult->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        // on exécute la requéte
        return $queryResult->execute();
    }

    // Méthode servant a l'affichage du profil qui récupére les info de l'utilisateur via son id
    public function getUsersSelect() {
        //  on effectue une requéte pour selectioner les informations de mon utilisateur via son id
        $query = 'SELECT `alias`,`password`,`mail` FROM `jero_users` WHERE `id`=:id';
        // on prépare la requéte
        $queryResult = $this->db->prepare($query);
        //  on associe la valeur  a selectioner un marqueur nominatif correspondant
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on exécute la requéte
        $queryResult->execute();
        // retourne la ligne correspondante grace a la méthode fetch
        return $queryResult->fetch(PDO::FETCH_OBJ);
    }

    // Méthode permetant de modifier les informations d'un utilisateur via son id 
    public function getModifyUsersSelect() {
        //  on effectue une requéte pour modifier les informations de mon utilisateur via son id
        $query = 'UPDATE `jero_users` '
                . 'SET `alias` = :alias, `password` = :password, `mail` = :mail '
                . 'WHERE `id` = :id';
        // on prépare la requéte 
        $queryResult = $this->db->prepare($query);
        //  on associe les valeur  a modifier a un marqueur nominatif correspondant et on associe l 'id a un  utilisateur a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        $queryResult->bindValue(':alias', $this->alias, PDO::PARAM_STR);
        $queryResult->bindValue(':password', $this->password, PDO::PARAM_STR);
        $queryResult->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }

    // Méthode permetant de supprimer l'utilisateur via son id 
    public function deleteUsersSelect() {
        //  on effectue une requéte pour supprimer l' utilisateur via son id
        $query = 'DELETE FROM `jero_users` WHERE `id`= :id';
        $queryResult = $this->db->prepare($query);
        // on associe a un marqueur nominatif l'id d' un utilisateur a supprimmer
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on éxécute la requéte
        $queryResult->execute();
    }

    // Méthode permetant de récupérer  l'id le password et le status d'un utilisateur via son alias quand il se connecte
    public function LoginUsersSelect() {
        //  on effectue une requéte pour selectionner l' utilisateur via son alias
        $query = 'SELECT `id`, `password`,`id_jero_status` AS `status` FROM `jero_users` WHERE `alias`= :alias ';
        $queryResult = $this->db->prepare($query);
        // on associe a un marqueur nominatif a l'alias d' un utilisateur a connecter
        $queryResult->bindValue(':alias', $this->alias, PDO::PARAM_STR);
        $queryResult->execute();
        // retourne la ligne correspondante grace a la fonction fetch
        return $queryResult->fetch(PDO::FETCH_OBJ);
    }

    // Méthode permetant de récupérer la liste des utilisateurs qui ne sont pas administrateur, modérateur,rédacteur. 
    public function getUsersList() {
        //  on initialise un tableau vide qui contiendra les résultats
        $result = array();
        // on effectue un requéte permettant de sélectionner l' id le pseudo et le mail d'un utilisateur qui seront par ordre alphabétique 
        $query = 'SELECT `jero_users`.`id`, `jero_users`.`alias`,`jero_users`.`mail`, `id_jero_status` AS `status` '
                . 'FROM `jero_users` '
                . 'WHERE `id_jero_status` NOT IN (1,2,3) '
                . 'ORDER BY `jero_users`.`alias` ASC';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis les lignes de mon tableau avec le résultat de ma requéte
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des utilisateur
        return $result;
    }
    // Méthode permetant de récupérer la liste des état possible d'un utilisateur qui n'est pas administrateur, modérateur,redacteur
    public function getStatusList() {
        //  on initialise un tableau vide qui contiendra les résultats
        $result = array();
        // on effectue une requéte qui permet que récupérer la liste des status
        $query = 'SELECT `id`,`status` FROM `jero_status` WHERE `id` NOT IN (1,2,3) ORDER BY `status` ASC';
        $queryResult = $this->db->query($query);
        if (is_object($queryResult)) {
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }
    
      // Méthode permetant de récupérer la liste des état possible d'un utilisateur qui n'est pas administrateur
    public function getStatusListForAdmin() {
        //  on initialise un tableau vide qui contiendra les résultats
        $result = array();
        // on effectue une requéte qui permet que récupérer  la liste des status pour la partie admin
        $query = 'SELECT `id`,`status` FROM `jero_status` WHERE `id` NOT IN (1) ORDER BY `status` ASC';
        $queryResult = $this->db->query($query);
        if (is_object($queryResult)) {
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }
    
    // Méthode permetant de modifier le grade d'un utilisateur via son id 
    public function getModifyUsersStatusSelect() {
        //  on effectue une requéte pour modifier le statut de mon utilisateur via son id
        $query = 'UPDATE `jero_users` '
                . 'SET `id_jero_status` = :userStatus '
                . 'WHERE `id` = :id';
        // on prépare la requéte 
        $queryResult = $this->db->prepare($query);
        //  on associe les valeur  a modifier a un marqueur nominatif correspondant et on associe l 'id a un  utilisateur a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        $queryResult->bindValue(':userStatus', $this->id_jero_status, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
    
        // Méthode permetant de récupérer la liste des utilisateurs. 
    public function getUsersListAdmin() {
        //  on initialise un tableau vide qui contiendra les résultats
        $result = array();
        // on effectue un requéte permettant de sélectionner l' id le pseudo et le mail d'un utilisateur qui seront par ordre alphabétique 
        $query = 'SELECT `jero_users`.`id`, `jero_users`.`alias`,`jero_users`.`mail`, `id_jero_status` AS `status` '
                . 'FROM `jero_users` '
                . 'WHERE `id_jero_status` NOT IN (1) '
                . 'ORDER BY `jero_users`.`alias` ASC';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis les lignes de mon tableau avec le résultat de ma requéte
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des utilisateur
        return $result;
    }
    
    public function checkFreeAlias() {
        $result = FALSE;
        // On verifie que le pseudo n est pas pris en le recherchant dans la table users et en comptant les résultats
        $query = 'SELECT COUNT(`id`) AS `takenAlias` FROM `jero_users` WHERE `alias`= :alias';
        $freeAlias = $this->db->prepare($query);
        //on associe les valeur  a rechercher a un marqueur nominatif correspondant
        $freeAlias->bindValue(':alias', $this->alias, PDO::PARAM_STR);
        if ($freeAlias->execute()) {
            $resultObject = $freeAlias->fetch(PDO::FETCH_OBJ);
            //On stocke le resultat dans une variable $result
            $result = $resultObject->takenAlias;
        }
        //On retourne le résultat
        return $result;
    }
    
    public function checkFreeMail() {
        $result = FALSE;
        // On verifie que le mail n est pas pris en le recherchant dans la table users et en comptant les résultats
        $query = 'SELECT COUNT(`id`) AS `takenMail` FROM `jero_users` WHERE `mail`= :mail';
        $freeMail = $this->db->prepare($query);
        //on associe les valeur  a rechercher a un marqueur nominatif correspondant
        $freeMail->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        //si la requete s'execute
        if ($freeMail->execute()) {
            $resultObject = $freeMail->fetch(PDO::FETCH_OBJ);
            //On stocke le resultat dans une variable $result
            $result = $resultObject->takenMail;
        }
        //On retourne le résultat
        return $result;
    }
    
    public function checkFreeAliasProfil() {
        $result = FALSE;
        // On verifie que le pseudo n est pas pris en le recherchant dans la table users et en comptant les résultats
        //et on ignore les lignes de la table qui concernent l'utilisateur qui modifie son profil
        $query = 'SELECT COUNT(`id`) AS `takenAlias` FROM `jero_users` WHERE `alias`= :alias AND `id` != :id ';
        $freeAlias = $this->db->prepare($query);
        //on associe les valeur  a rechercher a un marqueur nominatif correspondant
        $freeAlias->bindValue(':alias', $this->alias, PDO::PARAM_STR);
        $freeAlias->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($freeAlias->execute()) {
            $resultObject = $freeAlias->fetch(PDO::FETCH_OBJ);
            //On stocke le resultat dans une variable $result
            $result = $resultObject->takenAlias;
        }
        //On retourne le résultat
        return $result;
    }
    
    public function checkFreeMailProfil() {
        $result = FALSE;
        // On verifie que le mail n est pas pris en le recherchant dans la table users et en comptant les résultats
        //et on ignore les lignes de la table qui concernent l'utilisateur qui modifie son profil
        $query = 'SELECT COUNT(`id`) AS `takenMail` FROM `jero_users` WHERE `mail`= :mail AND `id` != :id';
        $freeMail = $this->db->prepare($query);
        //on associe les valeur  a rechercher a un marqueur nominatif correspondant
        $freeMail->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $freeMail->bindValue(':id', $this->id, PDO::PARAM_INT);
        //si la requete s'execute
        if ($freeMail->execute()) {
            $resultObject = $freeMail->fetch(PDO::FETCH_OBJ);
            //On stocke le resultat dans une variable $result
            $result = $resultObject->takenMail;
        }
        //On retourne le résultat
        return $result;
    }
}
