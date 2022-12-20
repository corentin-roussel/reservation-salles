<?php
    include '_db/connect.php';

    $id = $_GET['id'];
    if($_SESSION != NULL) {
    if(isset($_GET['id'])) {
        $req = "SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = '$id' ";
        $req = mysqli_query($mysqli, $req);
        $req = mysqli_fetch_all($req);
    }

    $hDebut = date("l d F Y H:i", strtotime($req[0][6]));
    $hFin = date("l d F Y H:i", strtotime($req[0][7]));

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include '_include/head.php'; ?>
    <title>Réservations</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'; ?>
    </header>
    <main>
        <h2 class="space">Fait par <?php echo $req[0][1] ?>.</h2>
        <p class="space">Titre de la réservations <?php echo $req[0][4] ?>.</p>
        <p class="space">Description: <?php echo $req[0][5] ?>.</p>
        <p class="space">Début de l'activité : <?php echo $hDebut ?></p>
        <p class="space">Fin de l'activité : <?php echo $hFin ?></p>
    </main>
    <footer>
        <?php include '_include/footer.php'; ?>
    </footer>
</body>
</html>
<?php
    }else {
        header("location: connexion.php");
    }
?>