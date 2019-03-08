<?php
$isSucessModify = FALSE;
$isErrorModify = FALSE;
$Error = array();
// je vérifie que le post de modification de mon article existe
if (isset($_POST['modifySubmit'])) {
    //si mon titre n'est pas vide
    // htmlspecialchars remplace les charactére spéciaux par des entités html
    // j'initialise ma variable avec le POST title qui correspond au titre modifier
    if (!empty($_POST['title'])) {
        $title = htmlspecialchars($_POST['title']);
    } else {
        //sinon je stocke un message d'erreur
        $Error['title'] = 'Veuillez insérez un titre';
    }
    //si mon contenu n'est pas vide
    // j'initialise ma variable avec le POST content qui correspond au contenu modifier
    if (!empty($_POST['content'])) {
        $content = htmlspecialchars($_POST['content']);
    } else {
        //sinon je stocke un message d'erreur
        $Error['content'] = 'le champs est vide';
    }
    // si ma categorie est différent de 0
    //j'initialise ma variable avec les POST category qui correspond a la la catégorie séléctionner
    if ($_POST['category'] != 0) {
        $category = $_POST['category'];
    } else {
        //sinon je stocke un message d'erreur
        $Error['category'] = 'Veuillez choisir une catégorie';
    }
    // si le compte de mais erreur et égal a 0
    // j'instancie un nouvelle objet articles le new fait appele a la méthode magique __construct
    // je remplie l'attribut de mon objet avec l'id de l'article a modifier
    // je remplie les attribut de mon objet avec les données du POST correspondant
    if (count($Error) == 0) {
        $articles = new articles();
        $articles->id = $_GET['articleId'];
        $articles->title = $title;
        $articles->content = $content;
        $articles->category = $category;
       // si mon article et bien modifier $isSucessModify 
        if ($articles->modifyArticleSelect()) {
            $isSucessModify = TRUE;
        } else {
            //sinon $isErrorModify
            $isErrorModify = TRUE;
        }
    }
}

 // j'instancie un nouvelle objet articles le new fait appele a la méthode magique __construct
$articles = new articles();
// je remplie l'attribut de mon objet avec l'id de l'article a modifier
$articles->id = $_GET['articleId'];
// je stocke le resultat de getArticlesSelect() dans $articlesInfo
$articlesInfo = $articles->getArticlesSelect();
// je stocke le resultat de getCategoriesList () dans $categoryList
$categoryList = $articles->getCategoriesList();

// je vérifie que le post de suppresion existe
if (isset($_POST['deleteArticleSubmit'])) {
     // j'instancie un nouvelle objet articles le new fait appele a la méthode magique __construct
    $article = new articles();
    // je remplie l'attribut de mon objet avec l'id de l'article a supprimer
    $article->id = $_GET['articleId'];
    //supprime la ligne correspondant a l'article dans la base de données
    $article->deleteArticleSelect();
}
