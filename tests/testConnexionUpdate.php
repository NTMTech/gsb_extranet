<?php

//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données

$pdo= PdoGsb::getPdoGsb();


/***** cas TRUE *******************/
$mail="test@gmail.com";

var_dump($pdo->connexionInitiale($mail)); //cas où mail existe
var_dump($pdo->updateConnexion(10));





