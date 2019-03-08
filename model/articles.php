<?php

class articles {

    public $id = 0;
    public $title = '';
    public $content = '';
    public $date = '0000-00-00 00:00:00';
    public $source = '';
    public $state = '';
    public $author = 0;
    public $category = 0;
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=vulgarcom;charset=utf8', 'ravaux', 'Ravaux.02');
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    //Méthode pour créer un article et pour récupérer son id une fois qu'il a était créer
    public function createArticles() {
        $query = 'INSERT INTO `jero_articles` ( `title`, `content`, `date`, `source`, `id_jero_articlestate`, `id_jero_category`, `id_jero_users`) '
                //quand je créer un article son état sera toujour l'id 1 c'est a dire larticle est en attente
                . 'VALUES (:title, :content, :date, :source, 1, :category, :author)';
        // on attribue les valeur de l'article a créer au marqueur nominatif :title :content :category :source 
        $queryResult = $this->db->prepare($query);
        $queryResult->bindValue(':title', $this->title, PDO::PARAM_STR);
        $queryResult->bindValue(':content', $this->content, PDO::PARAM_STR);
        $queryResult->bindValue(':date', $this->date, PDO::PARAM_STR);
        $queryResult->bindValue(':source', $this->source, PDO::PARAM_STR);
        $queryResult->bindValue(':category', $this->category, PDO::PARAM_INT);
        $queryResult->bindValue(':author', $this->author, PDO::PARAM_INT);
        $queryResult->execute();
        // on récupére le dernier id insérer dans la base de données
        //c'est a dire celui de l'article que l'on vient d'insérer
        // comme sa le rédacteur tombe sur la vue correspondante a son article rédigé
        return $this->db->lastInsertId();
    }
    //Méthode permettant d'obetnir la liste des catégories de mais articles.
    public function getCategoriesList() {
        // on initialise un tableau a vide qui contiendra nos catégories
        $result = array();
        // on sélectionne l'id et le nom des categories et on les classes par ordre alphabétique
        $query = 'SELECT `id`,`name` FROM `jero_category` ORDER BY `name` ASC';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis les lignes de mon tableau grace a la fonction fetchAll avec le résultat de ma requéte
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des catégories
        return $result;
    }
    
    // Méthode pour récupérer un article, son rédacteur et sa catégorie
    public function getArticlesSelect() {
        $query = 'SELECT `title`,`content`, `date`,`jero_category`.`name` AS `category`, '
                . '`jero_users`.`alias` AS `alias`, `jero_articlestate`.`state` AS `state` '
                . 'FROM `jero_articles` '
                //Je joins la table jero_categorie pour récuperer ma catégorie
                . 'INNER JOIN `jero_category` ON `jero_articles`.`id_jero_category` = `jero_category`.`id` '
                //Je joins la table jero_users pour récuperer mon auteur 
                . 'INNER JOIN `jero_users` ON `jero_articles`.`id_jero_users` = `jero_users`.`id` '
                //Je joins la table jero_articlestate pour récuperer le statut de mon article
                . 'INNER JOIN `jero_articlestate` ON `jero_articles`.`id_jero_articlestate` = `jero_articlestate`.`id` '
                //Je prends l'artcle qui a comme id mon marqueur nominatif :id
                . 'WHERE `jero_articles`.`id`=:id';
        $queryResult = $this->db->prepare($query);
        // on attribue la valeur de l'article a sélectionner au marqueur nominatif :id
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on exécute la requéte
        $queryResult->execute();
         // retourne l'article correspondant grace a la fonction fetch
        return $queryResult->fetch(PDO::FETCH_OBJ);
    }

