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
		$connexionOk = $pdo->checkUserMedecin($login,$mdp);
		if(!$connexionOk){
			$login = $_POST['login'];
		    $mdp = $_POST['mdp'];
			$connexionOk = $pdo->checkUserModo($login,$mdp);
			if(!$connexionOk){
				$login = $_POST['login'];
		        $mdp = $_POST['mdp'];
			    $connexionOk = $pdo->checkUserAdmin($login,$mdp);
				if(!$connexionOk){
			        ajouterErreur("Login ou mot de passe incorrect");
			        include("vues/v_erreurs.php");
			        include("vues/v_connexion.php");
			    }
				else { 
					$maintenanceVerif = $pdo->getMaintenance();
					if ($maintenanceVerif == 0)
					{
						$infosMedecin = $pdo->donneAdminByMail($login);
					$id = $infosMedecin['id'];
					$nom =  $infosMedecin['nom'];
					$prenom = $infosMedecin['prenom'];
					connecter($id,$nom,$prenom);
					$pdo->connexionInitialeAdmin($login);
					include("vues/v_sommaire.php");
					}else
					{
						include("vues/v_maintenance.php");
					}
				} 
		}
		    else {
				$maintenanceVerif = $pdo->getMaintenance();
				if ($maintenanceVerif == 0)
				{
					$infosMedecin = $pdo->donneLeModoByMail($login);
                $id = $infosMedecin['id'];
                $nom =  $infosMedecin['nom'];
                $prenom = $infosMedecin['prenom'];
                connecter($id,$nom,$prenom);
                $pdo->connexionInitialeModo($login);}
			else
		{
			include("vues/v_maintenance.php");
		}
	}
				}

                

		   

		
		
		else { 
			$maintenanceVerif = $pdo->getMaintenance();
			if ($maintenanceVerif == 0)
			{

			
			include("vues/v_double_authentification.php");
			$code = $pdo->creerCodeVerif($login);
				$mail = new PHPMailer(true);
			

try {
	
    //Server settings                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noahthomasmathis@gmail.com';                     //SMTP username
    $mail->Password   = 'tosa vxay dgbt ghkz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->setFrom('noahthomasmathis@gmail.com');
    $mail->addAddress($login);
	$mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Code double authentification';
    $mail->Body    = "Veuillez saisir le code suivant afin de vous connecter : $code";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
		}else
	{
		include("vues/v_maintenance.php");
	}}break;}
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
		
       
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>