<?php
//affiche la visio à modifier avec les anciennes données
$id = $_GET['visioId'];
$TableauVisioModif =($pdo->afficheVisioModifie($id));
include_once("vues/chefProduit/v_modifie_visio.php");

?>