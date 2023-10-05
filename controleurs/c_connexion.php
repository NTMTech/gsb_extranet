<?php


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
			    ajouterErreur("Login ou mot de passe incorrect");
			    include("vues/v_erreurs.php");
			    include("vues/v_connexion.php");
		}
		    else { 

			    $infosMedecin = $pdo->donneLeMedecinByMail($login);
                $id = $infosMedecin['id'];
                $nom =  $infosMedecin['nom'];
                $prenom = $infosMedecin['prenom'];
                connecter($id,$nom,$prenom);
                $pdo->connexionInitiale($login);
		   
include("vues/v_sommaire.php");
}
		
		}
		else { 

                        $infosMedecin = $pdo->donneLeMedecinByMail($login);
			$id = $infosMedecin['id'];
			$nom =  $infosMedecin['nom'];
			$prenom = $infosMedecin['prenom'];
			connecter($id,$nom,$prenom);
			$pdo->connexionInitiale($login);
                       
			include("vues/v_sommaire.php");
			}

			break;	
	}
       
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>