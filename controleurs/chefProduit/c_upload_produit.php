<?php
//modifie la visio avec les nouvelles données
$id = $_GET['idProduit'];
$nom=$_POST['NomVisio'];
$objectif=$_POST['ObjectifVisio'];
$information=$_POST['information'];
$effetIndesirable= $_POST['effetIndesirable'];
$image=$_POST['image'];
$pdo->modifierProduit($id,$nom,$objectif,$information,$effetIndesirable,$image);
include_once("vues/chefProduit/v_consultation_produit.php");
?>