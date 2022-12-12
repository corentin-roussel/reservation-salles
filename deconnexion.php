<?php 
    session_start(); //initialisation de la sessionen cours

    session_destroy(); //destruction de la session

    header("Location: index.php"); // redirection vers index.php
    exit;
?>