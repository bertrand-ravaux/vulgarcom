<?php

class comments {

    public $id = 0;
    public $date = '0000-00-00 00:00:00';
    public $content = '';
    public $author = 0;
    public $article = 0;
    public $state = 0;
    public $mainComment = 0;
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=vulgarcom;charset=utf8', 'ravaux', 'Ravaux.02');
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    //Méthode pour créer un commentaire
    public function createComment() {
        $query = 'INSERT INTO `jero_comments` (`date`,`content`, `id_jero_users`, `id_jero_articles`,`id_jero_commentstate`) '
                //quand je créer un commentaire son état sera toujour l'id 1 c'est a dire le commentaire est valide
                . 'VALUES (:date, :content, :authorId, :articleId, 1)';
        $queryResult = $this->db->prepare($query);
        // on attribue les valeur du commentaire a créer au marqueur nominatif :date :content :authorId :articleId
        $queryResult->bindValue(':date', $this->date, PDO::PARAM_STR);
        $queryResult->bindValue(':content', $this->content, PDO::PARAM_STR);
        $queryResult->bindValue(':authorId', $this->author, PDO::PARAM_INT);
        $queryResult->bindValue(':articleId', $this->article, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
        // Méthode pour créer un sous commentaire
        public function createSubComment() {
        $query = 'INSERT INTO `jero_comments` (`date`,`content`, `id_jero_users`, `id_jero_articles`,`id_jero_comments`,`id_jero_commentstate`) '
                //quand je créer un commentaire son état sera toujour l'id 1 c'est a dire le commentaire est valide
                . 'VALUES (:date, :content, :authorId, :articleId, :mainComment, 1)';
        $queryResult = $this->db->prepare($query);
        // on attribue les valeur du commentaire a créer au marqueur nominatif :date :content :authorId :articleId :mainComment
        $queryResult->bindValue(':date', $this->date, PDO::PARAM_STR);
        $queryResult->bindValue(':content', $this->content, PDO::PARAM_STR);
        $queryResult->bindValue(':authorId', $this->author, PDO::PARAM_INT);
        $queryResult->bindValue(':articleId', $this->article, PDO::PARAM_INT);
        $queryResult->bindValue(':mainComment', $this->mainComment, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
    //Méthode permettant d'obetnir la liste des commentaires d'un article.
    public function getCommentList() {
        $query = 'SELECT `jero_comments`.`id`, `jero_comments`.`date`, `jero_comments`.`content`,`jero_users`.`alias`,`jero_status`.`status`, `jero_comments`.`id_jero_comments` AS `mainComment` '
                . 'FROM `jero_comments` '
                //Je joins la table jero_users pour récuperer le nom de l'utilisateur
                . 'INNER JOIN `jero_users` ON  `jero_comments`.`id_jero_users` = `jero_users`.`id` '
                //Je joins la table jero_status pour récuperer le grade de l'utilisateur
                . 'INNER JOIN `jero_status` ON  `jero_users`.`id_jero_status` = `jero_status`.`id` '
                // on recherche les commentaires qui ont id_jero_articles qui correspond a l'id de l'article concerné,
                // et id_jero_commenstate vaut 1, et qui ont id_jero_comment nul ce qui correspond a un commentaire
                . 'WHERE `jero_comments`.`id_jero_articles` = :articleId AND `jero_comments`.`id_jero_commentstate` = 1 AND `jero_comments`.`id_jero_comments` IS NULL '
                . 'ORDER BY `jero_comments`.`date` DESC';
        $queryResult = $this->db->prepare($query);
        // on attribue la valeur de l'article sélectionné au marqueur nominatif :articleId
        $queryResult->bindValue(':articleId', $this->article, PDO::PARAM_INT);
        $queryResult->execute();
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne la liste des sous-commentaires pour l'article concerné
        return $result;
    }
        //Méthode permettant d'obetnir la liste des sous-commentaires d'un article.
        public function getSubCommentList() {
        $query = 'SELECT `jero_comments`.`id`, `jero_comments`.`date`, `jero_comments`.`content`,`jero_users`.`alias`,`jero_status`.`status`, `jero_comments`.`id_jero_comments` AS `mainComment` '
                . 'FROM `jero_comments` '
                //Je joins la table jero_users pour récuperer le nom de l'utilisateur
                . 'INNER JOIN `jero_users` ON  `jero_comments`.`id_jero_users` = `jero_users`.`id` '
                //Je joins la table jero_status pour récuperer le grade de l'utilisateur
                . 'INNER JOIN `jero_status` ON  `jero_users`.`id_jero_status` = `jero_status`.`id` '
                // on recherche les commentaires qui ont id_jero_articles qui correspond a l'id de l'article concerné,
                // et id_jero_commenstate vaut 1, et qui ont id_jero_comment non nul ce qui correspond à un sous commentaire
                . 'WHERE `jero_comments`.`id_jero_articles` = :articleId AND `jero_comments`.`id_jero_commentstate` = 1 AND `jero_comments`.`id_jero_comments` IS NOT NULL '
                . 'ORDER BY `jero_comments`.`date` ASC';
        $queryResult = $this->db->prepare($query);
        // on attribue la valeur de l'article sélectionné au marqueur nominatif :articleId
        $queryResult->bindValue(':articleId', $this->article, PDO::PARAM_INT);
        $queryResult->execute();
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne la liste des sous-commentaires pour l'article concerné
        return $result;
    }
    
    //Méthode pour modifier un commentaire via son id
    public function modifyComments() {
        $query = 'UPDATE `jero_comments` SET `jero_comments`.`content` = :content WHERE `jero_comments`.`id` = :id ';
        $queryResult = $this->db->prepare($query);
        //on associe les valeur du commentaire a modifier et on associe l'id de l'article a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        $queryResult->bindValue(':content', $this->content, PDO::PARAM_STR);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
    
    //Méthode pour suprimer un commentaire via son id
    public function deleteComments() {
        $query = 'DELETE FROM `jero_comments` WHERE `id`= :id';
        $queryResult = $this->db->prepare($query);
        // on attribue l'id du commentaire a supprimer au marqueur  nominatif :id
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
    
    //Méthode permettant d'obetnir la liste des top commentaires d'un article.
    public function getTopCommentList() {
        $query = 'SELECT `jero_comments`.`id`, `jero_comments`.`date`, `jero_comments`.`content`,`jero_users`.`alias`,`jero_status`.`status`, `jero_comments`.`id_jero_comments` AS `mainComment` '
                . 'FROM `jero_comments` '
                //Je joins la table jero_users pour récuperer le nom de l'utilisateur
                . 'INNER JOIN `jero_users` ON  `jero_comments`.`id_jero_users` = `jero_users`.`id` '
                //Je joins la table jero_status pour récuperer le grade de l'utilisateur
                . 'INNER JOIN `jero_status` ON  `jero_users`.`id_jero_status` = `jero_status`.`id` '
                // on recherche les commentaires qui ont id_jero_articles qui correspond a l'id de l'article concerné,
                // et id_jero_commenstate vaut 2 qui correspond a un top commentaire,
                //  et qui ont id_jero_comment null ce qui correspond a un commentaire
                . 'WHERE `jero_comments`.`id_jero_articles` = :articleId AND `jero_comments`.`id_jero_commentstate` = 2 AND `jero_comments`.`id_jero_comments` IS NULL '
                . 'ORDER BY `jero_comments`.`date` DESC';
        $queryResult = $this->db->prepare($query);
        // on attribue la valeur de l'article sélectionné au marqueur nominatif :articleId
        $queryResult->bindValue(':articleId', $this->article, PDO::PARAM_INT);
        $queryResult->execute();
        // on vérifie que le résultat de la requéte est un objet
        if (is_object($queryResult)) {
            $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
        }
        // on retourne la liste des sous-commentaires pour l'article concerné
        return $result;
    }
    
    //Méthode pour mettre en avant un commentaire via son id
    public function topComments() {
        $query = 'UPDATE `jero_comments` SET `jero_comments`.`id_jero_commentstate` = 2 WHERE `jero_comments`.`id` = :id ';
        $queryResult = $this->db->prepare($query);
        //on associe les valeur du commentaire a modifier et on associe l'id de l'article a modifier
        $queryResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        // on retourne le résultat de la requéte pour savoir si elle c'est bien exécuter
        return $queryResult->execute();
    }
}
?>