<?php

$isSucess = FALSE;
$isError = FALSE;

// si l'utilisateur n'est pas connecté on le retourne a la page index
if (!isset($_SESSION['userRank'])) {
    header('Location:index.php');
    // sinon si l'utilisateur n 'est pas administateur on le renvoie a la page index
} else if ($_SESSION['userRank'] != 1) {
    header('Location:index.php');
}

// je vérifie que le post de validation de mon formulaire existe 
if (isset($_POST['updateArticleStatus'])) {
    $article = new articles();
    $article->id = $_POST['articleId'];
    $article->state = $_POST['articleState'];
    //si le statut de mon article est bien modifié
    if ($article->getModifyArticleStatusForAdmin()) {
        // on met le booleen a true  pour avoir le message de succés
        $isSucess = TRUE;
    } else {
        // on met le booleen a true  pour avoir le message d'erreur
        $isError = TRUE;
    }
}

// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
//on récupére la liste des articles a affiché dans $articleList
//et on recupere la liste des status des articles dans $articleStateList
$article = new articles();
// je stocke le resultat de  getArticleListAdmin() dans $articleList
$articleList = $article->getArticleListAdmin();
// je stocke le resultat de  getArticleStatusListForAdmin() dans $articleList
$articleStateList = $article->getArticleStatusListForAdmin();
?>
