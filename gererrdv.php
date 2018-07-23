<?php
session_start();
require 'connexionBDD.php';
$id_patient = $_SESSION['id_patient'];
$rdv = $bdd->prepare("SELECT * FROM rdv WHERE id_patient = ?");
$rdv->execute(array($id_patient));
$affiche=$rdv->fetch();
if (isset($_POST['annuler'])) {
    $sup = $bdd->prepare('DELETE FROM rdv WHERE id_patient=? AND id_medecin=?');
    $sup->execute([$id_patient,$_POST['id_medecin']]);
    header('location:gererrdv.php');
}

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
                                Patient
                                
                            </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->

                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                       <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active">
                                    <a href="profile">
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
                        <!-- END MENU -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <center>
                            <h3>Mes Rendez-Vous</h3><br>
                            <table>
                            <?php do {if(!empty($affiche)){?>
                                <tr>
                                    <td><center><p>Rendez-Vous le <?php echo $affiche['date_rdv']; ?><br><br> à <?php echo $affiche['heure_rdv']; ?></p></td>
                                    <td><p>Chez <?php $nom = $bdd->prepare("SELECT * FROM medecin WHERE id_medecin = ?"); $nom->execute([$affiche['id_medecin']]); $nom=$nom->fetch();echo (strcmp($nom['sexe'], 'Masculin'))?'Mme.':'Mr.';echo ' ';echo $nom['nom'];echo ' ';echo ucfirst($nom['prenom']);$spe = $bdd->prepare("SELECT * FROM specialite WHERE id_specialite = ?"); $spe->execute([$nom['id_specialite']]); $spe=$spe->fetch();echo '<br><center>';echo $spe['specialite'];echo '</center>'; ?></p></center></td>
                                    <td><form method="post" action="rdvd.php">
                                        <input type="submit" name="modifier" class="btn" value="Modifier">
                                        <input type="text" name="id_medecin" value="<?php echo $affiche['id_medecin']; ?>" hidden>

                                    </form><br><form method="post" action="">
                                        <input type="submit" name="annuler" class="btn" value="Annuler">
                                        <input type="text" name="id_medecin" value="<?php echo $affiche['id_medecin']; ?>" hidden>
                                    </form></td>
                                </tr>
                           <?php }}while ($affiche=$rdv->fetch()); ?>
                        </table>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>