    //Méthode pour modifier un article via son id
    public function modifyArticleSelect() {
        // quand un article sera modifier sont état sera toujour 1 c 'est a dire remis en attente car l'admin doit validé les modifications
        $query = 'UPDATE `jero_articles` SET `title` = :title, `content` = :content, `id_jero_category` = :category, `id_jero_articlestate` = 1 '
                . 'WHERE `id` = :id';
        $queryResult = $this->db->prepare($query);
        //on associe les valeur de l'article a modifier et on associe l'id de l'article a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        $queryResult->bindValue(':title', $this->title, PDO::PARAM_STR);
        $queryResult->bindValue(':content', $this->content, PDO::PARAM_STR);
        $queryResult->bindValue(':category', $this->category, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
    
    //Méthode pour suprimer un article via son id
    public function deleteArticleSelect() {
        $query = 'DELETE FROM `jero_articles` WHERE `id`= :id';
        $queryResult = $this->db->prepare($query);
        // on attribue l'id de l'article a supprimer au marqueur  nominatif :id
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on exécute la requéte
        $queryResult->execute();
    }
    
    //Méthode pour récupérer un article via l'id de son auteur 
    public function getUserArticleList() {
         // on initialise un tableau a vide qui contiendra notre liste d'article par catégorie
        $result = array();
        $query = 'SELECT `jero_articles`.`id`, `jero_articles`.`title`, DATE_FORMAT (`jero_articles`.`date`, "%d/%m/%Y %H:%i:%s") AS `date`, `jero_articlestate`.`state` AS `state` '
                . 'FROM `jero_articles` '
                //Je joins la table jero_articlestate pour récuperer l'état des articles
                . 'INNER JOIN `jero_articlestate` ON `jero_articles`.`id_jero_articlestate` = `jero_articlestate`.`id` '
                // on recherche les articles qui ont id_jero_users qui correspond a l'id du rédacteur concernée
                . 'WHERE `jero_articles`.`id_jero_users`= :authorId '
                . 'ORDER BY `jero_articles`.`date` DESC';
        $queryResult = $this->db->prepare($query);
        // on associe le marqueur nominatif  a l'id du rédacteur correspondant
        $queryResult->bindValue(':authorId', $this->author, PDO::PARAM_INT);
        // on exécute la requéte
        $queryResult->execute();
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
             // on remplis les lignes de mon tableau grace a la fonction fetchAll avec le résultat de ma requéte
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des article pour le rédacteur concernée
        return $result;
    }
    // Méthode pour chercher les articles via leur titre
    public function getSearchByTitle() {
        $result = array();
        $query = 'SELECT `jero_articles`.`id`, `jero_articles`.`title`, DATE_FORMAT (`jero_articles`.`date`, "%d/%m/%Y %H:%i:%s") AS `date`, `jero_articlestate`.`state` AS `state` '
                . 'FROM `jero_articles` '
                . 'INNER JOIN `jero_articlestate` ON `jero_articles`.`id_jero_articlestate` = `jero_articlestate`.`id` '
                // on recherche la liste des titre d'article par rapport a la recherche insérer par l'utilisateur
                . 'WHERE `jero_articles`.`title` LIKE :search '
                . 'ORDER BY `jero_articles`.`title` DESC';
        // on prépare la requéte
        $queryResult = $this->db->prepare($query);
        // on associe la  recherche de l'utilisateur qui correspond au marquer nominatif correspondant
        // modulo signifie n'importe quelle chaine de caractére
        $queryResult->bindValue(':search', '%' . $this->title . '%', PDO::PARAM_STR);
        // on exécute la requéte
        $queryResult->execute();
        // on remplie le tableau des articles recherché grace a la  fonction fecth All
        $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        // on retourne le tableau de la liste des articles recherché par Titre
        return $result;
    }
    // Méthode pour récupérer la liste des articles validé
    public function getArticleList() {
        // on initialise un tableau a vide qui contiendra notre liste d'article
        $result = array();
        $query = 'SELECT `jero_articles`.`id`, `jero_articles`.`title`, DATE_FORMAT (`jero_articles`.`date`, "%d/%m/%Y %H:%i:%s") AS `date`, `jero_articles`.`content` '
                . 'FROM `jero_articles` '
                // on veut que id_jero_articlestate soit égal a 2 car cela correspond a un article valide 
                . 'WHERE `id_jero_articlestate` = 2 '
                . 'ORDER BY `jero_articles`.`date` DESC';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis mon tableau avec les articles validés grace a la fonction fetchAll
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des articles validé
        return $result;
    }
    // Méthode pour récupérer la liste des articles validé par catégorie
       public function getArticleListByCategory() {
       // on initialise un tableau a vide qui contiendra notre liste d'article par catégorie
        $result = array();
        $query = 'SELECT `jero_articles`.`id`, `jero_articles`.`title`, DATE_FORMAT (`jero_articles`.`date`, "%d/%m/%Y %H:%i:%s") AS `date`, `jero_articles`.`content` '
                . 'FROM `jero_articles` '
                // on veut que id_jero_articlestate soit égal a 2 car cela correspond a un article valide
                // on veut que id_jero_category soit égal la catégorie sélectionner par l'utilisateur 
                . 'WHERE `id_jero_articlestate` = 2 AND `id_jero_category` = :category '
                . 'ORDER BY `jero_articles`.`date` DESC';
        // on prépare la requéte
        $queryResult = $this->db->prepare($query);
        // on associe un marqueur nominatif a l'id_jero_category sélectioné
        $queryResult->bindValue(':category', $this->category, PDO::PARAM_INT);
        // on exécute la requéte
        $queryResult->execute();
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis mon tableau avec les articles validés et correspondant a la catégorie sélectionner grace a la fonction fetchAll
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des articles validé et correspondant a la catégorie sélectionner
        return $result;
    }
    
    // Méthode pour récupérer la liste des articles pour l'administrateur
    public function getArticleListAdmin() {
        // on initialise un tableau a vide qui contiendra notre liste d'article
        $result = array();
        $query = 'SELECT `jero_articles`.`id`, `jero_articles`.`title`, DATE_FORMAT (`jero_articles`.`date`, "%d/%m/%Y %H:%i:%s") AS `date`, `id_jero_articlestate` AS `status`'
                . 'FROM `jero_articles` '
                // on ordonne par status dans un premier temps puis par date 
                . 'ORDER BY `id_jero_articlestate` ,`jero_articles`.`date` ASC';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis mon tableau avec les articles validés grace a la fonction fetchAll
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des articles validé
        return $result;
    }

    // Méthode pour récupérer la liste des articles pour l'administrateur
    public function getArticleStatusListForAdmin() {
        // on initialise un tableau a vide qui contiendra notre liste de status d'article
        $result = array();
        $query = 'SELECT `jero_articlestate`.`id`, `jero_articlestate`.`state` '
                . 'FROM `jero_articlestate` '
                // on ordonne par status
                . 'ORDER BY `jero_articlestate`.`id`';
        // on exécute la requéte avec query car il n'y a pas de marqueur nominatif
        $queryResult = $this->db->query($query);
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            // on remplis mon tableau avec les articles validés grace a la fonction fetchAll
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne le tableau de la liste des articles validé
        return $result;
    }
    
    //Méthode pour modifier le statu d'un article via son id
    public function getModifyArticleStatusForAdmin() {
        //on change l'id_jero_articleState par celui voulu par l'administrateur
        $query = 'UPDATE `jero_articles` SET `id_jero_articlestate` = :articleState '
                . 'WHERE `id` = :id';
        $queryResult = $this->db->prepare($query);
        //on associe les valeur de l'article a modifier et on associe l'id de l'article a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        $queryResult->bindValue(':articleState', $this->state, PDO::PARAM_STR);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
}
