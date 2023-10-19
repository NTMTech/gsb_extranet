<?php

$nom=$_POST['NomProduit'];
$objectif=$_POST['ObjectifProduit'];
$informations=$_POST['InfosProduit'];
$effetIndesirable=$_POST['EffetsProduit'];
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