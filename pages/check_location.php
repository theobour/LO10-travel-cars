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

// Variables récupérées du formulaire de location

$numero_vehicule = $_POST[numero_vehicule];
$aeroport_choisi = $_POST[aeroport_choisi];
$date_entree = $_POST[date_entree];
$date_sortie = $_POST[date_sortie];
$prix_loc = $_POST[prix_loc];

?>

<html>
    
    <head>
        
        <meta charset="UTF-8">
        <title>TravelCars - Location</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">
        
    </head>
    
    <body>
        
        <div class="container">
            
            <div class="row" id="menu">
                <div class="col-sm-2"><strong><a href=accueil.php>TravelCars</a></strong></div>
                <div class="col-sm-7"></div>
                <div class="col-sm-2"><center><a href="profil.php" >Mon compte</a></center></div>
                <div class="col-sm-1"><center><a href="index.php">Déconnexion</a></center></div>
            </div>
            
            <?php 

            // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

            if (!isset($_SESSION[pseudo])) {
                echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
            }

            ?>
            
            <?php 

            // On teste si des infos sont rentrées pour le formulaire.

            if (!isset($_POST[numero_vehicule])) {
                echo("<style>form button{display:none;}</style>");
            }

            ?>
            
            <h2 id="titre_accueil">Terminer la location du véhicule...</h2>
            
            <div id="infos_loc">
                
            <p>Vérifie si les informations suivantes sont correctes, et finalise la location du véhicule choisi
                pour la durée de ton séjour. Pense à bien re-vérifier tes dates !</p>
            
            <p>Comme indiqué dans notre réglement, le locataire est reponsable des dommages qui pourraient
                subvenir lors de la location de la voiture. En précaution, une caution ainsi qu'une assurance sont
                prises lors de la remise des clés. Leurs tarifs sont compris dans le prix affiché (TTC).</p>
            
            <p>Nos parkings sont accessibles 7j/7, 24h/24. Une fois arrivé(e), présentez-vous à l'accueil pour
            une inspection du véhicule et la signature du contrat de réservation / location. Les places ne sont
            pas nominatives.</p>
            
            <p><img src="../images/img5.jpg" alt="photo aéroport" />
            
            </div>
            
            <!-- Présentation du véhicule choisi -->
            
            <div id="infos_resa">
            
            <h3>Informations sur le véhicule choisi :</h3>
            
            <?php $reponse = $bdd->query('SELECT type, couleur, marque, car_places, car_etat, lieu FROM vehicule WHERE id =\''. $numero_vehicule.'\'');

                                        // On récupère les informations des véhicules disponibles.
                                        while ($donnees = $reponse->fetch())
                                        {
                                                echo ("<p><strong>Véhicule choisi :</strong> $donnees[type]</p>");
                                                echo ("<p><strong>Couleur :</strong> $donnees[couleur]</p>");
                                                echo ("<p><strong>Marque :</strong> $donnees[marque]</p>");
                                                echo ("<p><strong>Nombre de places :</strong> $donnees[car_places]</p>");
                                                echo ("<p><strong>Etat :</strong> $donnees[car_etat]</p>");
                                                echo ("<p><strong>Lieu de stationnement :</strong> $donnees[lieu]</p>");
                                                echo("<br/>");
                                                echo ("<p><strong>Date de début de location :</strong> $date_entree</p>");
                                                echo ("<p><strong>Date de fin de location :</strong> $date_sortie</p>");
                                                echo("<p><strong>Tarif :</strong> $prix_loc €</p>");
                                        }

                                        $reponse->closeCursor();

            ?>
            
            </div>
            
            <form action="finalisation_location.php" method="post" id="form_loc" >
             
                <p>En confirmant la location du véhicule, tu acceptes les conditions générales de TravelCars.</p>

                <!-- Champs cachés -->
                
                <input type="hidden" value="<?php echo($numero_vehicule); ?>" name="numero_vehicule">
                <input type="hidden" value="<?php echo($date_entree); ?>" name="date_entree">
                <input type="hidden" value="<?php echo($date_sortie); ?>" name="date_sortie">
                <input type="hidden" value="<?php echo($aeroport_choisi); ?>" name="aeroport_choisi">
                <input type="hidden" value="<?php echo($_SESSION[pseudo]);?>" name="locataire">
                
                <button type="submit" >Louer le véhicule</button>
                
            </form>
            
            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>