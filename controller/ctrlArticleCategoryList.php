<?php
// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$article = new articles();
// je remplie l' attribut de mon objet avec la donnée du GET correspondant c'est  a dire la categorie sélectioner par l'utilisateur
$article->category = $_GET['category'];
// je stocke le resultat de  getArticleListByCategory() dans $articleList
$articleList = $article->getArticleListByCategory();


