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
  <body>
  <form action="../controleurs/c_consultation_produit.php" method="post">
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

      <li class="active"><a href="index.php?uc=voirAvisNonValide">Avis des médecins sur les visios</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
		  <li><a><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?></a></li>
		  <li><a>Modérateur</a></li>
       
     </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



	
	<div class="page-content">
    	<div class="row">
      <?php $avisNonVerif = $pdo->getAvisNonVerif();
      echo '<center>';
      echo '<div>';
      echo '<table>';
      echo '<tr>';
      echo '<th>Nom de la visio</th>';
      echo '<th>Avis sur la visio</th>';
      echo '<th>';
      echo '</th>';
      echo '</tr>';
    foreach($avisNonVerif as $unAvis){
      echo '<tr>
       <th>'.$unAvis['nomVisio'].'</th>
      <th>'.$unAvis['textAvis'].'</th>';
      $avisId = $unAvis['idAvis'];
     echo '<form method="post" action="index.php?uc=valideAvis&unAvis='.$avisId.'">';
     echo '<th width=10%><a href="index.php?uc=valideAvis&unAvis='.$avisId.'">valider avis</a></th>';
      echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
    echo '</center>';
    echo '</div>';
    echo '</div>';
 };
    ?>
