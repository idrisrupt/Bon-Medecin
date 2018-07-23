<?php
session_start();
require 'connexionBDD.php';
$specialite = $_GET['specialite'];
$medecin = htmlentities(trim($_GET['medecin']));
$ville = $_GET['ville'];
if (!empty($_GET['specialite']) && !empty($_GET['medecin']) && !empty($_GET['ville'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE nom = ? AND id_specialite = ? AND ville = ? ORDER BY nom');
    $med->execute(array($medecin, $specialite, $ville));
    
} elseif (!empty($_GET['specialite']) && !empty($_GET['medecin'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE nom = ? AND id_specialite = ? ORDER BY nom');
    $med->execute(array($medecin, $specialite));
    
} elseif (!empty($_GET['specialite']) && !empty($_GET['ville'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE id_specialite = ? AND ville = ? ORDER BY nom');
    $med->execute(array($specialite, $ville));

} elseif (!empty($_GET['ville']) && !empty($_GET['medecin'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE nom = ? AND ville = ? ORDER BY nom');
    $med->execute(array($medecin, $ville));
    
} elseif (!empty($_GET['ville'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE ville = ? ORDER BY nom');
$med->execute(array($ville));

} elseif (!empty($_GET['specialite'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE id_specialite = ? ORDER BY nom');
    $med->execute(array($specialite));

} elseif (!empty($_GET['medecin'])) {
    $med = $bdd->prepare('SELECT * FROM medecin WHERE nom = ? ORDER BY nom');
    $med->execute(array($medecin));
    
}
if (empty($med)) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/recherche.css">
        <link rel="stylesheet" type="text/css" href="css/footer.css">
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Resultats Recherche</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <br><br>
        <?php include 'research.php'; ?>
        <br><br>
        <table id="result">
            <?php $x=1;  while ($donnee = $med->fetch()){ $x=0;?><tr><td>
                <?php if (strcmp($donnee['sexe'],"Masculin") == 0) {
                  echo '<img src="images/profil_male.jpg"/>';

                }
                if (strcmp($donnee['sexe'],"Feminin") == 0) {
                 echo "<img src='images/profil_fem.jpg'/>";
                  
                }
                ?>
                <?php if (strcmp($donnee['sexe'],"Masculin") == 0) {
                  echo 'Mr.';

                }
                if (strcmp($donnee['sexe'],"Feminin") == 0) {
                 echo "Mme.";
                  
                }
                ?>
                <?php echo strtoupper($donnee['nom']); ?>
            <?php echo ucfirst($donnee['prenom']); ?> <br><br>
            <?php $spe=$bdd->prepare('SELECT specialite FROM specialite WHERE id_specialite=?');
                  $spe->execute(array($donnee['id_specialite']));
                  $spe=$spe->fetch();
            echo ucfirst($spe['specialite']); ?>
            </td><td>
            <li class="li1"><?php echo $donnee['adresse']; ?></li><br>
            <li class="li2"><?php echo $donnee['ville']; ?></li>
            </td><td>
                <?php if (!isset($_SESSION['id_patient'])) { ?>
                <center><a href='inscriptionP.php' class="lien">Inscrivez-Vous</a><br> Pour Prendre Rendez Vous</center>
            <?php } else { ?><form method="post" action="rdvd.php">
                <input type="text" name="id_medecin" value="<?php echo $donnee['id_medecin']; ?>" hidden>
                <button class="prendrerdv" type="submit" class="btn">Prendre Rendez-Vous</button>

            </form>
            <?php }?>
            </td>
        </tr>   
            <?php } 
            echo ($x)? '<h2 style="color:white" id="slogan">Aucuns Medecins Trouvés</h2>':"";
            $med->closeCursor();
             ?>
        </table>
        <br><br>
        <?php include 'footer.php'; ?>
    </body>
</html>