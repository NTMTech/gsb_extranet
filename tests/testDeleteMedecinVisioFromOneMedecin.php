<?php
require_once ("../include/class.pdogsb.inc.php");

$lePdo = PdoGsb::getPdoGsb();
var_dump($lePdo->deleteMedecinVisioFromOneMedecin(52));