<?php
include("vues/v_connexion.php");

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
}
else {
$id=($_SESSION['id']);

$pdo->updateConnexion($id);
$pdo->deleteJSON($id);
session_destroy();
}
