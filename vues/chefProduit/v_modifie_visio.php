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
        
      <li class="active"><a href="index.php?uc=ajoutProduit">Ajouter Produits</a></li> 
      <li class="active"><a href="index.php?uc=consulterProduitCP">Consulter Produits</a></li>
      <li class="active"><a href="index.php?uc=ajoutVisios">Ajouter des visioconférences</a></li> 
      <li class="active"><a href="index.php?uc=consulterVisiosCP">Consulter les visoconférences</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
		  <li><a><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?></a></li>
		  <li><a>Chef Produit</a></li>
       
     </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="page-content container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
				<div class="box">
        <?php $idVisio = $TableauVisioModif['0'];
        echo '<form method="POST" action="index.php?uc=updateVisio&idVisio='.$idVisio.'">';?>
          
<label >Nouveau nom visioconférence</label>
<br>
<textarea id="NomVisio" name="NomVisio" rows="2" cols="35" ><?php echo $TableauVisioModif['1']?></textarea>
<br>
<label>Nouvel objectif visioconférence</label>
<br>
<textarea name="ObjectifVisio" id="ObjectifVisio" rows="2" cols="35"><?php echo $TableauVisioModif['2']?></textarea>
<br>
<label>Nouvelle URL visioconférence</label>
<br>
<textarea name="UrlVisio" id="UrlVisio" rows="2" cols="35"><?php echo $TableauVisioModif['3']?></textarea>
<br>
<label for="DateVisio">Nouvelle Date de la visioconférence :</label>

<input type="date" id="start" name="image" value="<?php echo $TableauVisioModif['4']?>" min="2023-01-01" max="2030-01-01" />
<br>
<input type="submit" class="btn btn-primary signup" value="Modifier la visioconference"/></form>
          </div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
  }
?>

