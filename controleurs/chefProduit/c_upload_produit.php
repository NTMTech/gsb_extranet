<?php
//modifie la visio avec les nouvelles données
$id = $_GET['idProduit'];
$nom=htmlspecialchars($_POST['NomVisio']);
$objectif=htmlspecialchars($_POST['ObjectifVisio']);
$information=htmlspecialchars($_POST['information']);
$effetIndesirable=htmlspecialchars($_POST['effetIndesirable']);
$image=htmlspecialchars($_POST['image']);
$pdo->modifierProduit($id,$nom,$objectif,$information,$effetIndesirable,$image);
include_once("vues/chefProduit/v_consultation_visios.php");
?>