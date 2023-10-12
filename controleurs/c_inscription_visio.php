<?php
include("vues/v_consultation_visio.php");

echo $uneVisio['id'];
$id = $_SESSION['id'];
$inscription = $pdo->inscriptionVisio($id,$uneVisio['id']);
?>