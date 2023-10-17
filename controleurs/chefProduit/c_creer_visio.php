<?php

$nom=$_POST['NomVisio'];
$objectif=$_POST['ObjectifVisio'];
$url=$_POST['UrlVisio'];
$date=$_POST['DateVisio'];
$pdo->creerVisio($nom,$objectif,$url,$date);

include ('vues/chefProduit/v_consultation_visios.php')
?>