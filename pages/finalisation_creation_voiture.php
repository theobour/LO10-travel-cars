<?php
require_once('./api_call.php');
$url_to_redirect = "http://localhost:8890/project/LO10-travel-cars/pages";
if (!isset($_SESSION['auth'])) {
    header('Location: ' . $url_to_redirect . '/index.php');
}
$creation = createVoiture(array(
    "type"=>$_POST['type'],
    "couleur"=>$_POST['couleur'],
    "marque"=>$_POST['marque'],
    "nb_place"=>$_POST['nb_place'],
    "etat"=>$_POST['etat'],
    "proprietaire_id"=>$_POST['proprietaire_id']
));
?>

<html>

<head>

    <title>TravelCars - Création voiture</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">

</head>

<body>

<div class="container" id="body_finalisation">

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


    <div id="message_finalisation">
        <?php if ($creation) { ?>

            <h2>Merci d'avoir utilisé TravelCars <?php echo("$_SESSION[prenom] $_SESSION[nom_user]"); ?> !</h2>

            <p>La voiture a bien été crée.</p>

            <p><a href='accueil.php'>Retourner à l'accueil</a> - <a href='profil.php'>Accéder à mon compte</a></p>
        <?php } else { ?>
            <p>Un problème est survenu.</p>
        <?php } ?>
    </div>

    <div class="row" id="footer_connexion">
        <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
    </div>

</div>

</body>

</html>

