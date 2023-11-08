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
 * @author Forestier Thomas, Belart Mathis, Faidherbe Noah
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
 * @param $email
 * @param $mdp
 * @param $nom
 * @param $prenom
 * @param $rpps
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

/**
 * @param $email
 * @return $mailTrouve
 * Permet d'eviter qu'il y'ai deux fois la même adresse mail*/

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



/**
 * @param $mail
 * Ajoute la connexion dans l'historique lors de la connexion*/
function connexionInitiale($mail){
     $pdo = PdoGsb::$monPdo;
    $medecin= $this->donneLeMedecinByMail($mail);
    $id = $medecin['id'];
    $this->ajouteConnexionInitiale($id);
    
}

/**
 * @param $id
 * @return $execution
 * Ajoute une connexion initiale dans l'historique de connexion
 */
function ajouteConnexionInitiale($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leUser, now(), NULL)");
    $bv1 = $pdoStatement->bindValue(':leUser', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/**
 * @param $mail
 * Ajoute la conextion dans l'historique sans date de fin*/
function connexion($mail){
    $pdo = PdoGsb::$monPdo;
   $medecin= $this->donneLeMedecinByMail($mail);
   $id = $medecin['id'];
   $this->ajouteConnexion($id);
   
}

/**
 * @param $id
 * @return $execution
 * Ajoute une connexion dans l'historique de connexion
 */
function ajouteConnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(),NULL)");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}
/**
 * @param $id
 * @return $execution
 * Met à jour la conextion dans l'historique*/
function updateConnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE historiqueconnexion "
            . "SET dateFinLog = now()"
            ."WHERE idMedecin = :leMedecin AND dateFinLog IS NULL");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/*Donne les infos d'un medecin*/
function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom, FprenomROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
   
    }
    else
        throw new Exception("erreur");
           
    
}

/**
 * @return $donnees
 * fonction qui permet d'obtenir tout les produits issue de la table produit 
 * dans la base de donnée gsbextranet
 */
function AfficherProduit()
{
    $pdo = PdoGsb::$monPdo;
$monObjPdoStatement=$pdo->prepare("SELECT id,nom,objectif,information,effetIndesirable,image FROM produit ;");
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
    $monObjPdoStatement=$pdo->prepare("UPDATE medecin SET cle = $code, limiteValidation = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return $code;  
}else
throw new Exception("erreur"); 
}

/**
 * @param $login
 * @return $code
 * fonction qui permet d'obtenir le code de vérification d'un compte dans la base de donnée
 */
function GetCode($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatementdateactuel=$pdo->prepare("UPDATE medecin SET dateCodeActiver = now() WHERE mail= :login");
    $bvc3=$monObjPdoStatementdateactuel->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatementdateactuel->execute())
    
    {$monObjPdoStatementdate=$pdo->prepare("SELECT limiteValidation FROM medecin WHERE mail= :login");
        $bvc2=$monObjPdoStatementdate->bindValue(':login',$login,PDO::PARAM_STR);
        if ($monObjPdoStatementdate->execute())
        {
            $datelimite=$monObjPdoStatementdate->fetch();
            $dateactuel=$monObjPdoStatementdateactuel->fetch();
            if ($datelimite > $dateactuel)
            {
                $monObjPdoStatement=$pdo->prepare("SELECT cle FROM medecin WHERE mail= :login");
                $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
                if ($monObjPdoStatement->execute())
        {
            $code=$monObjPdoStatement->fetch();
            return $code['cle'];
        }
            }
    
        }}
    
    else
    {
        return false;
    }
}

/**
 * @return $donnees
 * fonction qui permet d'obtenir les différentes visios conférences proposée
 */
function getVisioProposee()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id,nomVisio,objectif,'url',dateVisio,avisVisio FROM visioconference ;");
    if ($monObjPdoStatement->execute()) {
    $donnees = $monObjPdoStatement->fetchAll();
    
          return $donnees;
      }

}

