<?php
    include '_db/connect.php';
 

    $req = ("SELECT * FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id");
    $req = mysqli_query($mysqli, $req);
    $req = mysqli_fetch_all($req);
    
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
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week monday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week tuesday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week wednesday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week thursday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week friday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week saturday")); ?></th>
                <th><?php echo $currentDate = date("l d F Y", strtotime("this week sunday")); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($j = 8; $j < 20; $j++) { 
                    echo "<tr>";
                    for($x = 1 ; $x < 9 ; $x++) {
                        if($x == 1) { 
                            echo '<td>' . $j. ":00" . '</td>' ;
                        }
                        else {
                            echo "<td>";
                            $dateCompare = date("l-d-Y H:i", strtotime('this week monday ' . $x-2 . ' days ' . $j .' hours'));
                             foreach($req as $key => $values) {
                                $hDebut = date("l-d-Y H:i", strtotime($values[3]));
                                $hFin = date("l-d-Y H:i", strtotime($values[4]));


                                $valid = FALSE;

                                if($hDebut == $dateCompare) {
                                    $valid = TRUE;
                                    break;
                                }                
                                else if($hFin == $dateCompare) {
                                    $valid= TRUE;
                                    break;
                                }
                            }

                            if($valid) {
                                echo "Fait par $values[7],</br> pour $values[1] .</br> Desc : $values[2]";
                            }else {
                                echo "<a href='reservation-form.php'>Vous pouvez réserver</a>";
                            }

                            
                                
                            echo "</td>";
                        }
                    }
                    echo "</tr>";
                }   
            ?>
        </tbody>
    </table>
</body>
</html>