<?php

$nom=$_POST['NomProduit'];
$objectif=$_POST['ObjectifProduit'];
$informations=$_POST['InfosProduit'];
$effetIndesirable=$_POST['EffetsProduit'];
$images=$_POST['images'];

$pdo->creerProduit($nom,$objectif,$informations,$effetIndesirable,$images);

include ('vues/chefProduit/v_consultation_produit.php')
?>