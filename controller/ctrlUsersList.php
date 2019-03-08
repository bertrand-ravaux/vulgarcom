<?php
// si l'utilisateur n'est pas connecté on le retourne a la page index
if (!isset($_SESSION['userRank'])){
    header('Location:index.php');
// sinon si l'utilisateur n'est pas modérateur on le renvoie a la page index
}else if ($_SESSION['userRank'] != 3) {
     header('Location:index.php');   
}

$isSucess = FALSE;
$isError = FALSE;

// je vérifie que le post de validation de mon formulaire existe 
if (isset($_POST['updateUserStatus'])) {
    $users = new users();
    $users->id = $_POST['userId'];
    $users->id_jero_status = $_POST['userStatus'];
    //Si le statut est bien modifé
    if ($users->getModifyUsersStatusSelect()) {
        // on met le booleen a true  pour avoir le message de succés
        $isSucess = TRUE;
    } else {
        // on met le booleen a true  pour avoir le message d'erreur
        $isError = TRUE;
    }
}

// j'instancie un nouvelle objet users le new fait appele a la méthode magique __construct
$user = new users();
// je stocke le resultat de  getUsersList() dans $userList
$userList = $user->getUsersList();
// je stocke le resultat de  getStatusList() dans $userStateList
$userStateList = $user->getStatusList();
?>