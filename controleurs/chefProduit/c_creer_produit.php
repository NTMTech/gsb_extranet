<?php

$nom=htmlspecialchars($_POST['NomProduit']);
$objectif=htmlspecialchars($_POST['ObjectifProduit']);
$informations=htmlspecialchars($_POST['InfosProduit']);
$effetIndesirable=htmlspecialchars($_POST['EffetsProduit']);
var_dump($_FILES);
if(isset($_FILES['images'])){ 
    $nomImageTemp=$_FILES['images']['tmp_name'];
    $images = $_FILES['images']['name'];
    $taille = $_FILES['images']['size'];
    $error = $_FILES['images']['error'];
    move_uploaded_file($nomImageTemp, 'images/'.$images);
}


$pdo->creerProduit($nom,$objectif,$informations,$effetIndesirable,$images);

include ('vues/chefProduit/v_consultation_produit.php')
?>