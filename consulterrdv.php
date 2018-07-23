<?php
session_start();
include 'connexionBDD.php';
$med=$bdd->prepare("SELECT * FROM medecin WHERE id_medecin=?");
$med->execute([$_SESSION['id_medecin']]);
$med=$med->fetch();
$spe=$bdd->prepare("SELECT * FROM specialite WHERE id_specialite=?");
$spe->execute([$med['id_specialite']]);
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
        <meta charset="utf-8">
    <link href="dist/helloweek.min.css" rel="stylesheet">
<link href="demos/css/demo.css" rel="stylesheet">
<script src="cal/dist/helloweek.min.js" type="text/javascript"></script>
        <title>Consultation</title>
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
                        <!-- END MENU -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <center>
                            
    <h1 class="slogan">Choisissez une Date</h1><br>
    <?php include 'cal.php'; ?><br>
    <div id="formd">
    <form method="post" action="liste_patients.php" >
    <input type="text" name="date" id="date" hidden>
    
<input type="submit" name="" class="btn" value="Afficher Liste Patients >>">
</form></div><br>
                            
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>
