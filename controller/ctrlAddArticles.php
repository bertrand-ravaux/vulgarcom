<?php
// si l'utilisateur n'est pas connecté on le retourne a la page index
if (!isset($_SESSION['userRank'])){
    header('Location:index.php');
// sinon si l'utilisateur n 'est pas administateur ou rédacteur on le renvoie a la page index
}else if ($_SESSION['userRank'] != 2 && $_SESSION['userRank'] != 1) {
     header('Location:index.php');   
}

$formErrors = array();
$isSucess = FALSE;
$isError = FALSE;
// si le bouton pour soumette un article existe
if (isset($_POST['articleSubmit'])) {
    //si mon titre n'est pas vide
    // j'initialise ma variable avec le POST title qui correspond au titre insérer
    if (!empty($_POST['title'])) {
            $title = htmlspecialchars($_POST['title']);
    } else {
        //sinon je stocke un message d'erreur
        $formErrors['title'] = 'Veuillez insérez un titre';
    }
    //si mon  contenu n'est pas vide
    //j'initialise ma variable avec le POST content qui correspond au contenu insérer
    if (!empty($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
    } else {
    // sinon je stocke un message d'erreur
        $formErrors['content'] = 'le champs est vide';
    }
    // si ma categorie est différent de 0
    //j'initialise ma variable avec les POST category qui correspond a la la catégorie séléctionner
    if ($_POST['category'] != 0) {
            $category = $_POST['category'];
    } else {
        // sinon je stocke un message d'erreur
        $formErrors['category'] = 'Veuillez choisir une catégorie';
    }
    // si le compte de mais erreur et égal a 0
    // j'instancie un nouvelle objet articles le new fait appele a la méthode magique __construct
    // je remplie les attribut de mon objet avec les données du POST correspondant
    //  la fonction date () donne la date et l'heure a laquelle mon article et créer
    // on récupére la super globale session userId qui correspond au rédacteur qui vient de d'écrire l'article
    if (count($formErrors) == 0) {
        $articles = new articles();
        $articles->title = $title;
        $articles->content = $content;
        $articles->category = $category;
        $articles->date =  date('Y-m-d H:i:s');
        $articles->author = $_SESSION['userId'];
        // si mon article et bien créer $isSucess
        if ($articles->createArticles()) {
            $isSucess = TRUE;
        } else {
            //sinon $isError
            $isError = TRUE;
        }
    }
}
// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$category = new articles();
// je stocke le resultat de getCategoriesList () dans $categoryList
$categoryList = $category->getCategoriesList();
?>