<?php 
include ("vues/v_avis_visio.php");

$unAvis = $_GET['unAvis'];
$textAvis = $_POST['avis'];
echo $textAvis;
$inscription = $pdo->creerAvis($textAvis,$unAvis);