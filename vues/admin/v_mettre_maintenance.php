
﻿<!DOCTYPE html>
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
    <link href="https://bootswatch.com/5/darkly/bootstrap.min.css" rel="stylesheet">
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
  <body background="assets/img/laboratoire.jpg">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=retourAccueilAdmin">Accueil</a>
          </li>
        <li class="nav-item">
          <a class="nav-link active"  href="index.php?uc=maintenance">Mettre site en maintenance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Consulter opérations</a>
        </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
		    <li><a><?php echo $_SESSION['prenom']." ".$_SESSION['nom']. " ". "Administrateur"?></a></li>

        </ul>

    </div>
  </div>
</nav>


	
<div class="btn-group-vertical">

      <button type="button" class="btn btn-primary mt-2" ><a href="index.php?uc=deconnexion">Déconnexion</a></button>
      <button type="button" class="btn btn-primary mt-2" ><a href="index.php?uc=maintenanceON">Maintenance ON</a></button>
      <button type="button" class="btn btn-primary mt-2"  ><a href="index.php?uc=maintenanceOFF">Maintenance OFF</a></button>

        <!--<button name="maintenance ON" class="btn btn-default"  type="submit"><a href="index.php?uc=maintenanceON">Maintenance ON</a></button>
        <button name="maintenance OFF" class="btn btn-default"  type="submit"><a href="index.php?uc=maintenanceOFF">Maintenance OFF</a></button>
    -->
    </div>
 
