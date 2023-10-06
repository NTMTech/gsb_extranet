<?php
include("vues/v_connexion.php");

if(!$_SESSION['id']){
header('Location: ../index.php');
$id=($_SESSION['id']);}
else{
    $pdo->updateConnexion($id);
    session_destroy();
}
