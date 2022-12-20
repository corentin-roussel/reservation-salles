<?php
    include '_db/connect.php';
 

    $req = ("SELECT * FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id");
    $req = mysqli_query($mysqli, $req);
    $req = mysqli_fetch_all($req);



    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
    <title>Planning</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'; ?>
    </header>
    <main>
        <h1 class="title space">Planning</h1>
        <table class="table">
            <thead class="table">
                <tr class="table">
                    <td>Réservations</td>
                    <?php
                    $currentDate = date('l d F Y', strtotime('this week monday'));
                    for ($x=0 ; $x<7 ; $x++) {
                        echo '<th class="link-plan reservation days">' . $currentDate . '</th>' ;
                        $currentDate = date("l d F Y", strtotime($currentDate . ' +1 day'));
                        $weekDay = date('w', strtotime($currentDate));
                    }?>
                </tr>
            </thead>
            <tbody class="table">
                <?php
                    for($j = 8; $j < 20; $j++) { 
                        echo "<tr class='table'>";
                        for($x = 1 ; $x < 9 ; $x++) {
                            if($x == 1) { 
                                echo '<td class="reservation  hour">' . $j. ":00" . '</td>' ;
                            }
                            else {
                                
                                $dateCompare = date("l-d-Y H:i", strtotime('this week monday ' . $x-2 . ' days ' . $j .' hours'));
                                foreach($req as $key => $values) {
                                    $hDebut = date("l-d-Y H:i", strtotime($values[3]));
                                    $hFin = date("l-d-Y H:i", strtotime($values[4]));
                                    
                                    $valid = FALSE;

                                    if($hDebut <= $dateCompare && $hFin > $dateCompare) {
                                        $valid = TRUE;
                                        break;
                                    }                
                                }

                                if($valid) {
                                    echo "<td class='reservation plan-reserved'><a href='reservation.php?id=". $values[0] ."' >Fait par $values[7],</br> pour $values[1] .</br> Desc : $values[2]</a></td>";
                                }else if($x > 6) {
                                    echo "<td class='reservation plan-weekend'>Nous sommes fermés</td>";
                                }else {
                                    echo "<td class='reservation plan'><a class='link-plan' href='reservation-form.php'>Vous pouvez réserver</a></td>";
                                }

                            }
                        }
                        echo "</tr>";
                    }   
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <?php include '_include/footer.php'; ?>
    </footer>
</body>
</html>