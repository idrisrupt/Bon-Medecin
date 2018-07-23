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

                        <input type="text" name="medecin" id="textfield1" placeholder="Médecin" value="<?php if(isset($medecin)){echo $medecin;} ?>">
                        <select id="select" name="ville"> 
                            <option value=""> Ville... </option>        
                            <option value="ADEKAR"> ADEKAR </option>
                            <option value="AKBOU"> AKBOU </option>
                            <option value="AMIZOUR"> AMIZOUR </option>
                            <option value="AOKAS"> AOKAS </option>
                            <option value="BARBACHA"> BARBACHA </option>
                            <option value="BEJAIA"> BEJAIA </option>
                            <option value="BENI MAOUCHE"> BENI MAOUCHE </option>
                            <option value="CHEMINI"> CHEMINI </option>
                            <option value="DARGUINA"> DARGUINA </option>
                            <option value="EL KSEUR"> EL KSEUR </option>
                            <option value="IFRI OUZELLAGUENE"> IFRI OUZELLAGUENE </option>
                            <option value="IGHIL ALI"> IGHIL ALI </option>
                            <option value="KHERRATA"> KHERRATA </option>
                            <option value="SEDDOUK"> SEDDOUK </option>
                            <option value="SIDI AICH"> SIDI AICH </option>
                            <option value="SOUK EL TENINE"> SOUK EL TENINE </option>
                            <option value="TAZMALT"> TAZMALT </option>
                            <option value="TICHY"> TICHY </option>
                            <option value="TIMEZRIT"> TIMEZRIT </option>
                        </select>
                        <input name="recherche" type="submit" class="btn1" id="btnrech" value="Rechercher">
                    </form>
                </div>
        