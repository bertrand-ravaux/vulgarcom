<?php include '../config.php' ?>
<?php include '../controller/ctrlAddArticles.php' ?>
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
        <link rel="shortcut icon" type="image/png" href="../assets/img/favIconh2o.ico"/>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div class="container articleError">
            <?php if ($isSucess) { ?>
                <div class="alert alert-success col-6">Votre article a été posté </div>   
            <?php } if ($isError) { ?>
                <div class="alert alert-danger col-6"> Désolé votre article n'a pas été enregistré </div>
            <?php } ?>
        </div>
        <form method="POST" action="#" enctype="multipart/form-data">
            <!-- je déclare un container pour la grille bootstrap aussi fonctionner  -->
            <div class="container">
                <!-- je déclare une ligne pour que tous les élément soit afficher en ligne -->
                <div class="row">
                    <!-- jé déclare des col pour que  les éléments soit verticalement responsive  -->
                    <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 titleStyle">
                        <label for="title">Titre de votre aticle :     </label>
                        <input type="text" name="title" class="title" >
                        <p class="text-danger"><?= isset($formErrors['title']) ? $formErrors['title'] : '' ?></p>
                    </div>
                </div>
                <div class="col-12 addContent">
                    <label for="content">Rédiger votre article :</label>
                    <textarea class="content" name="content" rows="5" cols="33"></textarea>
                    <p class="text-danger"><?= isset($formErrors['content']) ? $formErrors['content'] : '' ?></p>
                </div>
                <div class="row">
                    <div class="col-xl-5 offset-xl-3 col-lg-5 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-10 offset-1 addCategory">
                        <label for="category">Catégorie de votre article :</label>
                        <select name="category">
                            <option value="0"></option>
                            <?php
                            // on parcours notre tableau $categoryList  en stockant chaque ligne dans $category
                            foreach ($categoryList as $category) {
                                // on injecte les données de $category dans les balise option de notre select pour avoir notre liste de catégorie 
                                ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>   
                            <?php } ?>
                        </select>
                        <p class="text-danger"><?= isset($formErrors['category']) ? $formErrors['category'] : '' ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-sm-6 offset-sm-3 col-sm-6 offset-sm-3 col-6 offset-3">
                        <button type="submit" name="articleSubmit" class="registerArticles btn btn-primary">Enregister</button>
                    </div>
                </div>
            </div>
        </form>
        <?php include 'footer.php' ?>
        <script type="text/javascript" src="../assets/js/wysiwyg.js"></script>
    </body>
</html>

