<?php
session_start();
require 'connexionBDD.php';

$medecin = $_POST['id_medecin'];
if (isset($_POST['modifier'])) {
    
    $sup = $bdd->prepare('DELETE FROM rdv WHERE id_patient=? AND id_medecin=?');
    $sup->execute([$_SESSION['id_patient'],$medecin]);
    

}

  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="dist/helloweek.min.css" rel="stylesheet">
<link href="demos/css/demo.css" rel="stylesheet">
<script src="cal/dist/helloweek.min.js" type="text/javascript"></script>
     <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="css/bootstrap.min.js"></script>
        <script src="css/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="css/profile.css" >
        <link rel="stylesheet" type="text/css" href="css/header.css">
<link rel="stylesheet" type="text/css" href="css/footer.css">
	<title>Rendez-Vous</title>
</head>
<body>
	<?php include 'header.php'; ?>
	<br><br><br> 

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
                            <h1>Choisissez une Date</h1>
	<?php include 'cal.php'; ?><br>
	<div id="formd">
	<form method="post" action="rdvh.php" >
    <input type="text" name="date" id="date" hidden>
    <input type="text" name="id_medecin" value="<?php echo $medecin; ?>" hidden>
    <center><input type="submit" name="" class="btn" value="Afficher Horaires Disponible >>"></center>
</form></div><br>
                            </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>
