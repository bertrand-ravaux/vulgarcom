<?php
// on instancie un objet articles
//on récupére l'id de l'article a affiché
// on éxécute la méthode pour récupérer les informations de l'article sélectionner
//et je les stocke dans $articlesInfo
if (isset($_GET['idArticle'])) {
    $articles = new articles();
    $articles->id = $_GET['idArticle'];
    $articlesInfo = $articles->getArticlesSelect();
}
?>

