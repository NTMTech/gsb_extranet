<?php
include ("vues/v_avis_visio.php");

$unAvis = $_GET['unAvis'];
$id = $_SESSION['id'];
$inscription = $pdo->creerAvis($id,$unAvis);
?>
?>