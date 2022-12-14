<?php
    include '_db/connect.php';
 

    $req = ("SELECT * FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id");
    $req = mysqli_query($mysqli, $req);
    $req = mysqli_fetch_all($req);
    
    var_dump($req);


    foreach($req as $key => $values) {
        $hDebut = date("l d F Y H:i", strtotime($values[3]));
        $hFin = date("l d F Y H:i", strtotime($values['4']));
        var_dump($hDebut);
        var_dump($hFin);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <td>Réservations</td>
                <?php   
                    $currentDate = date('l d F Y', strtotime('last monday'));
                    for ($x=1 ; $x < 8 ; $x++) {
                        echo '<th>' . $currentDate . '</th>' ;
                        $currentDate = date("l d F Y", strtotime($currentDate . ' +1 day'));
                    }?>
            </tr>
        </thead>
        <tbody>
            <?php
                $currentHour = date('H:i', strtotime('8 am'));
                for($j = 1; $j < 13; $j++) { 
                    echo "<tr>";
                    for($x = 1 ; $x < 8 ; $x++) {
                        if($x == 1) { 
                            echo '<td>' . $currentHour . '</td>' ;
                            $currentHour = date("H:i", strtotime($currentHour . ' +1 hours'));
                        }
                        if($j == $x) {
                            echo "<td>";
                        }
                        else {
                            echo "<td>";
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }



            ?>
        </tbody>
    </table>
</body>
</html>