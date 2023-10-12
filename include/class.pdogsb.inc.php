<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
function checkUserMedecin($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
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
function checkUserModo($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM moderateur WHERE mail= :login AND token IS NULL");
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

function checkUserAdmin($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM administrateur WHERE mail= :login");
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

public function creeMedecin($email, $mdp, $nom, $prenom)
{
   
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,nom,prenom,dateCreation,dateConsentement,cle,verifToken) "
            . "VALUES (null, :leMail, :leMdp, :leNom, :lePrenom,now(),now(),0,0)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv3 = $pdoStatement->bindValue(':leNom',$nom);
    $bv4 = $pdoStatement->bindValue(':lePrenom',$prenom);

    $execution = $pdoStatement->execute();
    return $execution;
    
}

public function creeValidateur($email,$mdp)
{
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO validateur(idValidateur,mailValidateur, motDePasseValidateur) "
            . "VALUES (null, :leMail, :leMdp, now(),now())");
    $bv1 = $pdoStatement->bindValue(':leMail',$email);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $bv2 = $pdoStatement->bindValue('leMdp', $mdp);

    
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
            . "VALUES (:leUser, now(), now())");
    $bv1 = $pdoStatement->bindValue(':leUser', $id);
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
        return $code['cle'];
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

function getMaintenance()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT maintenance FROM maintenance WHERE idmaintenance = '1';");
    if ($monObjPdoStatement->execute()) {
        $maintenance = $monObjPdoStatement->fetch();
        return $maintenance['maintenance'];
      }else
      {
        return false;
      }
}

function infoPersoJSON($id)
{
    $pdo = PdoGsb::$monPdo;
       $monObjPdoStatement=$pdo->prepare("SELECT nom,prenom,telephone,mail,dateCreation,rpps,dateDiplome,dateConsentement FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        $json = json_encode($unUser);
        $bytes = file_put_contents("portabilite/".$id.".json", $json);
    }
    else
        throw new Exception("erreur");
           
}

function maintenanceON()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE maintenance SET maintenance = '1' WHERE idmaintenance = '1'");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

function maintenanceOFF()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE maintenance SET maintenance = '0' WHERE idmaintenance = '1'");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

function checkRoleAccount($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT role FROM medecin WHERE mail = :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $role = $monObjPdoStatement->fetch();
        return $role['role'];
      }else
      {
        return false;
      }
}

function envoiMail($code,$login){
    try {

        //Server settings    
        $mail = new PHPMailer(true);                  //Enable verbose debug output
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
}
}
?>