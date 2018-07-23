<?php
session_start();
require "connexionBDD.php";
if (isset($_POST['heure'])) {
$heure = $_POST['heure_rdv'];
$patient = $_SESSION['id_patient'];
$medecin = $_POST['id_medecin'];
$date = $_POST['date'];
$deja = $bdd->prepare("SELECT id_rdv FROM rdv WHERE id_patient = ? AND id_medecin=?");
$deja->execute(array($patient,$medecin));
$deja=$deja->fetch();
if ($deja['id_rdv'] == "") {
$dispo = $bdd->prepare("SELECT heure_rdv FROM rdv WHERE date_rdv = ? AND id_medecin=?");
$dispo->execute(array($date,$medecin));
$disp = true;
while ($donnee=$dispo->fetch()) {
	if ($donnee['heure_rdv'] == $heure) {
		$disp = false;
	}
}
if ($disp) {
	
	$rdv = $bdd->prepare("INSERT INTO rdv (id_patient,id_medecin,date_rdv,heure_rdv) VALUES (?,?,?,?)");
$rdv->execute(array($patient,$medecin,$date,$heure));
header('location:profile.php');
}else{
	$er="Heure non disponible Veuillez choisir une autre";
}
 }else{
  $er = "Vous avez déja un rendez vous chez ce médecin";
 }
}
  ?>

<!DOCTYPE html>
<html>
    <head>

        <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="css/bootstrap.min.js"></script>
        <script src="css/jquery-1.11.1.min.js"></script>

        <link rel="stylesheet" href="css/profile.css" >
        <link rel="stylesheet" type="text/css" href="css/rdvh.css">
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
                            
                        <form method="post" action="">
		<input type="text" value="<?php echo $_POST['id_medecin'] ?>"  name="id_medecin" hidden>
		<input type="text" value="<?php echo $_POST['date'] ?>"  name="date" hidden>
		<div class="table-title">
			<center>
<h3>Horaires</h3></center>
</div><center><font color="red"><?php if(isset($er)){echo $er;} ?></font>
	<div id="center"><table id="tabform1">
<tr>
	<th></th>
	<th>Mâtin</th>
</tr>
		<tr><td>
			<input type="radio" value="09:00:00" id="r1" name="heure_rdv">
		</td><td>
			<label for="r1">09h00 - 09h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="09:30:00" id="r2" name="heure_rdv">
		</td><td>
			<label for="r2">09h30 - 10h00</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="10:00:00" id="r3" name="heure_rdv">
		</td><td>
			<label for="r3">10h00 - 10h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="10:30:00" id="r4" name="heure_rdv">
		</td><td>
			<label for="r4">10h30 - 11h00</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="11:00:00" id="r5" name="heure_rdv">
		</td><td>
			<label for="r5">11h00 - 11h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="11:30:00" id="r6" name="heure_rdv">
		</td><td>
			<label for="r6">11h30 - 12h00</label>
		</td></tr>

	</table><br>
	<table id="tabform2">
<tr>
	<th></th>
	<th>Après-Midi</th>
</tr>
		<tr><td>
			<input type="radio" value="13:00:00" id="r7" name="heure_rdv">
		</td><td>
			<label for="r7">13h00 - 13h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="13:30:00" id="r8" name="heure_rdv">
		</td><td>
			<label for="r8">13h30 - 14h00</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="14:00:00" id="r9" name="heure_rdv">
		</td><td>
			<label for="r9">14h00 - 14h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="14:30:00" id="r10" name="heure_rdv">
		</td><td>
			<label for="r10">14h30 - 15h00</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="15:00:00" id="r11" name="heure_rdv">
		</td><td>
			<label for="r11">15h00 - 15h30</label>
		</td></tr>
		<tr><td>
			<input type="radio" value="15:30:00" id="r12" name="heure_rdv">
		</td><td>
			<label for="r12">15h30 - 16h00</label>
		</td></tr>

	</table>
	</div><br>
	<input type="submit" name="heure" class="btn" value="Confirmer">
	</form></center><br>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>

