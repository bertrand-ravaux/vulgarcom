<?php include '../config.php' ?>
<?php include '../controller/ctrlArticleManagement.php' ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Vulgarcom</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/ckeditor/ckeditor.js" ></script>
        <script type="text/javascript" src="../assets/ckeditor/adapters/jquery.js" ></script>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="shortcut icon" type="image/png" href="../assets/img/favIconh2o.ico"/>
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div class="container userError">
        <?php if ($isSucessModify) { ?>
            <div class="alert alert-success col-10 offset-1">L'article a était modifier </div>   
        <?php } if ($isErrorModify) { ?>
            <div class="alert alert-danger col-10 offset-1"> La modification de l'article a échoué  </div>
        <?php } ?>
        </div>
        <form method="POST" action="#" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 offset-xl-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 titleArticle">
                        <label for="title">Titre de votre aticle :</label>
                        <input type="text" name="title" class="title" value="<?= $articlesInfo->title //Si on a des $error on les affiche?>"><br/>
                         <p class="text-danger"><?= isset($error['title']) ? $error['title'] : '' ?></p>
                    </div>
                </div>
                <div class=" col-12 addContent">
                    <label for="content">Rédiger votre article :</label>
                    <textarea class="content" name="content" rows="5" cols="33" ><?= $articlesInfo->content ?></textarea>
                    <p class="text-danger"><?= isset($error['content']) ? $error['content'] : '' ?></p>
                </div>
                <div class="row">
                    <div class="col-xl-5 offset-xl-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-10 offset-1 categoryList">
                        <label for="category">Catégorie de votre article :</label>
                        <select name="category">
                            <option value="0"></option>
                            <?php
                            //On parcours la liste des catégories, si la catégorie est celle de l'article on la sélectionne par défaut
                            foreach ($categoryList as $category) {
                                ?>
                                <option value="<?= $category->id ?>" <?= $category->name == $articlesInfo->category ? 'selected="selected"' : '' ?>><?= $category->name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="text-danger"><?= isset($error['category']) ? $error['category'] : '' ?></p>
                    </div>
                </div>
                <div class="row stateDateArticle">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-5 offset-sm-1 col-5 offset-1 dateArticle">
                        <p>Article posté le <?= $articlesInfo->date ?></p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 offset-sm-1 col-4 offset-1 stateArticle">
                        <p> L'article est <?= $articlesInfo->state ?></p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-5 offset-sm-1 col-5">
                            <button type="submit" name="modifySubmit" class="modifyArticles btn btn-primary">Modifier</button>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 offset-sm-1 col-4 offset-1">
                            <button type="submit" name="deleteArticleSubmit" class="deleteArticles btn btn-danger">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php include 'footer.php' ?>
        <script src="../assets/js/wysiwyg.js"></script>
    </body>
</html>
