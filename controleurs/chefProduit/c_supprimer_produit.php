<?php

$id = $_GET['idProduit'];
$pdo->supprimerProduit($id);
include("vues/chefProduit/v_consultation_produit.php")
?>