/**
 * @param $idmedecin
 * @param $idvisio
 * Permet de s'inscrire a une visio*/
function inscriptionVisio($idmedecin,$idvisio)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("INSERT INTO medecinvisio VALUES ($idmedecin,$idvisio,now());");
    if ( $monObjPdoStatement->execute()) {
        return true;
      }
  

}

/**
 * @param $id
 * @return $donnees
 * Recupére le nom dans la visio lors de l'inscription*/
function getNomVisioInscrit($id)
{
    $pdo = PdoGsb::$monPdo;
$monObjPdoStatement=$pdo->prepare("SELECT id,nomVisio FROM visioconference INNER JOIN medecinvisio ON visioconference.id = medecinvisio.idVisio WHERE idMedecin = $id;");
if ($monObjPdoStatement->execute()) {
  $donnees = $monObjPdoStatement->fetchAll();
    
        return $donnees;
    }
}

/**
 * @param $login
 * @param $jeton
 * Ajoute un token*/
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

/**
 * @param $login
 * @return $tokenrecup
 * Récupére un token*/
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

/**
 * @param $login
 * @return $tokenrecup
 * Verifie un token*/
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

/**
 * @param $login
 * met a jour un token*/
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

/**
 * @return $maintenance
 * Verifie si le site est en maintenance*/
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

/**
 * @param $id
 * @throws Exception
 * Donne les infos de l'utilisateur*/
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

/**
 * Met le site en maintenance*/
function maintenanceON()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE maintenance SET maintenance = '1' WHERE idmaintenance = '1'");
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * Desactive la maintenance*/
function maintenanceOFF()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE maintenance SET maintenance = '0' WHERE idmaintenance = '1'");
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $login
 * @return $role
 * Verifie le role de l'utilisateur*/
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

/**
 * @param $code
 * @param $login
 * Envoie un mail à l'utilisateur pour qu'il puisse se connecter*/
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
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

/**
 * @param $visioId
 * @return $avisOfVisio
 * Fonction qui retourne les avis d'une visioconference
 */
function getAvisFromOneVisio($visioId)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT textAvis FROM avis WHERE visioId = :visioId AND verifAvis = '1' ");
    $bvc1=$monObjPdoStatement->bindValue(':visioId',$visioId,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $avisOfVisio = $monObjPdoStatement->fetchAll();
        return $avisOfVisio;
      }else
      {
        return false;
      }
}

/**
 * @return $nonValide
 * affiche les medecins non validé*/
function voirMedecinNonValide()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT * FROM medecin WHERE verifValidateur = '0'");
    if ($monObjPdoStatement->execute()) {
        $nonValide = $monObjPdoStatement->fetchAll();
        return $nonValide;
      }else
      {
        return false;
      }
}

/**
 * @param $login
 * @return $validation
 * Verifie la validation du medecin*/
