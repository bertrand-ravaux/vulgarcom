<?php 
// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$article = new articles();
// je stocke le resultat de  getArticleList() dans $articleList
$articleList = $article->getArticleList();
