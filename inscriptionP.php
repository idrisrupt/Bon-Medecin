<?php
session_start();
require 'connexionBDD.php';
if (!isset($_SESSION['id_patient'])) {
    
        if (isset($_POST['inscription'])) {
            if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["date"]) && isset($_POST["lieu"]) && isset($_POST["adresse"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["mdp"]) && isset($_POST["mdpc"])) {

                $nom = htmlentities(trim($_POST['nom']));
                $prenom = htmlentities(trim($_POST['prenom']));
                $tel = htmlentities(trim($_POST['tel']));
                $lieu = htmlentities(trim($_POST['lieu']));
                $date = $_POST['date'];
                $email = htmlentities(strtolower(trim($_POST['email'])));
                $sexe = $_POST['sexe'];
                $mdp = trim($_POST['mdp']);
                $mdpc = trim($_POST['mdpc']);
                $adresse = htmlentities(trim($_POST['adresse']));


                if (preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $email)) {
                    $dispo = $bdd->prepare("SELECT email FROM patient WHERE email = ?");
                    $dispo->execute(array($email));
                    $dispo = $dispo->fetch();
                    if ($dispo['email'] == "") {
                        if (preg_match("^0(5|6|7)[0-9]{8}$^", $tel)) {
                            $exist = $bdd->prepare("SELECT tel FROM patient WHERE tel = ?");
                            $exist->execute(array($tel));
                            $exist = $exist->fetch();
                            if ($exist['tel'] == "") {
                                if ($mdp == $mdpc) {
                                    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                                    $sql = $bdd->prepare("INSERT INTO patient (nom, prenom, dat_nais, lieu_nais, sexe, adresse, email, tel, mdp) VALUES (?,?,?,?,?,?,?,?,?)");
                                    $sql->execute(array($nom, $prenom, $date, $lieu, $sexe, $adresse, $email, $tel, $mdp));
                                    $requser = $bdd->prepare("SELECT * FROM patient WHERE email = ? AND mdp = ?");
                                    $requser->execute(array($email, $mdp));
                                    $requser = $requser->fetch();

                                    $bdd = null;
                                    $_SESSION['id_patient'] = $requser['id_patient'];
                                    $_SESSION['email'] = $email;
                                    $_SESSION['prenom'] = $prenom;
                                    $_SESSION['nom'] = $nom;
                                    header("Location: profile.php");
                                } else {
                                    $erreur = "La confirmation du mot de passe ne correspond pas au mot de passe";
                                }
                            } else {
                                $erreur = "Ce numéro existe déja";
                            }
                        } else {
                            $erreur = "Numéro incorrect";
                        }
                    } else {
                        $erreur = "Cette email existe déjà";
                    }
                } else {
                    $erreur = "Email Incorrect";
                }
            } else {
                $erreur = "Veuillez remplir tous les champs";
            }
        }
    
} else {
    header('location:profile.php');
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <title>Inscription</title>
        <link href="css/inscriptionP.css" rel="stylesheet" type="text/css">
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
    </head>

    <body>

<?php include("header.php") ?>
        <main>
            <br/><br/><br/><br/><br/><br/>
            <div id="titre">
                <h3 id="title">Créer Votre Compte Patient</h3>
                <span id="lientitre">Vous avez déjà un compte <strong>BonMedecin</strong> ? <a id="conne" href="seconnecter.php">Se connecter</a></span> <br>
                <hr color="white"/>
            </div>

            <form method="post" action="">

                <table id="tab">

                    <tr>
                        <td><label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" placeholder="Entrer votre nom" value="<?php
                            if (isset($nom)) {
                                echo $nom;
                            }
                            ?>" required >
                        </td>
                        <td><label for="prenom">Prénom *</label>              
                            <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prénom" value="<?php
                            if (isset($prenom)) {
                                echo $prenom;
                            }
                            ?>" required >
                        </td>
                    </tr>
                    <tr>
                        <td><label for="date">Date de Naissance *</label>               
                            <input type="date" id="date" name="date" placeholder="jj/mm/aa" value="<?php
                            if (isset($date)) {
                                echo $date;
                            }
                            ?>" required >
                            <br></td>
                        <td><label for="lieu">Lieu de Naissance *</label>              
                            <input type="text" id="lieu" name="lieu" placeholder="Entrer votre lieu de naissance" value="<?php
                            if (isset($lieu)) {
                                echo $lieu;
                            }
                            ?>" required >
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sexe">Sexe *</label>	
                            <select id="sexe" name="sexe"> 
                                <option> Masculin </option>
                                <option> Feminin </option>
                            </select></td>
                        <td><label for="adresse">Adresse *</label>                
                            <input type="text" id="adresse" name="adresse"  placeholder="Entrer votre adresse" value="<?php
                            if (isset($adresse)) {
                                echo $adresse;
                            }
                            ?>" >
                        </td>
                    </tr>

                    <tr>

                        <td><label for="email">Email *</label>           
                            <input type="email" id="email" name="email" placeholder="Entrer votre email" value="<?php
                            if (isset($email)) {
                                echo $email;
                            }
                            ?>" required> 
                        </td>
                        <td><label for="tel">Numéro De Tél *</label>               
                            <input type="text" id="tel" name="tel" class="form" placeholder="Entrer votre numéro de téléphone" pattern="^0(5|6|7)[0-9]{8}$" value="<?php
                            if (isset($tel)) {
                                echo $tel;
                            }
                            ?>" required >
                        </td>
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot De Passe * </label>
                            <input type="password" id="mdp" name="mdp" placeholder="Saisir votre mot de passe"  required> 
                        </td>
                        <td><label for="mdpc">Confirmer Mot de Passe *</label>
                            <input type="password" id="mdpc" name="mdpc" placeholder="Confirmer votre mot de passe"  required>
                        </td>
                    </tr>

                </table>
            
                <center><font color="red"><?php if (isset($erreur)) echo $erreur; ?></font></center>
                <div id="btnenvoi">

                    <input type="submit" name="inscription" class="btn" value="Envoyer">
                </div>
                </form>
        </main>
<?php include("footer.php"); ?>
    </body>
</html>
