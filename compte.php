<?php
session_start();
include 'connexionBDD.php';

if (isset($_SESSION['id_patient']) || isset($_SESSION['id_medecin'])) {
   

if (isset($_SESSION['id_patient'])){
// On récupère les informations de l'utilisateur connecté
$afficher_profil = $bdd->prepare("SELECT * FROM patient WHERE id_patient = ?");
$afficher_profil->execute([$_SESSION['id_patient']]);
$afficher_profil = $afficher_profil->fetch();
}elseif(isset($_SESSION['id_medecin'])) {
    $afficher_profil = $bdd->prepare("SELECT * FROM medecin WHERE id_medecin = ?");
$afficher_profil->execute([$_SESSION['id_medecin']]);
$afficher_profil = $afficher_profil->fetch();
}

if (!empty($_POST)) {
    $valid = true;

    if (isset($_POST['modification'])) {

        $nom = htmlentities(trim($_POST['nom']));
        $prenom = htmlentities(trim($_POST['prenom']));
        $mail = htmlentities(strtolower(trim($_POST['mail'])));

        if (empty($nom)) {
            $valid = false;
            $er_nom = "Il faut mettre un nom";
        }

        if (empty($prenom)) {
            $valid = false;
            $er_prenom = "Il faut mettre un prénom";
        }

        if (empty($mail)) {
            $valid = false;
            $er_mail = "Il faut mettre un mail";
        } elseif (!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)) {
            $valid = false;
            $er_mail = "Le mail n'est pas valide";
        } else {if (isset($_POST['id_medecin'])) {
            $req_mail = $bdd->prepare("SELECT email 
                    FROM medecin 
                    WHERE email = ?");
            $req_mail->execute([$mail]);
        }elseif (isset($_POST['id_patient'])) {
            $req_mail = $bdd->prepare("SELECT email 
                    FROM patient 
                    WHERE email = ?");
            $req_mail->execute([$mail]);
        }
            $req_mail = $bdd->prepare("SELECT email 
                    FROM patient 
                    WHERE email = ?");
            $req_mail->execute([$mail]);

            $req_mail = $req_mail->fetch();

            if ($req_mail['email'] <> "" && $_SESSION['email'] != $req_mail['email']) {
                $valid = false;
                $er_mail = "Ce mail existe déjà";
            }
        }

        if ($valid) {

          

if (isset($_SESSION['id_patient'])){
// On récupère les informations de l'utilisateur connecté
$afficher_profil = $bdd->prepare("UPDATE patient SET prenom = ?, nom = ?, email = ? WHERE id_patient = ?");
$afficher_profil->execute([$prenom, $nom, $mail, $_SESSION['id_patient']]);
$_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['mail'] = $mail;
}elseif(isset($_SESSION['id_medecin'])) {
    $afficher_profil = $bdd->prepare("UPDATE medecin SET prenom = ?, nom = ?, email = ? WHERE id_medecin = ?");
$afficher_profil->execute([$prenom, $nom, $mail, $_SESSION['id_medecin']]);

}
   $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['email'] = $mail;

            header('Location:  compte.php');           
        }
    }
}}
?>
<!DOCTYPE html>
<html>
    <head>
         <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="css/bootstrap.min.js"></script>
        <script src="css/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="css/profile.css" >
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/footer.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modifier votre profil</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
<br><br><br><br><br>
       <main>
           
<div class="container">
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="images/Artboard 2.svg" class="img-responsive" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?php echo strtoupper($_SESSION['nom']) . ' ' . ucfirst($_SESSION['prenom']); ?>
                            </div>
                            <div class="profile-usertitle-job">
                                <?php
                                if (isset($_SESSION['id_patient'])) {
                                    echo "Patient";
                                } elseif (isset($_SESSION['id_medecin'])) {
                                    echo "Medecin";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="profile-usermenu">
                            <ul class="nav">
                               <?php if (isset($_SESSION['id_patient'])) {echo '
                                   
                              
                                <li class="active">
                                    <a href="profile.php">
                                        
                                        Profile </a>
                                </li>
                                <li>
                                    <a href="prendrerdv.php">
                                        
                                        Prendre Rendez-Vous </a>
                                </li>
                                <li>
                                    <a href="gererrdv.php">
                                        
                                        Gérer Rendez-Vous </a>
                                </li>
                                <li>
                                    <a href="compte.php">
                                       
                                        Paramétre Compte </a>
                                </li>';
                                }
                             if (isset($_SESSION['id_medecin'])) {echo '
                                   
                              
                                <li class="active">
                                    <a href="medecin.php">
                                        
                                        Profile </a>
                                </li>
                                <li>
                                    <a href="consulterrdv.php">
                                        
                                        Consulter Rendez-Vous </a>
                                </li>
                                <li>
                                    <a href="compte.php">
                                       
                                        Paramétre Compte </a>
                                </li>
                                '; }?>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <center>
                            <h3>Modification</h3>
                        </center><br><br><br><br>
        <form method="post" action="" id="modform">

            <?php
            if (isset($er_nom)) {
                ?>
                <div><?= $er_nom ?></div>
                <?php
            }
            ?>
            <input type="text" placeholder="Votre nom" id="textfield1"  name="nom" value="<?php
            if (isset($nom)) {
                echo $nom;
            } else {
                echo $afficher_profil['nom'];
            }
            ?>" required>   <br>

            <?php
            if (isset($er_prenom)) {
                ?>
                <div><?= $er_prenom ?></div>
                <?php
            }
            ?>
            <input type="text" placeholder="Votre prénom" name="prenom" id="textfield1" value="<?php
            if (isset($prenom)) {
                echo $prenom;
            } else {
                echo $afficher_profil['prenom'];
            }
            ?>" required>   <br>

            <?php
            if (isset($er_mail)) {
                ?>
                <div><?= $er_mail ?></div>
                <?php
            }
            ?>
            <input type="email" placeholder="Adresse mail"  name="mail" id="textfield1" value="<?php
            if (isset($mail)) {
                echo $mail;
            } else {
                echo $afficher_profil['email'];
            }
            ?>" required><br>

            <button type="submit" name="modification" class="btn">Modifier</button>

        </form>
                        
                    </div>
                </div>
            </div>
        </div>

       </main>

<?php include 'footer.php'; ?>
</body>
</html>   