<?php

// Démarrage session + connection base de données

session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Variables du formulaire de réservation

$type_voiture = $_POST[type_voiture];
$couleur = ucfirst(strtolower($_POST[couleur]));
$marque = ucfirst(strtolower($_POST[marque]));
$nb_places = $_POST[nb_places];
$etat_voiture = $_POST[etat_voiture];
$lieu_choisi = $_POST[lieu_choisi];
$date_entree = $_POST[date_entree];
$date_sortie = $_POST[date_sortie];
$aeroport_choisi = $_POST[aeroport_choisi];
$proprietaire = $_POST[proprietaire];
$location = "non";
$copie= $_POST[copie];

// Mise à jour de nombre de places de parking (on en enlève 1)

$reponse = $bdd->query('SELECT nb_places FROM site WHERE lieu =\''. $lieu_choisi.'\'');

while ($donnees = $reponse->fetch())
          {
                   $nb_places_maj = $donnees[nb_places] - 1;
                   
                  }

// Insertion du véhicule dans le parking choisi

$req = $bdd->prepare('INSERT INTO vehicule(type, couleur, marque, car_places, car_etat, date_entree, date_sortie, location, aeroport, proprietaire, copie, locataire, lieu, datedebut, datefin) VALUES(:type, :couleur, :marque, :car_places, :car_etat, :date_entree, :date_sortie, :location, :aeroport, :proprietaire, :copie, :locataire, :lieu, :datedebut, :datefin)');

        $req->execute(array(

        'type' => $type_voiture,
        'couleur' => $couleur,
        'marque' => $marque,
        'car_places' => $nb_places,
        'car_etat' => $etat_voiture,
        'date_entree' => $date_entree,
        'date_sortie' => $date_sortie,
        'location' => $location,
        'aeroport' => $aeroport_choisi,
        'proprietaire' => $proprietaire,
        'copie' => $copie,
        'locataire' => "administrateur",
        'lieu' => $lieu_choisi,
        'datedebut' => $date_entree,
        'datefin' => $date_sortie

        ));

// Mise à jour du nombre de places dans le parking + message de confirmation
        
$nb_modifs = $bdd->exec('UPDATE site SET nb_places = \''.$nb_places_maj.'\' WHERE lieu =\''. $lieu_choisi.'\'');

?>

<html>
    
    <head>
        
        <title>TravelCars - Réservation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">
        
    </head>
    
    <body>
        
        <div class="container" id="body_finalisation">
            
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
            
            <p>Ta réservation a été prise en compte. Tu peux la vérifier, et accéder à tes autres réservations
            en allant sur ton profil.</p>
            
            <p><a href='accueil.php'>Retourner à l'accueil</a> - <a href='profil.php'>Accéder à mon compte</a></p>
            
            </div>
            
            <div class="row" id="footer_connexion">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>
