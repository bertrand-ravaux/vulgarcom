<?php

$isErrorComments = FALSE;
$isSucessComments = FALSE;
$commentError = array();

// si le bouton pour soumettre un commentaire existe
if (isset($_POST['submitComment'])) {
    //si mon contenu n'est pas vide
    // j'initialise ma variable avec le POST title qui correspond au titre insérer
    if (!empty($_POST['content'])) {
        $content = htmlspecialchars($_POST['content']);
    } else {
        //sinon je stocke un message d'erreur
        $commentError['content'] = 'vous ne pouvez pas poster un commentaire vide';
    }
    // si le compte de mais erreur et égal a 0
    // j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
    // je remplie les attribut de mon objet avec les données du POST correspondant
    // je remplie l'attribut article avec les données du GET correspondant
    // la fonction date () donne la date et l'heure a laquelle mon commentaire et créer
    // on récupére la super globale session userId qui correspond a l'utilisateur qui vient de d'écrire le commentaire
    if (count($commentError) == 0) {
        $comment = new comments();
        $comment->date = date("Y-m-d H:i:s");
        $comment->content = $content;
        $comment->author = $_SESSION['userId'];
        $comment->article = $_GET['idArticle'];
        // si mon commentaire et bien créer $isSucess
        if ($comment->createComment()) {
            $isSucessComments = TRUE;
        } else {
            //sinon $isError
            $isErrorComments = TRUE;
        }
    }
}

// si le bouton pour modifier un commentaire existe
//elle est aussi utilisée pour les sous commentaires
if (isset($_POST['modifyComment'])) {
    //si mon contenu n'est pas vide
    // j'initialise ma variable avec le POST content qui correspond au contenu modifer
    if (!empty($_POST['content'])) {
        $content = htmlspecialchars($_POST['content']);
    } else {
        //sinon je stocke un message d'erreur
        $commentError['content'] = 'vous ne pouvez pas poster un commentaire vide';
    }
    // si le compte de mais erreur et égal a 0
    // j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
    // je remplie les attribut de mon objet avec les données du POST correspondant
    // je remplie l'attribut article avec les données du GET correspondant
    // on récupére la super globale session userId qui correspond a l'utilisateur qui vient de d'écrire le commentaire
    if (count($commentError) == 0) {
        $comment = new comments();
        $comment->id = $_POST['commentId'];
        $comment->content = $content;
        $comment->author = $_SESSION['userId'];
        // si mon commentaire et bien modifier $isSucess
        if ($comment->modifyComments()) {
            $isSucessComments = TRUE;
        } else {
            //sinon $isError
            $isErrorComments = TRUE;
        }
    }
}

// si le bouton pour supprimer un commentaire existe
//elle est aussi utilisée pour les sous commentaires
if (isset($_POST['deleteComment'])) {
        // j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
        // je remplie les attribut de mon objet avec les données du POST correspondant
        $comment = new comments();
        $comment->id = $_POST['commentId'];
        // si mon commentaire et bien supprimer $isSucess
        if ($comment->deleteComments()) {
            $isSucessComments = TRUE;
        } else {
            //sinon $isError
            $isErrorComments = TRUE;
        }
}
// si le bouton pour soumette un sous commentaire existe
if (isset($_POST['submitSubComment'])) {
    //si mon contenu n'est pas vide
    // j'initialise ma variable avec le POST contenu qui correspond au contenu insérer
    if (!empty($_POST['content'])) {
        $content = htmlspecialchars($_POST['content']);
    } else {
        //sinon je stocke un message d'erreur
        $commentError['content'] = 'vous ne pouvez pas poster un commentaire vide';
    }
        // si le compte de mais erreur et égal a 0
    // j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
    // je remplie les attribut de mon objet avec les données du POST correspondant
    // je remplie l'attribut article avec les données du GET correspondant
    // la fonction date () donne la date et l'heure a laquelle mon sous-commentaire et créer
    // on récupére la super globale session userId qui correspond a l'utilisateur qui vient de d'écrire le sous-commentaire
    if (count($commentError) == 0) {
        $comment = new comments();
        $comment->date = date("Y-m-d H:i:s");
        $comment->content = $content;
        $comment->author = $_SESSION['userId'];
        $comment->article = $_GET['idArticle'];
        $comment->mainComment = $_POST['mainComment'];
        // si mon sous-commentaire et bien créer $isSucess
        if ($comment->createSubComment()) {
            $isSucessComments = TRUE;
        } else {
            //sinon $isError
            $isErrorComments = TRUE;
        }
    }
}
if (isset($_POST['topComment'])) {
        // j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
        // je remplie les attribut de mon objet avec les données du POST correspondant
        $comment = new comments();
        $comment->id = $_POST['commentId'];
        // si mon commentaire est bien mis en avant $isSucess
        if ($comment->topComments()) {
            $isSucessComments = TRUE;
        } else {
            //sinon $isError
            $isErrorComments = TRUE;
        }
}
// j'instancie un nouvelle objet comments le new fait appele a la méthode magique __construct
$comment = new comments();
//on recupere l'id de l'article des commentaire a afficher
$comment->article = $_GET['idArticle'];
//on recupere la liste des top commentaires
$topCommentsList = $comment->getTopCommentList();
//on recupere la liste des commentaires
$commentsList = $comment->getCommentList();
//on recupere la liste des sous commentaires
$subCommentsList = $comment->getSubCommentList();

