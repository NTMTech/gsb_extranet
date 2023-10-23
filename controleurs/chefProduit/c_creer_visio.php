<?php

$nom=htmlspecialchars($_POST['NomVisio']);
$objectif=htmlspecialchars($_POST['ObjectifVisio']);
$url=htmlspecialchars($_POST['UrlVisio']);
$date=htmlspecialchars($_POST['DateVisio']);
$pdo->creerVisio($nom,$objectif,$url,$date);

include ('vues/chefProduit/v_consultation_visios.php')
?>