<?php

$id = $_GET['visioId'];
$pdo->supprimerVisio($id);
include("vues/chefProduit/v_consultation_visios.php")
?>