<?php

// Démarrage session + connexion BDD
require_once('./api_call.php');
$url_to_redirect = "http://localhost:8890/project/LO10-travel-cars/pages";
session_start();
unset ($_SESSION['pseudo']);

// Récupération du pseudo de l'utilisateur
if (isset($_POST['id_user']) && isset($_POST['mdp'])) {
    $r = login($_POST['id_user'], $_POST['mdp']);
    if ($r != false) {
        // Création des variables de session
        $_SESSION['prenom'] = $r->prenom;
        $_SESSION['nom_user'] = $r->nom;
        $_SESSION['pseudo'] = $r->pseudo;
        $_SESSION['id'] = $r->id;
        $_SESSION['auth'] = base64_encode($r->pseudo . ':' . $_POST['mdp']);
        $_SESSION['connection'] = "non";
        unset($_SESSION['connection']);
        header('Location: ' . $url_to_redirect . '/accueil.php');
        exit();
    } else {
        $_SESSION['connection'] = "non";
        header('Location: ' . $url_to_redirect . '/connection.php');
        exit();
    }
} else {
    header('Location: ' . $url_to_redirect . '/connection.php');
}


        ?>