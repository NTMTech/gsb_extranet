<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeCreation';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeCreation':{
		include("vues/v_creation.php");
		break;
	}
	case 'valideCreation':{
        if(isset($_POST['ValideCheckBox']) == false){
            $e = "impossible de créer le compte sans avoir coché la case de consentement !<br/>";
            echo $e;
        }
        $_SESSION['login'] = $_POST['login'];

		$leLogin = htmlspecialchars($_POST['login']);
                $lePassword = htmlspecialchars($_POST['mdp']);
                $leNom = ($_POST['nom']);
                $lePrenom = ($_POST['prénom']);


        if ($leLogin == $_POST['login'])
        {
             $loginOk = true;
             $passwordOk=true;
        }
        else{
            echo 'tentative d\'injection javascript - login refusé';
             $loginOk = false;
             $passwordOk=false;
        }
        //test récup données
        //echo $leLogin.' '.$lePassword;
        $rempli=false;
        if ($loginOk && $passwordOk){
        //obliger l'utilisateur à saisir login/mdp
        $rempli=true; 
        if (empty($leLogin)==true) {
            echo 'Le login n\'a pas été saisi<br/>';
            $rempli=false;
        }
        if (empty($lePassword)==true){
            echo 'Le mot de passe n\'a pas été saisi<br/>';
            $rempli=false; 
        }
        
        
        //si le login et le mdp contiennent quelque chose
        // on continue les vérifications
        if ($rempli){
            //supprimer les espaces avant/après saisie
            $leLogin = trim($leLogin);
            $lePassword = trim($lePassword);

            

            //vérification de la taille du champs
            
            $nbCarMaxLogin = $pdo->tailleChampsMail();
            if(strlen($leLogin)>$nbCarMaxLogin){
                 echo 'Le login ne peut contenir plus de '.$nbCarMaxLogin.'<br/>';
                $loginOk=false;
                
            }
            
            //vérification du format du login
           if (!filter_var($leLogin, FILTER_VALIDATE_EMAIL)) {
                echo 'le mail n\'a pas un format correct<br/>';
                $loginOk=false;
            }

            if ($pdo->testMail($leLogin)==true){
                echo'vous ne pouvez pas utiliser un mail déjà existant !<br/>';
                $loginOk=false;
            }
          
            $patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
            if (preg_match($patternPassword, $lePassword)==false){
                echo 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
                . ' une minuscule et un caractère spécial<br/>';
                $passwordOk=false;
            }
                 
        }
        }
        if($rempli && $loginOk && $passwordOk){
            $token = substr(md5(uniqid()),0 ,8);
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
    $mail->addAddress($leLogin);
	$mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Code de verification';
    $mail->Body    = '<span style="text-align:center; font-weight: bold;">'."<a href=\"https://s5-4263.nuage-peda.fr/projet/gsbextranet_projet_equipe/index.php?uc=creation&action=tokenpage&id=$leLogin&token=$token\">Activation du compte </a> </span>";;
    $mail->send();
    echo 'Vous avez reçu un lien de verification de compte sur votre adresse mail.<br/>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}              
                  echo 'Neanmoins, pour acceder a votre compte, vous devez cliquer sur le lien que vous avez recu par mail';
                        $executionOK = $pdo->creeMedecin($leLogin,$lePassword,$leNom,$lePrenom);
                        if ($executionOK==true){
                            $pdo->connexionInitiale($leLogin);
                            $pdo->addToken($leLogin,$token);
                        }   
                        else
                             echo "ce login existe déjà, veuillez en choisir un autre";
                    }
                    
                    break;}
                    case 'tokenpage':{
                        $leLogin = $_SESSION['login'];
                        $token = $_GET['token'];
                        $tokenRecup = $pdo->getToken($leLogin);
                        if ($tokenRecup == $token)
                        {
                            $pdo->updateToken($leLogin);
                            echo "Votre compte a ete cree !!";
                        }else 
                        {
                            echo "Votre compte n'a pas ete cree :(";
                            echo $token;
                        }
                    break;}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>