<?php

//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données

$pdo= PdoGsb::getPdoGsb();


/***** cas TRUE *******************/
$mail="Jaques@gmail.com";
$pwd="Thoughtpolice666!!";

var_dump($pdo->checkUserModo($mail,$pwd));


/***** cas FALSE *******************/
$mail="David@gmail.com";
$pwd="Thoughtpolice2019!";

var_dump($pdo->checkUserMedecin($mail,$pwd));

/***** cas FALSE *******************/
$mail="bidule@gmail.fr";
$pwd="YJhd4gR#9UAR2pGA";

var_dump($pdo->checkUserMedecin($mail,$pwd));



