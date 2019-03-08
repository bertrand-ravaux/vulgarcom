<?php

$isSucess = FALSE;
$isError = FALSE;

if (!isset($_SESSION['userRank'])) {
    header('Location:index.php');
} else if ($_SESSION['userRank'] != 1) {
    header('Location:index.php');
}

// je vérifie que le post de validation de mon formulaire existe 
if (isset($_POST['updateUserStatus'])) {
    $users = new users();
    $users->id = $_POST['userId'];
    $users->id_jero_status = $_POST['userStatus'];
    if ($users->getModifyUsersStatusSelect()) {
        $isSucess = TRUE;
    } else {
        $isError = TRUE;
    }
}

// j'instancie un nouvelle objet article le new fait appele a la méthode magique __construct
$user = new users();
// je stocke le resultat de  getUsersListAdmin() dans $userList
$userList = $user->getUsersListAdmin();
// je stocke le resultat de  userStateList() dans $getStatusListForAdmin
$userStateList = $user->getStatusListForAdmin();
?>

