<?php
include("vues/v_connexion.php");

session_destroy();
$id = $_SESSION['id'];
unlink("portabilite/".$id.".json");