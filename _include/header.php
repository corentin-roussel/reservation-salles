<article>
    <nav class="nav"> <!-- bar de navigation a affichage conditionnelle  accueil afficher en permanence-->
                    <a class="link" href="index.php">Accueil</a>
        <?php if(!isset($_SESSION['id'])) {   ?>   <!-- si il n'ya pas d'id de session afficher inscription plus conenxion-->
                    <a class="link" href="inscription.php">Inscription</a>
                    <a class="link" href="connexion.php">Connexion</a>
        <?php   }else{?>                                        <!-- sinon afficher accueil profil et deconnexion-->
                    <a class="link" href="profil.php">Profil</a>
                    <a class="link" href="reservation-form.php">Réservations</a>
                    <a class="link" href="planning.php">Planning</a>
                    <a class="link" href="deconnexion.php">Se déconnecter</a>
        <?php } ?>
    </nav>
</article>