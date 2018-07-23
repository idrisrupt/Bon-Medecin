<?php
session_start();
require 'connexionBDD.php';


if (isset($_POST['entenvoi'])) {
	$txtnom= htmlentities(trim($_POST['entnom']));
$txtmail= htmlentities(strtolower(trim($_POST['entmail'])));
$txtobjet= htmlentities(trim($_POST['entobj']));
$txtmessa= htmlentities(trim($_POST['entmessa']));

 if (preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $txtmail)){
if (isset($_SESSION['id_medecin'])) {
	$nomb= $bdd->prepare("INSERT INTO message_medecin (id_medecin,objet, contenu) VALUES (?,?,?)");
 $nomb->execute([$_SESSION['id_medecin'],$txtobjet, $txtmessa]);
}else{
 $nomb= $bdd->prepare("INSERT INTO message_patient (nom,email,objet, contenu) VALUES (?,?,?,?)");
 $nomb->execute([$txtnom,$txtmail,$txtobjet, $txtmessa]);
  }
}
else{
	$erreur ="Email incorrect";
}}
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="css/contact.css" rel="stylesheet" type="text/css" ">
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php include "header.php" ?>
        <div class="contact" id="contact">
            <div class="container">
                <h3>Contactez Nous</h3>
                <p>Contactez-nous pour en savoir plus sur BonMedecin</p>
                <?php if (isset($erreur)) {
                	echo $erreur;
                } ?>
                <form method="post" action="">
                <div class="column">
                    <div class="text-field-name-1">
                        
                            <input type="text" class="text" name="entnom" value="Entrer votre nom" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = ' Entrer votre nom';
                                    }">
                        
                    </div>
                    <div class="text-field-email-1">
                        
                            <input type="text" class="text" name="entmail" value=" Entrer votre email" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Entrer votre email';
                                    }">
                        
                    </div>
                    <div class="text-field-subject-1">
                        
                            <input type="text" class="text" name="entobj" value=" Objet" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = ' Objet';
                                    }">
                        
                    </div>
                </div>
                <div class="column">
                    <div class="text-field-area-">
                        
                            <textarea  name="entmessa" value="Message:" onfocus="if (this.value == 'Message')
                                        this.value = '';" onblur="if (this.value == '')
                                                    this.value = 'Message';">Message</textarea>
                        
                    </div>
                    <div class="button">
                        
                            <input type="submit" name="entenvoi" class="btn" value="Envoyer">
                        
                    </div>
                </div>
                <div class="clearfix"> </div>
            </form></div>
        </div>
<?php include "footer.php" ?>
    </body>
</html>