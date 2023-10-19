
<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
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
		include("controleurs/admin/c_mettre_maintenance.php");break;
	}
	case 'consulteOperation':{
		include("controleurs/admin/c_consulteOperation.php");break;
	}
	case 'maintenanceON':{
		include("controleurs/admin/c_maintenanceON.php");break;
	}
	case 'maintenanceOFF':{
		include("controleurs/admin/c_maintenanceOFF.php");break;
	}
	case 'personnalData' :{
		include("controleurs/c_personnalData.php");break;
	}
	case 'valideMedecin' :{
		include("controleurs/validateur/c_valide_medecin.php");break;
	}
	case 'donnerAvis' :{
		include("controleurs/c_donner_avis.php");break;
	}
	case 'inscritVisio' :{
		include("controleurs/c_inscritVisio.php");break;
	}
	case 'voirAvis' :{
		include("controleurs/c_afficheAvis.php");break;
	}
	case 'voirAvisNonValide' :{
		include("controleurs/modo/c_valide_avis.php");break;
	}
	case 'valideAvis' :{
		include("controleurs/modo/c_fonction_valide_avis.php");break;
	}
	}
	include_once('vues/v_footer.php');
?>