<?php 
include ("vues/v_avis_visio.php");

$unAvis = $_GET['unAvis'];
$textAvis = htmlspecialchars($_POST['avis']);
$inscription = $pdo->creerAvis($textAvis,$unAvis);