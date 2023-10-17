
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
	case 'ajoutProduit':{
		include("controleurs/chefProduit/c_ajouter_produit.php");break;
	}
	case 'creerProduit':{
		include("controleurs/chefProduit/c_creer_produit.php");break;
	}
	case 'consulterProduitCP':{
		include("controleurs/chefProduit/c_consultation_produit.php");break;
	}
	case 'supprimerProduit':{
		include("controleurs/chefProduit/c_supprimer_produit.php");break;
	}
	case 'consulterVisiosCP':{
		include("controleurs/chefProduit/c_consulter_visios.php");break;
	}
	case 'supprimerVisio':{
		include("controleurs/chefProduit/c_supprimer_visio.php");break;
	}
	case 'ajoutVisios':{
		include("controleurs/chefProduit/c_ajouter_visio.php");break;
	}
	case 'creerVisio':{
		include("controleurs/chefProduit/c_creer_visio.php");break;
	}
}
include_once("vues/v_footer.php")
?>