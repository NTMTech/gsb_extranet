<?php
include ("vues/v_consultation_produit.php");
if(!isset($_GET['action'])){
	$_GET['action'] = 'consulteProduit';
}
$action = $_GET['action'];

$produit = $pdo->AfficherProduit();
$id = $produit['id'];
$nom = $produit['nom'];
$objectif = $produit['objectif'];
$information = $produit['information'];
$effetIndesirable = $produit['effetIndesirable'];
?>