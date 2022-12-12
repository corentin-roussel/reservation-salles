<?php
    require_once('_db/connect.php');
    
    if(isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }

    

    if(!empty($_POST)) { //si le champ POST n'est pas vide
        extract($_POST); //extrait les valeurs  de POST

        $valid = (boolean) TRUE; //définition de la variable $valid a TRUE pour les conditions

        if(isset($_POST['connexion'])) { //si il y a quelquechose dans POST['connexion']
            $login = htmlspecialchars(trim($login)); //recupération de la variable créer par extract on la trim pour enlever les espaces si il y'en a et htmlspecialchars pour des raisons de sécurités
            $password = htmlspecialchars(trim($password)); // idem 

            if(empty($login)) { // si le login  est vide
                $valid = FALSE; // passer la variable definit plus tot a FALSE afin de définir une erreur
                $err_login = "Ce champ ne peut pas être vide"; //variable pour afficher l'erreur en question
            }

            if(empty($password)) { // si le password est vide 
                $valid = FALSE; // passer la variable a FALSE pour définir une erreur
                $err_password = "Ce champ ne peut pas être vide"; //variable pour afficher l'erreur en quest
            }

            if($valid) { // si c'est true 
                $user = ("SELECT password FROM utilisateurs WHERE login = '$login'"); //selectionne mot de passe de la table utilisateurs ou le login = a l'input post login
                $req_user = mysqli_query($mysqli, $user);
                $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC);
                

                if(isset($users['password'])) { //si il y a quelquechose dans la variable users a la valeur ['pasword']
                    if(!password_verify($password, $users['password'])) { // on a hasher le password donc il faut utiliser la fonction password_verify afin de pouvoir le comparer et vérifier qu'il soit bien identique 
                        $valid = FALSE; // boolean a false 
                        $err_login = "La combinaison du mot de passe et du login est incorrecte"; //affichage message d'erreur
                    }
                }
                else { //sinon si il y a rien 
                    $valid = FALSE; // boolean a false
                    $err_login = "La combinaison du mot de passe et du login est incorrecte"; //affichage m'essage d'erreur
                }
            }

            if($valid) { //si boolean true
                $user = ("SELECT * FROM utilisateurs WHERE login = '$login'"); //on selectionne tous les champs de la table utilisateurs ou login est égale a l'input $_POST['login']
                $users = mysqli_query($mysqli, $user);
                $session_users = mysqli_fetch_array($users, MYSQLI_ASSOC);// récuperation du tableau avec fetch_array et MYSQLI_ASSOC afin de récuperer uniquement les nom sde colonnes en valeur


                if(isset($session_users['id'])) {// si il y a quelquechose dans $session_users['id']
                    $_SESSION['id'] = $session_users['id']; // $session_users['id'] stocké dans la superglobales $_SESSION['id']
                    $_SESSION['login'] = $session_users['login']; // $session_users['login'] stocké dans la superglobales $_SESSION['login']
                    $_SESSION['password'] = $session_users['password']; // $session_users['password'] stocké dans la superglobales $_SESSION['password']

                    header("Location: index.php"); // redirection vers la page index.php
                }
                else{ //sinon boolean a false et affichage message d'erreur
                    $valid = FALSE;
                    echo "La combinaison du mot de passe et du login est incorrecte";
                }
            }

        }



    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
    <title>Connexion</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <h1 class="title main-index">Connectez vous</h1>
            <form class="form" action="" method="POST">
                <?php if(isset($err_login)) {echo $err_login;} ?>
                <label class="space" for="login">Login</label>
                <input class="space input" type="text" name ="login"  value="<?php if(isset($login)) {echo $login;} ?>" placeholder="Entrez votre login" >

                <?php if(isset($err_password)) {echo $err_password;} ?>
                <label class="space" for="password">Mot de passe</label>
                <input class="space input" type="password" name ="password"  placeholder="Entrez votre mot de passe" >


                <input class="button" type="submit"  name="connexion" value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'?>
    </footer>
</body>
</html>

