<?php

// Démarrage de la session + connextion à la base de données

session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Variables récupérées du formulaire du locataire
$numero_voiture = $_POST[numero_vehicule];
$date_entree = $_POST[date_entree];
$date_sortie = $_POST[date_sortie];
$aeroport_choisi = $_POST[aeroport_choisi];
$locataire = $_SESSION[pseudo];
$location = "oui";

// Mise à jour des informations de location de la voiture
// Attention, date de début de loc différent de date de rentrée dans le parking

// Locataire
$nb_modifs = $bdd->exec('UPDATE vehicule SET locataire = \''.$locataire.'\' WHERE id =\''. $numero_voiture.'\'');

// Location
$nb_modifs = $bdd->exec('UPDATE vehicule SET location = \''.$location.'\' WHERE id =\''. $numero_voiture.'\'');
// Date de début de location
$nb_modifs = $bdd->exec('UPDATE vehicule SET datedebut = \''.$date_entree.'\' WHERE id =\''. $numero_voiture.'\'');

// Date de fin de location
$nb_modifs = $bdd->exec('UPDATE vehicule SET datefin = \''.$date_sortie.'\' WHERE id =\''. $numero_voiture.'\'');

?>

<html>
    
    <head>
        
        <title>TravelCars - Accueil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
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
                <div class="col-sm-2"><center><a href="profil.php" >Mon compte</a></center></div>
                <div class="col-sm-1"><center><a href="index.php">Déconnexion</a></center></div>
            </div>
            
            <div id="message_finalisation">
                
            <h2>Merci d'avoir utilisé TravelCars <?php echo("$_SESSION[prenom] $_SESSION[nom_user]"); ?> !</h2>
            
            <p>Tu peux retrouver le récapitulatif de ta location dans la partie "Mon compte".</p>
            
            <p><a href='accueil.php'>Retourner à l'accueil</a> - <a href='profil.php'>Accéder à mon compte</a></p>
            
            </div>
            
            <div class="row" id="footer_connexion">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>