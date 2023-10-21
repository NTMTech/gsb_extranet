<?php
//modifie la visio avec les nouvelles données
$id = $_GET['idVisio'];
$nom=$_POST['NomVisio'];
$objectif=$_POST['ObjectifVisio'];
$url=$_POST['UrlVisio'];
$date=$_POST['DateVisio'];
$pdo->modifierVisio($id,$nom,$objectif,$url,$date);
include_once("vues/chefProduit/v_consultation_produit.php");
?>