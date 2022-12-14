<?php
    include '_db/connect.php';

    $currentDate = date('l d F Y', strtotime('last monday'));
    for ($x=0 ; $x<7 ; $x++) {
        echo '<th>' . $currentDate . '</th>' ;
        $currentDate = date("l d F Y", strtotime($currentDate . ' +1 day'));
    }    
    
    $currenthour = date('H:i', strtotime('8 hours 00 minutes'));
    for ($x=0 ; $x<9 ; $x++) {
        echo '<table><thead><tr><th>' . $currentHour . '</table></thead></tr></th>' ;
        $currentHour = date("H:i", strtotime($currentHour . ' +1 hours'));
    }
    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <?php   
                        $currentDate = date('l d F Y', strtotime('last monday'));
                        for ($x=0 ; $x<7 ; $x++) {
                            echo '<th>' . $currentDate . '</th>' ;
                            $currentDate = date("l d F Y", strtotime($currentDate . ' +1 day'));
                        }     ?>
            </tr>
        </thead>
    </table>
</body>
</html>