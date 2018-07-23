<?php
session_start();
include 'connexionBDD.php';
?>
<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bon Medecin</title>
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <link href="css/accueil.css" rel="stylesheet" type="text/css">
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
        
    </head>

    <body>
        <?php include("header.php") ?>
        <main>
            <div id="divtop">
                <h1 id="slogan">Prenez Votre Rendez-Vous En Un Seul Clic</h1>
                <p id="slogon1"><strong>Simple,Gratuit et Immédiat</strong>
                </p>
                <div id="divtab">
                    <form id="form1" method="get" action="recherche.php">
                        <select name="specialite" id="select">

                            <option value="">Spécialité...</option>
                            <?php
                            $spe = $bdd->prepare('SELECT * FROM specialite');
                            $spe->execute();

                            while ($donnee = $spe->fetch()) {
                                ?>
                                <option value="<?php echo($donnee['id_specialite']); ?>"><?php echo($donnee['specialite']); ?></option>
                            <?php
                            }
                            $spe->closeCursor();
                            ?>
                        </select>

                        <input type="text" name="medecin" id="textfield1" placeholder="Médecin">
                        <select id="ville" name="ville"> 
                            <option value=""> Ville... </option>        
                            <option value="adekar"> ADEKAR </option>
                            <option value="akbou"> AKBOU </option>
                            <option value="amizour"> AMIZOUR </option>
                            <option value="aokas"> AOKAS </option>
                            <option value="barbacha"> BARBACHA </option>
                            <option value="bejaia"> BEJAIA </option>
                            <option value="beni maouche"> BENI MAOUCHE </option>
                            <option value="chemini"> CHEMINI </option>
                            <option value="darguina"> DARGUINA </option>
                            <option value="elkseur"> EL KSEUR </option>
                            <option value="ifri ouzellaguene"> IFRI OUZELLAGUENE </option>
                            <option value="ighil ali"> IGHIL ALI </option>
                            <option value="kherrata"> KHERRATA </option>
                            <option value="seddouk"> SEDDOUK </option>
                            <option value="sidi aich"> SIDI AICH </option>
                            <option value="SOUK EL TENINE"> SOUK EL TENINE </option>
                            <option value="tazmalt"> TAZMALT </option>
                            <option value="tichy"> TICHY </option>
                            <option value="timezrit"> TIMEZRIT </option>
                        </select>
                        <input name="recherche" type="submit" class="btn" value="Rechercher">
                    </form>
                </div>
            </div>
            <div id="divmid">
                <div id="div2">
                    <img src="images/free-icon.png" width="100" height="101" alt=""/><strong class="labelinfo">Services 100% Gratuit</strong>
                    <img src="images/timer-icon-blue.png" width="100" height="100"><strong class="labelinfo">Prise De Rendez-Vous 7J/7 24H/24</strong>
                    <img src="images/doctor-icon-red.png" width="100" height="100" alt=""/>
                    <strong class="labelinfo">Votre Médecin à Distance</strong>
                </div>
            </div>
             <br><br>
            <div id="divbot">
                <img src="images/mdc.png" id="md"/>
                <br>
                
               
                
                    
                <h3 id="titrebot">Notre Mission </h3>
                <br><br>
            <div id="su-cad">
                 <img src="images/cadna.png" width="120" height="120" id="cad"/>
                <img src="images/su-pc.png" width="120" height="120" id="supc"/>
                <img src="images/net.png" width="120" height="120" id="supc"/>
            </div>
                <br>
                <p id="titre">  </p>
                <div id="texte1">
                 <h3 id="hh1">Sécurité et Confidentialité</h3>
                     <h3 id="hh2">Une interface simple et Ergonomique</h3>
                      <h3 id="hh3">Fortifiez votre réseau</h3>
                </div>
            <div id="texte2">
               
              <p id="tx1"> 
                BonMedecin assure la sécuritée et la <br>
                     Confidentialité des donnés<br>
                          Des utilisateurs.</p>

              <p id="tx2"> Cette interface repond parfaitment <br>
               Aux besoins de l'utilisateur <br>en le mettant à l'aise.
                           </p>

               <p id="tx3"> Restez connectés, et fortifiez votre réseau<br> de Patients 
           grâce aux différents<br> outils de BonMedecin. </p>
           
            </div>
            <br><br>
    </main>

        		<?php include("footer.php");?>
        


    </body>

</html>