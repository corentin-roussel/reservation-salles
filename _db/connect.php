<?php
session_start();

// Déclaration des variables pour pouvoir remplacer les champs si besoins 

$host = 'localhost';
$name = 'reservationsalles';
$user = 'root';
$password = '';

//Connexion a la base de données 

$mysqli = new mysqli("$host", "$user", "$password", "$name"); // Connexion a la base de données en localhost


//$mysqli = new mysqli("localhost, corentin, Mldsr.0202, corentin-roussel_moduleconenxion"); // Connexion a la base de données pour plesk


//test de connexion pour afficher un message d'erreur
if($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL " . $mysqli -> connect_error;
    exit();
} // if connection error echo une phrase et exit


?>