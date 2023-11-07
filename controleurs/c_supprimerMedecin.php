<?php 
include("vues/v_connexion.php");
$id = $_SESSION['id'];
$deleteHistory = $pdo->deleteHistoriqueConnexionFromOneMedecin($id);
$deleteProduit = $pdo->deleteProduitFromOneProduit($id);
$deleteMedecinVisio = $pdo->deleteMedecinVisioFromOneMedecin($id);
if ($deleteHistory == true && $deleteProduit == true && $deleteMedecinVisio == true){
    $pdo->deleteMedecin($id);
    session_destroy();
}else
{
    echo "La suppression de votre compte a échoué";
}