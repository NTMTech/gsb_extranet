<?php 
include_once("vues/validateur/v_valide_medecin.php");

$id = $_GET['unMedecin'];
$pdo->giveValidationToMedecin($id);