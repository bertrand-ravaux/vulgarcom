<?php include '../config.php'; ?>
<?php include '../controller/ctrlArticleCategoryList.php'; ?>
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
        <?php include 'navbar.php'; ?>
        <?php //Si on a aucun article pour cette catégorie 
        if (empty($articleList)) {
            ?>
            <div class="alert-danger errorCategory offset-3 col-6">IL n' y a pas d' article dans cette categorie</div>
            <?php
        } else {
            //sinon on parcours la liste de nos articles et on les affiche
            foreach ($articleList as $articleInfo) {
                ?>
                <div class="container articlePreview">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1">
                            <div class="">
                                <h1><?= $articleInfo->title ?></h1>
                                <?=
                                substr(htmlspecialchars_decode($articleInfo->content), 0, 310)
                                //substr permet de limiter le nombre de caracteres
                                //htmlspecialchars_decode permet de transformer les entités html en code html interprétable
                                ?>
                                <p>Posté le <?= $articleInfo->date ?></p>
                                <a href="articleShow.php?idArticle=<?= $articleInfo->id ?>">voir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
<?php include 'footer.php'; ?>
    </body>
</html>
