<?php include '../config.php' ?>
<?php include '../controller/ctrlShowArticles.php' ?>
<?php include '../controller/ctrlComment.php' ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Vulgarcom</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="shortcut icon" type="image/png" href="../assets/img/favIconh2o.ico"/>
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-xs-10 offset-xs-1">
                    <div class="articleShow">
                        <div class="row">
                            <div class="col-12 ">
                                <h1><?= $articlesInfo->title //on récupere le titre ?></h1>
                            </div>
                        </div>
                        <div class=" col-12 text-danger">
                            <p>Catégorie : <?= $articlesInfo->category //on récupère la catégorie ?></p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div><?= htmlspecialchars_decode($articlesInfo->content) //Je décode le contenu de mon article pour l'afficher ?></div>
                            </div>
                        </div>
                        <p> Posté le <?= $articlesInfo->date //on récupère la date de création ?> <?= $articlesInfo->alias //On récupère l'auteur' ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <?php if ($isSucessComments) { //Message de succes?>
                <div class="alert alert-success col-6">Votre commentaire a bien été enregistré </div>   
            <?php } if ($isErrorComments) { //Message en cas d'erreur'?>
                <div class="alert alert-danger col-5"> Une erreur est survenue </div>
            <?php } if (isset($commentError['content'])) { ?>
                <div class=" alert alert-danger col-6"><?= $commentError['content'] ?></div>
            <?php } ?>
        </div>
        <?php
        //Je parcours ma liste de top commentaires
        foreach ($topCommentsList as $topComments) {
            //Si le commentaire n'a pas de mainComment
            if ($topComments->mainComment == NULL) {
                ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-12">
                            <div class="showComment">
                                <!-- Champ hidden pour l'id du commentaire--> 
                                <input type="hidden" class="commentId" name="commentId" value="<?= $topComments->id //on récupère l'id' ?>"/>
                                <p>A <?= $topComments->date //on récupère la date de création  ?> <?= $topComments->status //le grade ?> <?= $topComments->alias //l'auteur'            ?></p>
                                <p class="content"><?= $topComments->content ?></p>
                                <?php
                                if (isset($_SESSION['userAlias'])) {
                                    if ($topComments->alias == $_SESSION['userAlias']) { //Si l'utilisateur est l'auteur il peut modifier le commentaire 
                                        ?>
                                        <button class="modifyContent btn btn-primary"  type="button" >Modifier !</button>
                                        <?php
                                    } if ($topComments->alias == $_SESSION['userAlias'] || $_SESSION['userRank'] == 3 || $_SESSION['userRank'] == 1) {
                                        //Si l'utilisateur est l'auteur ou un administrateur ou modérateur il peut supprimer le commentaire'
                                        ?>
                                        <form method="POST" action="#">
                                            <input type="hidden" class="commentId" name="commentId" value="<?= $topComments->id //On récupère l'id'            ?>"/>
                                            <button class="deleteComment btn btn-danger" name="deleteComment"  type="submit">Supprimer !</button>
                                        </form>
                                        <?php
                                    }
                                }
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="offset-xl-1 col-xl-6 offset-lg-1 col-lg-6 offset-md-1 col-md-8 col-sm-9 offset-sm-1 col-sm-9">
                            <?php
                            //On parcours la liste des sous commentaires
                            foreach ($subCommentsList as $subComment) {
                                //Si c'est un sous-commentaire du commentaire en cours
                                if ($subComment->mainComment == $topComments->id) {
                                    ?>
                                    <div class="showSubComment">
                                        <input type="hidden" class="commentId" name="commentId" value="<?= $subComment->id //on récupère l'id' ?>"/>
                                        <p>Posté le <?= $subComment->date //la date de création ?> <?= $subComment->status //le grade ?> <?= $subComment->alias //l'auteur'?></p>
                                        <p class="content"><?= $subComment->content ?></p>
                                        <?php
                                        if (isset($_SESSION['userAlias'])) {
                                            if ($subComment->alias == $_SESSION['userAlias']) { //Si l'utilisateur est l'auteur il peut modifier le sous-commentaire  
                                                ?>
                                                <button class="modifyContent btn btn-primary" type="button" >Modifier !</button>
                                            <?php } ?>
                                            <?php
                                            if ($subComment->alias == $_SESSION['userAlias'] || $_SESSION['userRank'] == 3 || $_SESSION['userRank'] == 1) {
                                                //Si l'utilisateur est l'auteur ou un administrateur ou modérateur il peut supprimer le commentaire
                                                ?>
                                                <form method="POST" action="#">
                                                    <input type="hidden" id="commentId" name="commentId" value="<?= $subComment->id //on recupere l'id du sous-commentaire'          ?>"/>
                                                    <button class="deleteComment btn btn-danger" name="deleteComment" type="submit">Supprimer !</button>
                                                </form>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </div>
                                    <?php
                                }
                            }
                            //Si l'utilisateur est connecté il peut ajouter un sous-commentaire
                            if (isset($_SESSION['userAlias'])) {
                                ?> 
                                <div class="subCommentZone">
                                    <form method="POST" action="#">
                                        <textarea placeholder="Insérer un sous commentaire" name="content"></textarea>
                                        <input type="hidden" name="mainComment" value="<?= $topComments->id ?>"/>
                                        <button type="submit" name="submitSubComment" class="btn btn-primary">Envoyer !</button>
                                    </form>
                                </div>
                            <?php } else { //Sinon on lui demande de se connecter pour répondre    ?>
                                <div class="connectionCommentRequired">
                                    <div class=" alert alert-danger col-6 offset-1">Veuillez vous connectez pour répondre</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        foreach ($commentsList as $comments) {
            //Si le commentaire n'a pas de mainComment
            if ($comments->mainComment == NULL) {
                ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
                            <div class="showComment">
                                <!-- Champ hidden pour l'id du commentaire--> 
                                <input type="hidden" class="commentId" name="commentId" value="<?= $comments->id //on récupère l'id'          ?>"/>
                                <p>A <?= $comments->date //on récupère la date de création          ?> <?= $comments->status //le grade          ?> <?= $comments->alias //l'auteur'          ?></p>
                                <p class="content"><?= $comments->content ?></p>
                                <?php
                                if (isset($_SESSION['userAlias'])) {
                                    if ($comments->alias == $_SESSION['userAlias']) { //Si l'utilisateur est l'auteur il peut modifier le commentaire 
                                        ?>   
                                            <button class="modifyContent btn btn-primary"  type="button" >Modifier !</button>
                                        <?php
                                    } if ($comments->alias == $_SESSION['userAlias'] || $_SESSION['userRank'] == 3 || $_SESSION['userRank'] == 1) {
                                        //Si l'utilisateur est l'auteur ou un administrateur ou modérateur il peut supprimer le commentaire'
                                        ?>
                                            <form method="POST" action="#">
                                                <input type="hidden" class="commentId" name="commentId" value="<?= $comments->id //On récupère l'id'          ?>"/>
                                                <button class="deleteComment btn btn-danger" name="deleteComment"  type="submit">Supprimer !</button>
                                            </form>
                                        <?php
                                    }

                                    if ($_SESSION['userRank'] == 3 || $_SESSION['userRank'] == 1) {
                                        ?>
                                        <form method="POST" action="#">
                                            <input type="hidden" class="commentId" name="commentId" value="<?= $comments->id //On récupère l'id'          ?>"/>
                                            <button class="deleteComment btn btn-success" name="topComment"  type="submit">Mettre en avant !</button>
                                        </form>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="offset-xl-1 col-xl-6 offset-lg-1 col-lg-6 offset-md-1 col-md-8 col-sm-9 offset-sm-1 col-11 offset-1">
                            <?php
                            //On parcours la liste des sous commentaires
                            foreach ($subCommentsList as $subComment) {
                                //Si c'est un sous-commentaire du commentaire en cours
                                if ($subComment->mainComment == $comments->id) {
                                    ?>
                                    <div class="showSubComment">
                                        <input type="hidden" class="commentId" name="commentId" value="<?= $subComment->id //on récupère l'id'?>"/>
                                        <p>Posté le <?= $subComment->date //la date de création          ?> <?= $subComment->status //le grade          ?> <?= $subComment->alias //l'auteur'          ?></p>
                                        <p class="content"><?= $subComment->content ?></p>
                                        <?php
                                        if (isset($_SESSION['userAlias'])) {
                                            if ($subComment->alias == $_SESSION['userAlias']) { //Si l'utilisateur est l'auteur il peut modifier le sous-commentaire   
                                                ?>
                                                <button class="modifyContent btn btn-primary" type="button" >Modifier !</button>
                                            <?php } ?>
                                            <?php
                                            if ($subComment->alias == $_SESSION['userAlias'] || $_SESSION['userRank'] == 3 || $_SESSION['userRank'] == 1) {
                                                //Si l'utilisateur est l'auteur ou un administrateur ou modérateur il peut supprimer le commentaire
                                                ?>
                                                <form method="POST" action="#">
                                                    <input type="hidden" id="commentId" name="commentId" value="<?= $subComment->id //on recupere l'id du sous-commentaire'  ?>"/>
                                                    <button class="deleteComment btn btn-danger" name="deleteComment" type="submit">Supprimer !</button>
                                                </form>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </div>
                                    <?php
                                }
                            }
                            //Si l'utilisateur est connecté il peut ajouter un sous-commentaire
                            if (isset($_SESSION['userAlias'])) {
                                ?> 
                                <div class="subCommentZone">
                                    <form method="POST" action="#">
                                        <textarea placeholder="Insérer un sous commentaire" name="content"></textarea>
                                        <input type="hidden" name="mainComment" value="<?= $comments->id ?>"/>
                                        <button type="submit" name="submitSubComment" class="btn btn-primary">Envoyer !</button>
                                    </form>
                                </div>
                            <?php } else { //Sinon on lui demande de se connecter pour répondre     ?>
                                <div class="connectionCommentRequired">
                                    <p class="alert alert-danger col-6 offset-1">Veuillez vous connectez pour répondre</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
//Si l'utilisateur est connecté il peut ajouter un commentaire
        if (isset($_SESSION['userAlias'])) {
            ?>
            <div class="container commentZoneCont">
                <div class="row">
                    <div class="col-4 offset-1">
                        <div class="commentZone">
                            <form method="POST" action="#">
                                <textarea placeholder="Insérer un commentaire" name="content"></textarea>
                                <button type="submit" name="submitComment" class="btn btn-primary submitCom">Envoyer !</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { //Sinon on lui demande de se connecter pour commenter      ?>
            <div class="connectionCommentRequired">
                <p class=" alert alert-danger col-6 offset-1">Veuillez vous connectez pour commenter</p>
            </div>
        <?php } ?>
        <?php include 'footer.php' ?>
        <script type="text/javascript" src="../assets/js/comment.js"></script>
    </body>
</html>

