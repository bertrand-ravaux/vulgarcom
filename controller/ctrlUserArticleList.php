<?php
// si l'utilisateur n'est pas connecté on le retourne a la page index
if (!isset($_SESSION['userRank'])){
    header('Location:index.php');
// sinon si l'utilisateur n 'est pas administateur ou rédacteur on le renvoie a la page index
}else if ($_SESSION['userRank'] != 2 && $_SESSION['userRank'] != 1) {
     header('Location:index.php');   
}

//On crée une regex pour la recherche
$regexName = '/^[a-zA-Z\- ]+$/';

// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$article = new articles();
$article->author = $_SESSION['userId'];
// je stocke le resultat de  getUserArticleList() dans $articleList
$articleList = $article->getUserArticleList();
//Si on a une recherche on affiche la recherche
if (!empty($_GET['search'])) {
    if (preg_match($regexName, $_GET['search'])) {
        $article->title = htmlspecialchars($_GET['search']);
        $articleList = $article->getSearchByTitle();
    }
}
   

