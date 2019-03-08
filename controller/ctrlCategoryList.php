<?php
// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$category = new articles();
// je stocke le resultat de  getCategoriesList() dans $articleList
$categoriesList = $category->getCategoriesList();

