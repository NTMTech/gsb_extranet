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
  <button name="deconnexion" class="btn btn-default" style="margin-left:94%;" type="submit"><a href="index.php?uc=deconnexion">Déconnexion</a></button>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=retourAccueilCP">Accueil</a>
          </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=ajoutProduit">Ajouter Produits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=consulterProduitCP">Consulter Produits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=ajoutVisios">Ajouter des visioconférences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php?uc=consulterVisiosCP">Consulter les visoconférences</a>
        </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
		    <li><a><?php echo $_SESSION['prenom']." ".$_SESSION['nom']. " ". "Chef Produit"?></a></li>

        </ul>
        </div>
  </div>
</nav>

<div class="page-content container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
				<div class="box">
                <?php $idProduit = $TableauProduitModif['0'];
                echo '<form method="POST" action="index.php?uc=updateProduit&idProduit='.$idProduit.'">';?>
          
          <label >Nouveau nom produit</label>
          <br>
          <textarea id="NomVisio" name="NomVisio" rows="2" cols="35" ><?php echo $TableauProduitModif['1']?></textarea>
          <br>
          <label>Nouvel objectif produit</label>
          <br>
          <textarea name="ObjectifVisio" id="ObjectifVisio" rows="2" cols="35"><?php echo $TableauProduitModif['2']?></textarea>
          <br>
          <label>Nouvelle information</label>
          <br>
          <textarea name="information" id="information" rows="2" cols="35"><?php echo $TableauProduitModif['3']?></textarea>
          <br>
          <label>Nouveaux effets Indesirable</label>
          <br>
          <textarea name="effetIndesirable" id="effetIndesirable" rows="2" cols="35"><?php echo $TableauProduitModif['3']?></textarea>
          <br>
          <label for="DateVisio">Nouvelle image:</label>

<input type="file" name="image" class="form-control mb-4 p-3" id="image" />
<br>
<input type="submit" class="btn btn-primary signup" value="Modifier ce produit"/></form>
          </div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
  }
?>

