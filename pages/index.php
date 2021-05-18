<?php

// Connexion à la base de données
require_once('./api_call.php');
$r = getVehicule();
// En cas de déconnexion, on détruit les variables de session : utilisateur n'est plus identifié.
?>

<html>

<head>

    <meta charset="UTF-8">
    <title>TravelCars</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style_perso.css"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">

</head>

<body>

<div class="container" id="body_index">

    <div class="row" id="menu">
        <div class="col-sm-2"><strong><a href=index.php>TravelCars</a></strong></div>
        <div class="col-sm-7"></div>
        <div class="col-sm-2">
            <center><a href="connection.php">Se connecter</a></center>
        </div>
        <div class="col-sm-1">
            <center><a href="inscription.php">S'inscrire</a></center>
        </div>
    </div>

    <div id='partie_info'>
        <h2>TravelCars, louez votre voiture pendant votre voyage</h2>

        <p>TravelCars est une compagnie qui permet de louer votre voiture pendant que vous êtes
            en déplacement. Laissez-la à l'aéroport, sur un parking proche réservé spécialement pour vous,
            et gagnez de l'argent en louant votre voiture à un autre voyageur.<br/>
            Ne dépensez plus tout votre argent dans le parking !</p>

    </div>

    <div id="partie_connexion">

        <h2>Se connecter</h2>

        <p>Déjà membre de la communauté TravelCars ? Connecte-toi pour
            suivre tes réservations, vérifier tes locations et accéder aux autres fonctionnalités proposées.<br/>
            C'est gratuit, sans engagement, et tu as accès à tous les services proposés par TravelCars : location de
            véhicules,
            parkings à prix réduits...<br/>
            Profite de tous les services qui te sont mis à disposition !</p>

        <center><a href="connection.php" class="btn btn-secondary btn-lg active" role="button">Je me connecte</a>
        </center>

    </div>

    <div id="partie_inscription">

        <h2>S'inscrire</h2>

        <p>Pas encore inscrit ? Rejoins la communautéde TravelCars : accède à des places de parking à des tarifs
            compétitifs, et loue ta voiture quand tu n'es pas là !<br/>
            Rejoindre la communauté TravelCars, c'est profiter de tous les services associés. Un partenariat avec plus
            d'une
            dizaine d'aéroports te permettra de choisir la meilleure solution de location ou de réservation !</p>

        <center><a href="inscription.php" class="btn btn-secondary btn-lg active" role="button">Je m'inscris</a>
        </center>

    </div>

    <div class="row" id="footer_index">
        <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
    </div>

</div>

</body>

</html>
