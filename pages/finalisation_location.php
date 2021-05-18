<?php

// Démarrage de la session + connextion à la base de données

session_start();
require_once('./api_call.php');

// Variables récupérées du formulaire du locataire
$voiture_id = $_POST['voiture_id'];
$locataire_id = $_POST['locataire_id'];
$parking_id = $_POST['parking_id'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$prix = $_POST['prix'];

$r = createReservation(array(
    'voiture_id' => $voiture_id,
    'locataire_id' => $locataire_id,
    'parking_id' => $parking_id,
    'date_debut' => $date_debut,
    'date_fin' => $date_fin,
    'prix' => $prix
));


?>

<html>

<head>

    <title>TravelCars - Accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">

</head>

<body>

<div class="container" id="body_finalisation2">

    <?php

    // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

    if (!isset($_SESSION[pseudo])) {
        echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
    }

    ?>

    <div class="row" id="menu">
        <div class="col-sm-2"><strong><a href=accueil.php>TravelCars</a></strong></div>
        <div class="col-sm-7"></div>
        <div class="col-sm-2">
            <center><a href="profil.php">Mon compte</a></center>
        </div>
        <div class="col-sm-1">
            <center><a href="index.php">Déconnexion</a></center>
        </div>
    </div>
    <?php
    if ($r) {
        ?>

    <div id="message_finalisation">

        <h2>Merci d'avoir utilisé TravelCars <?php echo("$_SESSION[prenom] $_SESSION[nom_user]"); ?> !</h2>

        <p>Tu peux retrouver le récapitulatif de ta location dans la partie "Mon compte".</p>

        <p><a href='accueil.php'>Retourner à l'accueil</a> - <a href='profil.php'>Accéder à mon compte</a></p>

    </div>
    <?php } else { ?>
        <div id="message_finalisation">

            <p>Un problème est survenu lors de l'ajout</p>

        </div>
    <?php }?>

    <div class="row" id="footer_connexion">
        <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
    </div>

</div>

</body>

</html>