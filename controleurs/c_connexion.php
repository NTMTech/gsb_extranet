<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{ 
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];
		$checkAccount = $pdo->checkRoleAccount($login);
		//var_dump($checkAccount);
		switch ($checkAccount)
		{
			case '1':{
				$maintenanceVerif = $pdo->getMaintenance();
				
				
				if ($maintenanceVerif == 0)	{
					
					$code = $pdo->creerCodeVerif($login);
					$pdo->envoiMail($code,$login);
					include("vues/v_double_authentification.php");
					
				}
				else{
					include("vues/v_maintenance.php");
					}
				break;
				}
			case '2':{
				$maintenanceVerif = $pdo->getMaintenance();
				if ($maintenanceVerif == 0)	{
					$infosMedecin = $pdo->donneLeMedecinByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitiale($login);
				}
				else{
					include("vues/v_maintenance.php");
				}
				break;
			}
			
			case '3':{
				$infosMedecin = $pdo->donneLeMedecinByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitiale($login);
					include("vues/admin/v_sommaire.php");
					break;
			}

			case '4':{
				$maintenanceVerif = $pdo->getMaintenance();
				if ($maintenanceVerif == 0)	{
					$infosMedecin = $pdo->donneLeMedecinByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitiale($login);
					include("vues/validateur/v_sommaire.php");
				}
				else{
					include("vues/v_maintenance.php");
				}
				break;
			}

			case '5':{
				$maintenanceVerif = $pdo->getMaintenance();
				if ($maintenanceVerif == 0)
				{
					$infosMedecin = $pdo->donneLeMedecinByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitiale($login);
					include("vues/chefProduit/v_sommaire.php");
				}
				else {
					include("vues/v_maintenance.php");
				}
				break;}
			
			default :{
				ajouterErreur("Login ou mot de passe incorrect");
			        include("vues/v_erreurs.php");
			        include("vues/v_connexion.php");
			break;}
			
		}break;}

		case 'recupCode':{
			$login = $_POST['login'];
			$codeFromForm = intval($_POST['code']);
			$codeReal = $pdo->GetCode($login);
			$verifToken = $pdo->getVerifToken($login);
			if ($codeFromForm == $codeReal && $verifToken == 1)
			{
				$infosMedecin = $pdo->donneLeMedecinByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitiale($login);
					$createJSONfile = $pdo->infoPersoJSON($id);           
					include("vues/v_sommaire.php");
					}else 
					{
						echo "Code invalide, veuillez reessayer";
					}
					break;
						
			}
		}
		?>