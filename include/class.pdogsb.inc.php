<?php

/** 
 * Classe d'acces aux donnees. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Forestier Thomas
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbextranet';   		
      	private static $user='gsbextranet' ;    		
      	private static $mdp='password' ;	
	private static $monPdo;
	private static $monPdoGsb=null;
		
/**
 * Constructeur prive, cree l'instance de PDO qui sera sollicitee
 * pour toutes les methodes de la classe
 */				
	private function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
/**
 * Constructeur public qui detruit l'instance de PDO
 */
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui cree l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * verifie si le login et le mot de passe sont corrects
 * renvoie true si les 2 sont corrects
 * @param type $lePDO
 * @param type $login
 * @param type $pwd
 * @return bool
 * @throws Exception
 */
function checkUser($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login AND token IS NULL");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){
           if (password_verify($pwd,$unUser['motDePasse']))
                $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}

/**
 * fonction qui reçoit le mail en entrée et donne l'id, le nom, le prénom et le mail en sortie
 * @param $login
 * @throws Exception
 */
	
function donneLeMedecinByMail($login) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
       
    }
    else
        throw new Exception("erreur dans la requête");
return $unUser;   
}

/**
 * fonction public qui donne la longueur de l'adresse mail
 * @return $leResultat 
 */

public function tailleChampsMail(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}

/**
 * fonction public qui crée un médecin à partir du formulaire rempli par l'utilisateur
 * @param email
 * @param $mdp
 * @return $execution
 * 
 * la fonction va insérer un nouvel utilisateur avec un id, un mail, un mot de passe, la date de création du compte et la date à laquelle le consentement à la politique de protection des données
 */

public function creeMedecin($email, $mdp)
{
   
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,dateCreation,dateConsentement) "
            . "VALUES (null, :leMail, :leMdp, now(),now())");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

public function creeValidateur()
{

}


function testMail($email){
    $pdo = PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $execution = $pdoStatement->execute();
    $resultatRequete = $pdoStatement->fetch();
    if ($resultatRequete['nbMail']==0)
        $mailTrouve = false;
    else
        $mailTrouve=true;
    
    return $mailTrouve;
}




function connexionInitiale($mail){
     $pdo = PdoGsb::$monPdo;
    $medecin= $this->donneLeMedecinByMail($mail);
    $id = $medecin['id'];
    $this->ajouteConnexionInitiale($id);
    
}

function ajouteConnexionInitiale($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), now())");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}
function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
   
    }
    else
        throw new Exception("erreur");
           
    
}
function AfficherProduit()
{
    $pdo = PdoGsb::$monPdo;
$monObjPdoStatement=$pdo->prepare("SELECT id,nom,objectif,information,effetIndesirable FROM produit ;");
$id=$monObjPdoStatement->bindValue('id',':id',PDO::PARAM_STR);
$nom=$monObjPdoStatement->bindValue('nom',':nom',PDO::PARAM_STR);
$objectif=$monObjPdoStatement->bindValue('objectif',':objectif',PDO::PARAM_STR);
$information=$monObjPdoStatement->bindValue('information',':information',PDO::PARAM_STR);
$effetIndesirable=$monObjPdoStatement->bindValue('effetIndesirable',':effetIndesirable',PDO::PARAM_STR);
if ($monObjPdoStatement->execute()) {
    $requete=$monObjPdoStatement->fetchAll();
}
}

}
?>