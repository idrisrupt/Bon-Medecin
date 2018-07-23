<?php
session_start();
require"connexionBDD.php";
if (!isset($_SESSION['id_patient']) && !isset($_SESSION['id_medecin'])) {
    if (isset($_POST['connexion'])) {
        $mailconnect = htmlentities(strtolower(trim($_POST['email'])));
        $mdpconnect = trim($_POST['mdp']);
        if (!empty($mailconnect) AND ! empty($mdpconnect)) {

            if (preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mailconnect)) {
                $requser = $bdd->prepare("SELECT * FROM patient WHERE email = ?");
                $requser->execute(array($mailconnect));
                $requser = $requser->fetch();
                $reqmed = $bdd->prepare("SELECT * FROM medecin WHERE email = ?");
                $reqmed->execute(array($mailconnect));
                $reqmed = $reqmed->fetch();
                
                if ($requser['email'] == $mailconnect) {

                    $hash = $requser['mdp'];
                    if (password_verify($mdpconnect, $hash)) {
                        $_SESSION['id_patient'] = $requser['id_patient'];
                        $_SESSION['email'] = $requser['email'];
                        $_SESSION['prenom'] = $requser['prenom'];
                        $_SESSION['nom'] = $requser['nom'];
                        header("Location: profile.php");
                    } else {
                        $erreur = "Mot de passe incorect";
                    }
                } elseif($reqmed['email'] == $mailconnect){
                    $hash = $reqmed['mdp'];
                    if (password_verify($mdpconnect, $hash)) {
                        $_SESSION['id_medecin'] = $reqmed['id_medecin'];
                        $_SESSION['email'] = $reqmed['email'];
                        $_SESSION['prenom'] = $reqmed['prenom'];
                        $_SESSION['nom'] = $reqmed['nom'];
                        header("Location: medecin.php");
                    }else {
                        $erreur = "Mot de passe incorect";
                    }

                }else {
                    $erreur = "Cette email n'exist pas veuillez créer un compte";
                }
            } else {
                $erreur = "Email incorect";
            }
        } else {
            $erreur = "Veuillez compléter tous les champs";
        }
    }
} 
if (isset($_SESSION['id_patient'])) {
    header("Location: profile.php");}
if(isset($_SESSION['id_medecin'])) {
    header("Location: medecin.php");
}
?>


<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Se Connecter</title>
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/seconnecter.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">

    </head>

    <body>


        <?php include("header.php") ?>

        <main id="main">

            <h2 id="titre" >  Connectez-vous pour accéder à votre compte</h2>

            <div class="form" >
                <div class="center">
                    <form id="login-form" method="post" action="">
                        <input type="email" id="email" name="email" placeholder="Email" required value="<?php
                        if (isset($mailconnect)) {
                            echo $mailconnect;
                        }
                        ?>"><br>
                        <input type="password" id="mdp" name="mdp" placeholder="Mot De Passe" required> <br>
                        <input type="submit" class="center" id="button" name="connexion" value="Se connecter" /><br>
                    </form>

                </div>
                <div class="center"><?php
                    if (isset($erreur)) {
                        echo '<font color="red">' . $erreur . "</font>";
                    }
                    ?>
                </div>
                 <div class="center">
                    <div>Vous n'êtes pas encore inscrit ? </div>

                
                </div>

                <div>
                     <a href="inscriptionP.php"> Inscrivez-vous » </a>
                </div>
            </div>
        </main>
        <?php include("footer.php") ?>
    </body>
</html>
