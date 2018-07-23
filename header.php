<header>

    <a href="index.php"><img src="images/LOG.png" alt="BonMedecin" id="imglogo"/></a>
    <nav>
        <ul id="navliste" >

            <?php
            if (isset($_SESSION['id_patient']) ) {
                echo '<li><a href="index.php" class="btn">Accueil</a>
					</li>
					<li><a href="profile.php" class="btn">Mon Compte</a>
					</li>
					<li><a href="contact.php" class="btn">Nous Contacter</a>
					</li>
					<li><a href="deconnexion.php" class="btn">Se Deconnecter</a>
					</li>';
            }elseif (isset($_SESSION['id_medecin'])) {
            	
            echo '<li><a href="index.php" class="btn">Accueil</a>
					</li>
					<li><a href="medecin.php" class="btn">Mon Compte</a>
					</li>
					<li><a href="contact.php" class="btn">Nous Contacter</a>
					</li>
					<li><a href="deconnexion.php" class="btn">Se Deconnecter</a>
					</li>';

            } else {
            	echo '<li><a href="index.php" class="btn">Accueil</a>
				</li>
				<li><a href="inscriptionP.php" class="btn">S\'inscrire</a>
				</li>
				<li><a href="seconnecter.php" class="btn">Se connecter</a>
				</li>
				<li><a href="contact.php" class="btn">Nous Contacter</a>
				</li>
				<li><a href="inscriptionM.php" id="btnpro">Vous êtes un Medecin ?</a>
				</li>';
                
            }
            ?>

        </ul>
    </nav>
</header>
