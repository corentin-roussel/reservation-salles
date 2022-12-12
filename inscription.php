<?php
    include('_db/connect.php');


    if(isset($_SESSION['id'])) { //si on a quelquechose dans $_SESSION['id']
        header("Location: index.php");// redirige vers index.php
        exit;
    }

    $valid = (boolean) TRUE; //initialisation d'un booleen

    $regex = "^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^"; //intialisation de la regex

    if(!empty($_POST)) { // si il ya quelquechose dans post
        extract($_POST); //extract superglobale post

        if(isset($_POST['inscription'])) { //si il y a quelquchose des que l'on appui sur l'input avec le name inscription
            $login = htmlspecialchars(trim($login)); //on récupere la variable récuperer par extract $login et on lui réassigne le même nom, 
            $password = htmlspecialchars(trim($password)); //on utilise la fonction trim pour supprimer les espaces de part et d'autres et on utilise la
            $confpassword = htmlspecialchars(trim($confpassword)); // fonction html special chars qui permet de  convertir les carctéres spéciaux en entités html

            if(empty($login)) { //si le login est vide   
                $valid = FALSE; //on initialise le booléen a false
                $err_login = "Ce champ ne peut pas être vide"; //et on affiche un message d'erreur
            }
            
            else if(grapheme_strlen($login) < 5) { // sinon si on utilise la fonction grapheme_strlen pour verifier que le login a bien plus de 5 carcatéres
                $valid = FALSE; // si ce n'est pas le cas on initialise le booléen a false 
                $err_login = "Le login doit contenir au minimum 5 caractéres.";// et on affiche le message d'erreur 
            }
            
            else if(grapheme_strlen($login) > 25) { //sinon si on utilise la fonction grapheme_strlen pour verifier que le login a bien plus de 5 carcatéres
                $valid = FALSE; // si ce n'est pas le cas on initialise le booléen a false 
                $err_login = "Le login doit contenir maximum 25 caractéres."; // et on affiche le message d'erreur 
            }
            
            else { //sinon
                $user = ("SELECT login FROM utilisateurs WHERE login = '$login'"); //on initialise notre requête sql pour plus tard
                $verif = mysqli_query($mysqli, $user); //

                
                if(mysqli_num_rows($verif) > 0) { //si dans les colomnnes de la requête verif on trouve un login déja présent on passe a 1 et si c'est plus grand que 0 
                    $valid = FALSE; //on réinitialise le booleen a false
                    $err_login = "Ce login est déja pris"; // et on affiche le message d'erreur
                }
            }
    
            if(empty($password)) { //si le champ password est vide
                $valid = FALSE; // false
                $err_password = "Ce champ ne peut pas être vide"; // affichage message d'erreur 
            }
            else if($password != $confpassword) { // sinon si le password ne correspond pas a la confirmation du password
                $valid = FALSE; //false
                $err_password = "Le mot de passe est différent de la confirmation";// on affiche le message d'erreur
            }
            else if($password === $confpassword) { //sinon si le password correspond a la confirmation du password
                if(!preg_match($regex, $password)) { // si le password ne correspond pas a la regex 
                    $valid = FALSE; //false
                    $err_password = "Le mot de passe dont contenir au moins 5 carcatéres dont 1 majuscules, 1 minuscules, 1 chiffres et 1 caractére spéciale";//affichage message d'erreur
                }

            }
            else { //sinon si le password correspond a la conf du password
                $user = ("SELECT * FROM utilisateurs WHERE prenom = '$prenom'"); //on intialise la requête pour plus tard
                $verif = mysqli_query($mysqli, $user); //on l'utilise
            }    
            
            if($valid) { //si le booléen est true 
                $crypt_password = password_hash($password, PASSWORD_DEFAULT); // on crypt le password
                
                $req = $mysqli->prepare("INSERT INTO `utilisateurs`(`login`, `password`) VALUES (?, ?)"); //prepartion de la requéte
                $req->execute((array($login, $crypt_password))); // utilistion de la requête 

                header("Location: connexion.php"); //redirection vers la connection
                
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
    <title>Inscription</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <h1 class="title main-index">Inscrivez-vous</h1>
            <form class="form" action="" method="POST">
                    <?php if(isset($err_login)) {echo '<div>' . "$err_login" . '</div>' ;} //affichage du message d'erreur si il y'en a une?>
                    <label class="space" for="login">Login</label>
                    <input class="space input" type="text" name ="login" value="<?php if(isset($login)) {echo "$login";} // si on écrit quelquechose dans le champ et que l'on se trompe le login reste afficher ?>" placeholder="Entrez votre login" required>
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} //affichage du message d'erreur si il y'en a une?>
                    <label class="space" for="password">Mot de passe</label>
                    <input class="space input" type="password" name ="password" placeholder="Entrez votre mot de passe" required>

                    <label class="space" for="confpassword">Confirmation mot de passe</label>
                    <input class="space input" type="password" name ="confpassword"  value="" placeholder="Confirmez votre mot de passe" required>

                    <input class="button" type="submit" name="inscription"  value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php' ?>
    </footer>
</body>
</html>