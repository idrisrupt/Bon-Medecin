<?php
session_start();
require 'connexionBDD.php';
$id_patient = $_SESSION['id_patient'];
$rdv = $bdd->prepare("SELECT * FROM rdv WHERE id_patient = ?");

$rdv->execute(array($id_patient));

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
        <title>Profile</title>
    </head>
    <body>
        <?php include 'header.php'; ?><br><br><br><br><br>
        <div class="container">
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar">
                        <div class="profile-userpic">
                            <img src="images/Artboard 2.svg" class="img-responsive" alt="">
                        </div>
                        
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
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <center>
                            <h3>Mes Rendez-Vous</h3><br>
                        
                        <table>
                            <?php while ($affiche=$rdv->fetch()) {?>
                                <tr>
                                    <td><center><p>Rendez-Vous le <?php echo $affiche['date_rdv']; ?><br><br> à <?php echo $affiche['heure_rdv']; ?></center></p></td>
                                    <td><p>Chez <?php $nom = $bdd->prepare("SELECT * FROM medecin WHERE id_medecin = ?"); $nom->execute([$affiche['id_medecin']]); $nom=$nom->fetch();echo (strcmp($nom['sexe'], 'Masculin'))?'Mme.':'Mr.';echo ' ';echo $nom['nom'];echo ' ';echo ucfirst($nom['prenom']);$spe = $bdd->prepare("SELECT * FROM specialite WHERE id_specialite = ?"); $spe->execute([$nom['id_specialite']]); $spe=$spe->fetch();echo '<br><center>';echo $spe['specialite'];echo '</center>'; ?></p></td>
                                    
                                </tr>
                           <?php } ?>
                        </table></center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>

