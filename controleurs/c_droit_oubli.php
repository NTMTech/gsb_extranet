<?php 
$id = $_SESSION['id'];
echo '<a href="index.php?uc=supprimerMedecin&unmedecin='.$id.'">';
echo 'Supprimer mon compte';