function getValidationCompte($login)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT verifValidateur FROM medecin WHERE mail = :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $validation = $monObjPdoStatement->fetch();
        return $validation['verifValidateur'];
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * Valide un medecin*/
function giveValidationToMedecin($id)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE medecin SET verifValidateur = '1' WHERE id = :id");
    $bvc1=$monObjPdoStatement->bindValue(':id',$id,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * Envoie les infos pour valider le compte au verificateur*/
function sendInfoCreationCompteToValidateur()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT mail FROM medecin WHERE role = '4'");
    if ($monObjPdoStatement->execute()) {
        $validateurMail = $monObjPdoStatement->fetchAll();
        foreach ($validateurMail as $unMail)
        {
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
                $mail->addAddress($unMail['mail']);
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Nouveau medecin';
                $mail->Body    = "Un nouveau medecin vient de creer un compte, allez sur le site afin de le valider ou le refuser.";
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

/**
 * @param $textAvis
 * @param $unAvis
 * fonction qui permet de créer un avis écrit par un Medecin
 */
function creerAvis($textAvis,$unAvis)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("INSERT INTO avis VALUES (NULL,:textAvis,:unAvis,'0');");
    $bvc1 = $monObjPdoStatement->bindValue(':textAvis',$textAvis,PDO::PARAM_STR);
    $bvc2 = $monObjPdoStatement->bindValue(':unAvis',$unAvis,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @return $avisOfVisioNonVerif
 * fonction qui retourne tout les avis qui ne sont pas vérifiés
 */
function getAvisNonVerif()
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT idAvis,textAvis,nomVisio FROM avis INNER JOIN visioconference ON avis.visioId = visioconference.id WHERE verifAvis = '0' ");
    if ($monObjPdoStatement->execute()) {
        $avisOfVisioNonVerif = $monObjPdoStatement->fetchAll();
        return $avisOfVisioNonVerif;
      }else
      {
        return false;
      }
}

/**
 * @param $avisId
 * Fonction qui permet de valider un avis
 */
function validationAvis($avisId)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE avis SET verifAvis = '1' WHERE idAvis = :avisId");
    $bvc1=$monObjPdoStatement->bindValue(':avisId',$avisId,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * supprime l'historique de connexion d'un medecin
 */
function deleteHistoriqueConnexionFromOneMedecin($id)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("DELETE FROM historiqueconnexion WHERE idMedecin = :id");
    $bvc1 = $monObjPdoStatement->bindValue(':id',$id);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime tout les produits d'un medécin
 */
function deleteProduitFromOneProduit($id)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("DELETE FROM medecinproduit WHERE idMedecin = :id");
    $bvc1 = $monObjPdoStatement->bindValue(':id',$id);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime toute les visiosconference d'un medécin
 */
function deleteMedecinVisioFromOneMedecin($id)
{
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("DELETE FROM medecinvisio WHERE idMedecin = :id");
    $bvc1 = $monObjPdoStatement->bindValue(':id',$id);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime un Medecin de la base de données
 */
function deleteMedecin($id)
{
    $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement=$pdo->prepare("DELETE FROM medecin WHERE id = :id");
    $bvc1 = $monObjPdoStatement->bindValue(':id',$id);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime le fichier JSON qui répertorie les donnees personnel d'un medecin
 */
function deleteJSON($id)
{
  unlink("portabilite/".$id.".json");
}
function creerProduit($nom,$objectif,$information,$effeIndesirable,$images){
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("INSERT INTO produit (nom,objectif,information,effetIndesirable,image) VALUES (:nom,:objectif,:information,:effetIndesirable,:images)");
    $bvc1=$monObjPdoStatement->bindValue(':nom',$nom,PDO::PARAM_STR);
    $bvc2=$monObjPdoStatement->bindValue(':objectif',$objectif,PDO::PARAM_STR);
    $bvc3=$monObjPdoStatement->bindValue(':information',$information,PDO::PARAM_STR);
    $bvc4=$monObjPdoStatement->bindValue(':effetIndesirable',$effeIndesirable,PDO::PARAM_STR);
    $bvc5=$monObjPdoStatement->bindValue(':images',$images,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime un produit
 */
function supprimerProduit($id){
    $pdo = PdoGsb::$monPdo;
    $requete=$pdo ->prepare ("DELETE FROM produit WHERE id = $id");
    if ($requete->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * fonction qui supprime une visio
 */
function supprimerVisio($id){
    $pdo = PdoGsb::$monPdo;
    $requete=$pdo->prepare ("DELETE FROM visioconference WHERE id = :id");
    $bvc1=$requete->bindValue(':id',$id,PDO::PARAM_STR);
    if ($requete->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * @param $nom
 * @param $objectif
 * @param $url
 * @param $date
 * fonction qui permet de modifier une visio
 */
function modifierVisio($id,$nom,$objectif,$url,$date){
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE visioconference SET nomVisio = :nom,objectif = :objectif,url = :url,dateVisio = :date WHERE id = $id");
    $bvc1=$monObjPdoStatement->bindValue(':nom',$nom,PDO::PARAM_STR);
    $bvc2=$monObjPdoStatement->bindValue(':objectif',$objectif,PDO::PARAM_STR);
    $bvc3=$monObjPdoStatement->bindValue(':url',$url,PDO::PARAM_STR);
    $bvc4=$monObjPdoStatement->bindValue(':date',$date,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * @return $donnees
 * fonction qui permet d'afficher une visio modifié
 */
function afficheVisioModifie($id){
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id,nomVisio,objectif,url,dateVisio FROM visioconference WHERE id = :id");
    $bvc1=$monObjPdoStatement->bindValue(':id',$id,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
    $donnees = $monObjPdoStatement->fetch();
    
          return $donnees;
      }

}

/**
 * @param $id
 * @param $nom
 * @param $objectif
 * @param $information
 * @param $effetIndesirable
 * @param $image
 * fonction qui permet de mettre à jour un produit
 */
function modifierProduit($id,$nom,$objectif,$information,$effetIndesirable,$image){
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("UPDATE produit SET nom = :nom,objectif = :objectif,information = :information,effetIndesirable = :effetIndesirable,image = :image WHERE id = $id");
    $bvc1=$monObjPdoStatement->bindValue(':nom',$nom,PDO::PARAM_STR);
    $bvc2=$monObjPdoStatement->bindValue(':objectif',$objectif,PDO::PARAM_STR);
    $bvc3=$monObjPdoStatement->bindValue(':information',$information,PDO::PARAM_STR);
    $bvc4=$monObjPdoStatement->bindValue(':effetIndesirable',$effetIndesirable,PDO::PARAM_STR);
    $bvc5=$monObjPdoStatement->bindValue(':image',$image,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

/**
 * @param $id
 * @return $donnees
 * fonction qui permet d'afficher un produit modifié
 */
function afficheProduitModifie($id){
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id,nom,objectif,information,effetIndesirable,image FROM produit WHERE id = $id");
    if ($monObjPdoStatement->execute()) {
    $donnees = $monObjPdoStatement->fetch();
          
        return $donnees;
    }

    /**
     * @param $nom
     * @param $objectif
     * @param $information
     * @param $effetIndesirable
     * @param $images
     * fonction qui permet un produit
     */
function creerProduit($nom,$objectif,$information,$effeIndesirable,$images){
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("INSERT INTO produit VALUES (NULL,:nom,:objectif,:information,:effetIndesirable,:images)");
    $bvc1=$monObjPdoStatement->bindValue(':nom',$nom,PDO::PARAM_STR);
    $bvc2=$monObjPdoStatement->bindValue(':objectif',$objectif,PDO::PARAM_STR);
    $bvc3=$monObjPdoStatement->bindValue(':information',$information,PDO::PARAM_STR);
    $bvc4=$monObjPdoStatement->bindValue(':effetIndesirable',$effeIndesirable,PDO::PARAM_STR);
    $bvc5=$monObjPdoStatement->bindValue(':images',$images,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}


/**
 * @param $nom
 * @param $objectif
 * @param $url
 * @param $date
 * fonction qui permet de créer une visio
 */
function creerVisio($nom,$objectif,$url,$date){
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("INSERT INTO visioconference VALUES (NULL,:nom,:objectif,:url,:date,NULL)");
    $bvc1=$monObjPdoStatement->bindValue(':nom',$nom,PDO::PARAM_STR);
    $bvc2=$monObjPdoStatement->bindValue(':objectif',$objectif,PDO::PARAM_STR);
    $bvc3=$monObjPdoStatement->bindValue(':url',$url,PDO::PARAM_STR);
    $bvc4=$monObjPdoStatement->bindValue(':date',$date,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        return true;
      }else
      {
        return false;
      }
}

}
}
?>
