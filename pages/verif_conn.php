<?php

// Démarrage session + connexion BDD
require_once('./api_call.php');
$url_to_redirect = "http://localhost:8888/project/LO10-travel-cars/pages";
unset ($_SESSION['pseudo']);


// Création des variables de session
$_SESSION['prenom'] = "Théo";
$_SESSION['nom_user'] = "Bour";
$_SESSION['pseudo'] = "bourtheo";
$_SESSION['id'] = 5;
$_SESSION['auth'] = base64_encode("test:test");
$_SESSION['connection'] = "non";
unset($_SESSION['connection']);
header('Location: ' . $url_to_redirect . '/accueil.php');
exit();


?>