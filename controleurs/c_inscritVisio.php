<?php 
include("vues/v_inscription_visio.php");

$visio = $_GET['uneVisio'];
$id = $_SESSION['id'];
$inscription = $pdo->inscriptionVisio($id,$visio);