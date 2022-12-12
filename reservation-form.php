<?php 
    include '_db/connect.php';

    $valid = TRUE;

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['reserver'])) {
            $title = htmlspecialchars(trim($title));
            $start = htmlspecialchars(trim($start));
            $end = htmlspecialchars(trim($end));
            $date = htmlspecialchars(trim($date));
            $description = htmlspecialchars(trim($description));
            $sessionId = $_SESSION['id'];
            $startDate = $date . ' ' . $start;
            $endDate = $date . ' ' . $end ;

            if(empty($title)){
                $valid = FALSE;
                $err_title = "Ce champ ne peut pas être vide";
            }

            if(empty($start)) {
                $valid = FALSE;
                $err_start = "Ce champ ne peut pas être vide";
            }
            else if(strtotime($start) > strtotime('18:00:00')) {
                $valid = FALSE;
                $err_start = "Désolé nous ne sommes pas ouverts aprés 19h00";
            }
            else if(strtotime($start) < strtotime('08:00:00')) {
                $valid = FALSE;
                $err_start = "Désolé nous ne sommes pas ouvert avant 8h00;";
            }
            else if($start > $end) {
                $valid = FALSE;
                $err_start = "Veuillez choisir une horaire valide";
            }

            if(empty($end)) {
                $valid = FALSE;
                $err_end = "Ce champ ne peut pas être vide";
            }
            else if(strtotime($end) > strtotime('19:00:00')) {
                $valid = FALSE;
                $err_end = "Désolé nous ne sommes pas ouverts aprés 19h00";
            }
            else if(strtotime($end) < strtotime('09:00:00')) {
                $valid = FALSE;
                $err_end = "Désolé nous ne sommes pas ouvert avant 8h00;";
            }

            if(empty($date)) {
                $valid = FALSE;
                $err_date = "Ce champ ne peut pas être vide";
            }
            else if (date("Y-m-d") > $date) {
                $valid = FALSE;
                $err_date = "La date que vous avez choisis n'est pas valide";
            }

            if(empty($description)) {
                $valid = FALSE;
                $err_description = "Ce champ ne peut pas être vide";
            }

            if($valid) {
                $req = ("INSERT INTO reservations (`titre`, `debut`, `fin`, `description`, `id_utilisateur`) VALUES ('$title', '$startDate', '$endDate', '$description', '$sessionId')");
                $reservation = mysqli_query($mysqli, $req);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include '_include/head.php'
    ?>
    <title>Formulaire de réservation</title>
</head>
<body class="bg-img">
    <header>
        <?php
            include '_include/header.php'
        ?>
    </header>
    <main>
        <form class="form-flex" method="POST">
            <label for="name"><?php echo $_SESSION['login']?></label>

            <?php if(isset($err_title)) echo($err_title);?>
            <label for="title">Titre :</label>
            <input type="text" name="title" placeholder="Veuillez renseigner un titre ...">
            
            <?php if(isset($err_start)) echo($err_start);?>
            <label for="start">Heure de début :</label>
            <input type="time" name="start" min="" max="" step="3600" >
            
            <?php if(isset($err_end)) echo($err_end);?>
            <label for="end">Heure de fin :</label>
            <input type="time" name="end" min="" max="" step="3600">
            <small>Les horaires de réservations sont de 08H00 a 19H00.</small>

            <?php if(isset($err_date)) echo($err_date);?>
            <label for="date">Date :</label>
            <input type="date" value="" name="date" min="<?php echo date("Y-d-m"); ?>" max="2024-12-31">
            
            <?php if(isset($err_description)) echo($err_description);?>
            <label for="description">Descritpion de l'activité :</label>
            <textarea name="description" cols="30" rows="10"></textarea>

            <input type="submit" name="reserver" value="Réserver">
        </form>
    </main>
    <footer>
        <?php
            include '_include/footer.php'
        ?>
    </footer>
</body>
</html>