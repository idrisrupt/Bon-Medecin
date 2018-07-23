<?php
session_start();
require 'connexionBDD.php';
$pat=$bdd->prepare("SELECT * FROM rdv WHERE id_medecin=? AND date_rdv=? ORDER BY heure_rdv");
$pat->execute([$_SESSION['id_medecin'],$_POST['date']]);
$affiche=$pat->fetch();

  ?>
<!DOCTYPE html>
<html>
    <head>

        <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="css/bootstrap.min.js"></script>
        <script src="css/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/profile.css" >
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
                                
                                    Medecin
                                
                            
                            </div>
                        </div>

                        <div class="profile-usermenu">
                            <ul class="nav">
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

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <center>
                            <h3>Liste Des Patients</h3>
                            <h5>Pour Le <?php echo $_POST['date']; ?></h5>
                            <?php if (empty($affiche)) {
                                echo "<br><br><h4>Aucuns Patients Pour Aujourd'hui</h4>";
                            } ?>
                            <table>
                                <?php  do { 
                                    if (!empty($affiche)) {
echo '<tr>';echo '<td>'; echo $affiche['heure_rdv']; echo '</td>';
echo '<td>'; $patient=$bdd->prepare('SELECT * FROM patient WHERE id_patient=?');$patient->execute([$affiche['id_patient']]);$patient=$patient->fetch(); echo strtoupper($patient['nom']);echo ' ';echo ucfirst($patient['prenom']);  echo '</td>';echo '</tr>';
                                    
                              }} while ($affiche=$pat->fetch()); ?>
                            </table>
                            
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>