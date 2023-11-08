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

    </div>
  </div>
</nav>
<button type="button" class="btn btn-primary mt-2" style="margin-left:93%;" ><a href="index.php?uc=deconnexion">Déconnexion</a></button>


<div>
<table>
        <tr>
            <th>Nom de la Visio</th>
            <th>Objectif</th>
            <th>URL</th>
            <th>Date de la Visio</th>
            <th></th>
        </tr>
      <?php $lesVisios = $pdo->getVisioProposee();
      foreach ($lesVisios as $uneVisio) {
        echo "<tr>";
        echo "<td>" . $uneVisio["nomVisio"] . "</td>";
        echo "<td>" . $uneVisio["objectif"] . "</td>";
        echo "<td>" . $uneVisio["url"] . "</td>";
        echo "<td width=30%>" . $uneVisio["dateVisio"] . "</td>";
        echo "<td width=10%><a href='index.php?uc=inscritVisio&uneVisio=" . $uneVisio["id"] . "'>S'inscrire</a></td>";
        echo "</tr>";
    }
      /*<div width=100%>
    <form action="index.php?uc=inscritVisio" method="post">
        <table>
            <tr>
                <th>Nom</th>
                <th>Objectif</th>
                <th>URL</th>
                <th>Date de la visio</th>
                <th></th>
            </tr>
            <?php foreach ($lesVisios as $uneVisio) : ?>
                <tr>
                    <td><?= $uneVisio['nomVisio'] ?></td>
                    <td><?= $uneVisio['objectif'] ?></td>
                    <td><?= $uneVisio['url'] ?></td>
                    <td><?= $uneVisio['dateVisio'] ?></td>
                    <td>
                        <input type="hidden" name="uneVisio" value="<?= $uneVisio['id'] ?>">
                        <button type="submit" name="inscrire" value="true" class="btn btn-primary signup">S'inscrire</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>*/
    ?></div></center>
<?php } ?>