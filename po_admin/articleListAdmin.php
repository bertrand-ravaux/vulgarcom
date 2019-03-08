<?php include '../config.php'; ?>
<?php include '../controller/ctrlArticleListAdmin.php'; ?>
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
        <?php include 'navbarAdmin.php'; ?>
        <div class="container articleError">
         <?php if ($isSucess) { ?>
                <div class="alert alert-success  offset-1 col-6">Le status de l'article a était modifié </div>   
            <?php } if ($isError) { ?>
                <div class="alert alert-danger offset-1 col-6"> Le status de l'article n'a pas était modifié </div>
            <?php } ?>
        </div>
            <div class ="row">
                <div class="col-xl-8 offset-xl-2 col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 col-xs-12">
                    <table class="table-responsive userArticleList">
                        <thead>
                            <tr>
                                <th>Titre de l'article</th>
                                <th>Date d'ajout de l'article</th>
                                <th>Statut de l'article</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //On parcours la liste des articles et on les affiche
                            foreach ($articleList as $articleInfo) {
                                ?>
                                <tr>
                                    <td><?= $articleInfo->title ?></td>
                                    <td><?= $articleInfo->date ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <select name="articleState">
                                                <?php
                                                foreach ($articleStateList as $state) {
                                                    //cette ternaire permet de selectionner le status actuel de l'article dans le select
                                                    //en ajoutant selected en html si l'id du status est egal a l'id du status de l'artcle'
                                                    ?>
                                                    <option value="<?= $state->id ?>" <?= $state->id == $articleInfo->status ? 'selected="selected"' : '' ?>><?= $state->state ?></option>

                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="articleId" value="<?= $articleInfo->id ?>">
                                            <button type="submit" name="updateArticleStatus" class="btn btn-primary">Modifier</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include '../view/footer.php'; ?>
    </body>
</html>