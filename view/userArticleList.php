<?php include '../config.php'; ?>
<?php include '../controller/ctrlUserArticleList.php'; ?>
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
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
                    <form action="#" method="GET"> 
                        <input name="search" type="text" placeholder="Insérer un titre" class="search"> 
                        <input class=" btn btn-primary" id="submit" type="submit" value="Recherchez-vous">
                    </form>
                </div>
            </div>
            <div class ="row">
                <div class="col-xl-8 offset-xl-2 col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 col-12">
                    <table class="table-responsive ">
                        <thead>
                            <tr>
                                <th>Titre de l'article</th>
                                <th>Date d'ajout de l'article</th>
                                <th>Statut de l'article</th>
                                <th>Editer l'article</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //On parcous la liste des articles de l'utilisateur et on les affiche
                            foreach ($articleList as $articleInfo) {
                                ?>
                                <tr>
                                    <td><?= $articleInfo->title ?></td>
                                    <td><?= $articleInfo->date ?></td>
                                    <td><?= $articleInfo->state ?></td>
                                    <td><a class="btn btn-primary " href="articleManagement.php?articleId=<?= $articleInfo->id ?>">Editer l'article</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>