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
 * @author Forestier Thomas, Bellart Mathis, Faidherbe Noah
 * @version    1.5
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbextranet';   		
      	private static $user='gsbextranet' ;    		
      	private static $mdp='ThoughtPolice2019' ;	
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
function checkUserMedecin($login,$pwd):bool {

    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){
           if (password_verify($pwd,$unUser['motDePasse']))
                $user=true;
               
         
    
    }
}
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

function donneLeModoByMail($login) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail FROM moderateur WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
       
    }
    else
        throw new Exception("erreur dans la requête");
return $unUser;   
}

function donneAdminByMail($login) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail FROM administarteur WHERE mail= :login");
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
 * la fonction va insérer un nouvel utilisateur avec un id, un mail, un mot de passe, la date de création du compte et la date à laquelle le consentement à la politique de pro<tection des données
 */

public function creeMedecin($email, $mdp, $nom, $prenom,$rpps)
{
   
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,nom,prenom,dateCreation,dateConsentement,cle,verifToken,rpps) "
            . "VALUES (null, :leMail, :leMdp, :leNom, :lePrenom,now(),now(),0,0,:leRpps)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv3 = $pdoStatement->bindValue(':leNom',$nom);
    $bv4 = $pdoStatement->bindValue(':lePrenom',$prenom);
    $bv5 = $pdoStatement->bindValue(':leRpps',$rpps);

    $execution = $pdoStatement->execute();
    return $execution;
    
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
            . "VALUES (:leUser, now(), NULL)");
    $bv1 = $pdoStatement->bindValue(':leUser', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

function connexion($mail){
    $pdo = PdoGsb::$monPdo;
   $medecin= $this->donneLeMedecinByMail($mail);
   $id = $medecin['id'];
   $this->ajouteConnexion($id);
   
}

function ajouteConnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(),NULL)");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

function updateConnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE historiqueconnexion "
            . "SET dateFinLog = now()"
            ."WHERE idMedecin = :leMedecin AND dateFinLog IS NULL");
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

/**
 * fonction qui permet d'obtenir tout les produits issue de la table produit 
 * dans la base de donnée gsbextranet
 */
function AfficherProduit()
{
    $pdo = PdoGsb::$monPdo;
$monObjPdoStatement=$pdo->prepare("SELECT id,nom,objectif,information,effetIndesirable FROM produit ;");
if ($monObjPdoStatement->execute()) {
  $donnees = $monObjPdoStatement->fetchAll();
    
        return $donnees;
    }

}

/**
 * fonction qui créer un code de vérification pour la connexion en double authentification 
 * des comptes
 * @param $login
 */
function creerCodeVerif($login)
{
    $code = rand(100000,999999);
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE medecin SET cle = $code WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return $code;  
}else
throw new Exception("erreur"); 
}

/**
 * fonction qui permet d'obtenir le code de vérification d'un compte dans la base de donnée
 */
function GetCode($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT cle FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute())
    {
        $code=$monObjPdoStatement->fetch();
        $codeReal = $code['cle'];
        return $codeReal;
    }else
    {
        return false;
    }
}
function donneinfosmodo($id){
  
    $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM moderateur WHERE id= :lId");
 $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
 if ($monObjPdoStatement->execute()) {
     $unUser=$monObjPdoStatement->fetch();

 }
 else
     throw new Exception("erreur");
        
 
}

function donneinfosadmin($id){
  
    $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM administarteur WHERE id= :lId");
 $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
 if ($monObjPdoStatement->execute()) {
     $unUser=$monObjPdoStatement->fetch();

 }
 else
     throw new Exception("erreur");
        
 
}

/**
 * fonction qui permet d'obtenir les différentes visios conférences proposée
 */
function getVisioProposee()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT * FROM visioconference ;");
    if ($monObjPdoStatement->execute()) {
    $donnees = $monObjPdoStatement->fetchAll();
    
          return $donnees;
      }

}

function inscriptionVisio($idmedecin,$idvisio)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("INSERT INTO medecinvisio VALUES ($idmedecin,$idvisio,now());");
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }

}

function getNomVisioInscrit($id)
{
    $pdo = PdoGsb::$monPdo;
$monObjPdoStatement=$pdo->prepare("SELECT nomVisio FROM visioconference INNER JOIN medecinvisio ON visioconference.id = medecinvisio.idVisio WHERE idMedecin = $id;");
if ($monObjPdoStatement->execute()) {
  $donnees = $monObjPdoStatement->fetchAll();
    
        return $donnees;
    }
}

function addToken($login,$jeton)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE medecin SET token = '$jeton' WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

function getToken($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT token from medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $tokenrecup = $monObjPdoStatement->fetch();
        return $tokenrecup['token'];
      }else
      {
        return false;
      }
}

function getVerifToken($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT verifToken from medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $tokenrecup = $monObjPdoStatement->fetch();
        return $tokenrecup['verifToken'];
      }else
      {
        return false;
      }
}

function updateToken($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE medecin SET verifToken = '1' WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

function verificationDuMedecin(){
	$pdo = PdoGsb::$monPdo;
    $tableauVerif = array();
    foreach($element as $tableauVerif){
        $monObjPdoStatement=$pdo->prepare("SELECT nom,prenom,rpps FROM medecin WHERE verificationDuMedecin = 0");
         
    }
    $monObjPdoStatement->execute();   
}
    

}
?>
