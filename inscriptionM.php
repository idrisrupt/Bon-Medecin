<?php
session_start();
require 'connexionBDD.php';
if (!isset($_SESSION['id_medecin'])) {
    if (!isset($_SESSION['id_patient'])) {
        if (isset($_POST['inscription'])) {
            if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["date"]) && isset($_POST["lieu"]) && isset($_POST["sexe"]) && isset($_POST["specialite"]) && isset($_POST["n_ordre"]) && isset($_POST["ville"]) && isset($_POST["adresse"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["mdp"]) && isset($_POST["mdpc"])) {

                $nom = htmlentities(trim($_POST['nom']));
                $prenom = htmlentities(strtolower(trim($_POST['prenom'])));
                $tel = htmlentities(trim($_POST['tel']));
                $lieu = htmlentities(trim($_POST['lieu']));
                $date = $_POST['date'];
                $email = htmlentities(strtolower(trim($_POST['email'])));
                $sexe = $_POST['sexe'];
                $mdp = trim($_POST['mdp']);
                $mdpc = trim($_POST['mdpc']);
                $adresse = htmlentities(trim($_POST['adresse']));
                $specialite = $_POST["specialite"];
                $n_ordre = htmlentities(trim($_POST["n_ordre"]));
                $ville = $_POST["ville"];


                if (preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $email)) {
                    $dispo = $bdd->prepare("SELECT email FROM medecin WHERE email = ?");
                    $dispo->execute(array($email));
                    $dispo = $dispo->fetch();
                    if ($dispo['email'] == "") {
                        if (preg_match("^0(5|6|7|3)[0-9]{8}$^", $tel)) {
                            $exist = $bdd->prepare("SELECT tel FROM medecin WHERE tel = ?");
                            $exist->execute(array($tel));
                            $exist = $exist->fetch();
                            if ($exist['tel'] == "") {
                                if ($mdp == $mdpc) {
                                    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                                    $cal = $bdd->prepare("INSERT INTO calendrier VALUES()");
                                    $cal->execute();
                                    $med = $bdd->prepare("INSERT INTO medecin (id_specialite,id_cal,nom, prenom, dat_nais, lieu_nais, sexe, adresse, email, tel, mdp,n_ordre,ville) VALUES (?,LAST_INSERT_ID(),?,?,?,?,?,?,?,?,?,?,?)");
                                    $med->execute(array($specialite, $nom, $prenom, $date, $lieu, $sexe, $adresse, $email, $tel, $mdp, $n_ordre, $ville));
                                    $reqmed = $bdd->prepare("SELECT * FROM medecin WHERE email = ? AND mdp = ?");
                                    $reqmed->execute(array($email, $mdp));
                                    $reqmed = $reqmed->fetch();


                                    $_SESSION['id_medecin'] = $reqmed['id_medecin'];
                                    $_SESSION['email'] = $email;
                                    $_SESSION['prenom'] = $prenom;
                                    $_SESSION['nom'] = $nom;
                                    $_SESSION['specialite'] = $specialite;
                                    header("Location: medecin.php?id=" . $_SESSION['id_medecin']);
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
} else {
    header('location:medecin.php');
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
        <link href="css/inscriptionM.css" rel="stylesheet" type="text/css">
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <?php include("header.php") ?>
        <br/><br/><br/><br/><br/><br/>
        <main>
            <div id="titre">
                <h3 id="title">Créer Votre Compte Medecin</h3>
                <span id="lientitre">Vous avez déjà un compte <strong>BonMedecin</strong> ? <a id="conne" href="seconnecter.php" >Se connecter</a></span> <br>
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
                        <td>
                            <table><tr>
                                    <td><label for="specialite">Spécialité *</label>  </td>
                                    <td><label for="n_ordre">N° Ordre *</label></td>
                                </tr>
                                <tr>  <td>             
                                        <select id="specialite" name="specialite" class="form"> 

                                            <option value="">Spécialité...</option>
                                            <?php
                                            $spe = $bdd->prepare('SELECT * FROM specialite');
                                            $spe->execute();
                                            while ($donnee = $spe->fetch()) {
                                                ?>
                                                <option value="<?php echo($donnee['id_specialite']) ?>"><?php echo($donnee['specialite']) ?></option>
                                            <?php
                                            }
                                            $spe->closeCursor();
                                            ?>
                                        </select>
                                    </td>
                                    <td><input  type="text" id="n_ordre" name="n_ordre" class="form" placeholder="Votre numéro d'ordre"  ></td>
                                </tr></table>
                        </td>
                    </tr>


                    <tr>
                        <td><label for="ville">Ville *</label>  
                            <select id="ville" name="ville">       
                                <option value="ADEKAR"> ADEKAR </option>
                                <option value="AKBOU"> AKBOU </option>
                                <option value="AMIZOUR"> AMIZOUR </option>
                                <option value="AOKAS"> AOKAS </option>
                                <option value="BARBACHA"> BARBACHA </option>
                                <option value="BEJAIA"> BEJAIA </option>
                                <option value="BENI MAOUCHE"> BENI MAOUCHE </option>
                                <option value="CHEMINI"> CHEMINI </option>
                                <option value="DARGUINA"> DARGUINA </option>
                                <option value="EL KSEUR"> EL KSEUR </option>
                                <option value="IFRI OUZELLAGUENE"> IFRI OUZELLAGUENE </option>
                                <option value="IGHIL ALI"> IGHIL ALI </option>
                                <option value="KHERRATA"> KHERRATA </option>
                                <option value="SEDDOUK"> SEDDOUK </option>
                                <option value="SIDI AICH"> SIDI AICH </option>
                                <option value="SOUK EL TENINE"> SOUK EL TENINE </option>
                                <option value="TAZMALT"> TAZMALT </option>
                                <option value="TICHY"> TICHY </option>
                                <option value="TIMEZRIT"> TIMEZRIT </option>
                            </select></td>



                        <td><label for="adresse">Adresse *</label>                
                            <input type="text" id="adresse" name="adresse"  placeholder="Adresse de votre cabinet" value="<?php
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
                            <input type="text" id="tel" name="tel" class="form" placeholder="Entrer votre numéro de téléphone" pattern="^0(5|6|7|3)[0-9]{8}$" value="<?php
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

                    <input type="submit" id="submit" name="inscription" value="Envoyer">
                </div>
            </form>
        </main>
        <?php include("footer.php"); ?>
    </body>

</html>
