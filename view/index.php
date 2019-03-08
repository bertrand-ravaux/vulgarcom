<?php include '../config.php' ?>
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
                <div class="col-2 offset-1 col-sm-3 col-md-3 col xl-3">
                    <img src="../assets/img/h2o.png" alt="h2o" id="logoVulgarcom" />
                </div>
                <div class="col-10 offset-1 col-sm-6 offset-sm-2 col-md-5 offset-md-2 col-lg-5 offset-lg-2 col-xl-3 offset-xl-2 text-center titlePresenting">
                    <h1>Vulgarcom</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1 col-xl-10 offset-xl-1 text-center presenting">
                    <img class="img-fluid imgIndex" src="../assets/img/index.png" alt="index"/>
                    <p>Bienvenue sur Vulgarcom! Notre but est de créer un espace communautaire ou nous pourrons expliquer la science en termes simples afin de pouvoir être compris par le plus grand nombre. SI cela vous interresse inscrivez-vous dès maintenant pour pouvoir partager vos connaissances avec nous ! </p>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>