<?php
//affiche la visio à modifier avec les anciennes données
$id = $_GET['idProduit'];
$TableauProduitModif =($pdo->afficheProduitModifie($id));
include_once("vues/chefProduit/v_modifie_produit.php");

?>