<?php 

$id = $_SESSION['id'];
session_destroy();
$pdo->deleteMedecin($id);