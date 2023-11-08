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
  <form action="../controleurs/c_consultation_produit.php" method="post">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
      <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=retourAccueil">Accueil</a>
          </li>
        <li class="nav-item">
          <a class="nav-link active fs-13" href="index.php?uc=consulteProduit">Consultation produits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=consulteVisio">Consultation visionconférences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=inscrireVisio">Inscription visionconférences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=avisVisio">Avis visioconférences</a>
        </li>
      </ul>
      </ul>
        <ul class="nav navbar-nav navbar-right">
		    <li><a><?php echo $_SESSION['prenom']." ".$_SESSION['nom']. " ". "Médecin"?></a></li>

        </ul>

    </div>
  </div>
</nav>
<button type="button" class="btn btn-primary mt-2" style="margin-left:93%;" ><a href="index.php?uc=deconnexion">Déconnexion</a></button>




	
	<div class="page-content">
    	<div class="row">
      <?php $lesProduits = $pdo->AfficherProduit();
     echo '<center>';
     echo '</br>';
     echo '<div>';
     echo '<table>';
     echo '<tr>';
     echo '<th>Nom</th>';
     //echo '<th>Objectif</th>';
     //echo '<th>Information</th>';
     //echo '<th>Effet indesirable</th>';
     echo '</tr>';
     $test = 0;
   foreach($lesProduits as $unProduit){
    $test = $test + 1;
     echo '<tr>';
     echo '<th>'.$unProduit['nom'].'</th>';
     echo '<th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$test.'">
     '.$unProduit['nom'].'
 </button></th>';
     echo '<!-- Pop-up -->
<div id="'.$test.'" class="modal">
       <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                 <div class="modal-header">
                      <strong style = font-size:30px;><p> '.$unProduit['nom'].' </p></strong>
                       </div>
                    <div class="modal-body">
                      <p> <strong>Objectif du médicament:</strong> '.$unProduit['objectif'].'</p>
                      <p> <strong>Information sur le médicament:</strong> '.$unProduit['information'].'</p>
                      <p> <strong>Effet indésirable du médicament:</strong> '.$unProduit['effetIndesirable'].'</p>
                      <img class="imageProduit" src="images/'.$unProduit['image'].'"alt="'.$unProduit['nom'].'width="10">
                       </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer
                               </button>
                       </div>
                </div>
       </div>
</div>';
      //echo '<th>'.$unProduit['objectif'].'</th>';
     //echo '<th width=30%>'.$unProduit['information'].'</th>';
     //echo '<th width=30%>'.$unProduit['effetIndesirable'].'</th>';
     echo '</tr>';
   
   }
   echo '</table>';
   echo '</div>';
   echo '</center>';
   ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<?php };?>
