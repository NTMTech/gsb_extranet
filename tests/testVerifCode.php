<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();
$login = "test12@gmail.com";
$code = 633744;
var_dump($lePdo->VerifCode($login,$code));