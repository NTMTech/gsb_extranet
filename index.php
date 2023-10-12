
<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include_once('vues/v_footer.php');
session_start();



date_default_timezone_set('Europe/Paris');



$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if(!isset($_GET['uc'])){
     $_GET['uc'] = 'connexion';
}
else {
    if($_GET['uc']=="connexion" && !estConnecte()){
        $_GET['uc'] = 'connexion';
    }
        
}

$uc = $_GET['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
        case 'creation':{
		include("controleurs/c_creation.php");break;
	}
        case 'footer':{
			include("controleurs/c_footer.php");break;
		}
	case 'consulteProduit':{
		include("controleurs/c_consultation_produit.php");break;
	}
	case 'consulteVisio':{
		include("controleurs/c_consultation_visio.php");break;
	}
	case 'inscrireVisio':{
		include("controleurs/c_inscription_visio.php");break;
	}
	case 'avisVisio':{
		include("controleurs/c_avis_visio.php");break;
	}
	case 'deconnexion':{
		include("controleurs/c_deconnexion.php");break;
	}
	case 'inscriptionVisio':{
		include("controleurs/c_inscription_visio.php");break;
	}
	case 'maintenance':{
		include("controleurs/c_maintenance.php");break;
	}
	case 'consulteOperation':{
		include("controleurs/c_consulteOperation");break;
	}
	case 'maintenanceON':{
		include("controleurs/c_maintenanceON");break;
	}
	case 'maintenanceOFF':{
		include("controleurs/c_maintenanceOFF");break;
	}
	case 'personnalData' :{
		include("controleurs/c_personnalData.php");break;
	}
	}
	


?>







