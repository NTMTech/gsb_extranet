<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else {
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <title>GSB -extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/profilcss/profil.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body background="assets/img/laboratoire.jpg">
  <button name="deconnexion" class="btn btn-default" style="margin-left:94%;" type="submit"><a href="index.php?uc=deconnexion">Déconnexion</a></button>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
      <li class="active"><a href="index.php?uc=valideMedecin&unMedecin='0'">Valider les medecins</a></li> <!--Modifier la redirection-->

      </ul>
      <ul class="nav navbar-nav navbar-right">
		  <li><a><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?></a></li>
		  <li><a>Validateur</a></li>
       
     </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



	
	<div class="page-content">
    	<div class="row">
      <?php $medecinNonValide = $pdo->voirMedecinNonValide();

echo '<div>';
echo '<table>';
echo '<tr>';
echo '<th>Nom du medecin</th>';
echo '<th>Prenom du medecin</th>';
echo '<th>Telephone du medecin du medecin</th>';
echo '<th>Mail du medecin</th>';
echo '<th>Rpps</th>';
echo '<th></th>';
echo '</tr>';
$valideId = 0;
foreach($medecinNonValide as $unMedecin){
$mailDuMedecin = $unMedecin['id'];
echo '<tr>';
echo '<th>'.$unMedecin['nom'].'</th>';
echo '<th>'.$unMedecin['prenom'].'</th>';
echo '<th>'.$unMedecin['telephone'].'</th>';
echo '<th>'.$unMedecin['mail'].'</th>';
echo '<th>'.$unMedecin['rpps'].'</th>';
$valideId = $valideId + 1;
echo '<form method="post" action="index.php?uc=valideMedecin&unMedecin='.$mailDuMedecin.'">';
echo '<th><input type="submit" class="btn btn-primary signup" value="Valider le medecin"/></th>';
echo '</form>';
echo '</tr>';

}
echo '</table>';
echo '</div>';
?>
<?php };?>
