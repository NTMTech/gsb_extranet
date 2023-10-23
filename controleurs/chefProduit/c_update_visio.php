<?php
//modifie la visio avec les nouvelles données
$id = $_GET['idVisio'];
$nom=htmlspecialchars($_POST['NomVisio']);
$objectif=htmlspecialchars($_POST['ObjectifVisio']);
$url=htmlspecialchars($_POST['UrlVisio']);
$date=htmlspecialchars($_POST['DateVisio']);
$pdo->modifierVisio($id,$nom,$objectif,$url,$date);
include_once("vues/chefProduit/v_consultation_produit.php");
?>