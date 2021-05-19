<?php

// Démarrage session + connexion base de données

session_start();
require_once('./api_call.php');
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'root');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Variables du formulaire de réservation

$aeroport_id = $_POST["aeroport_id"];
$aeroport_nom = $_POST["aeroport_nom"];
$parking_id = $_POST["parking_id"];
$lieu = $_POST["lieu"];
$adresse = $_POST["adresse"];
$date_entree = $_POST["date_entree"];
$date_sortie = $_POST["date_sortie"];

// Calcul du prix total (pas journalier)
$date_entree_modif = strtotime($date_entree);
$date_sortie_modif = strtotime($date_sortie);
$nbjours_resa_stamp = $date_sortie_modif - $date_entree_modif;
$nbjours_resa = $nbjours_resa_stamp/86400;

$prix_resa = $_POST["prix_choisi"]*($nbjours_resa+1);

?>

<html>
    
    <head>
        
        <meta charset="UTF-8">
        <title>TravelCars - Réservation</title>
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

            if (!isset($_SESSION["pseudo"])) {
                echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
            }

            ?>
            
            <?php 

            // On teste si des infos sont rentrées pour le formulaire.

            if (!isset($_POST["lieu_choisi"])) {
                echo("<style>form button{display:none;}</style>");
            }

            ?>
            
            <h2 id="titre_accueil">Terminer la réservation... </h2>
            
            <p>Vérifiez si les informations suivantes sont correctes, et finalise la réservation de
                ta place de parking.</p>
            
            <p>Comme indiqué dans notre réglement, toute voiture garée sur nos places de parking est
                susceptible d'être louée. Si vous avez besoin de renseignements, n'hésitez pas à nous contacter.</p>
            
            <div id="infos_resa">
                
            <h3>Informations sur la place de parking choisie :</h3>
            
            <p><strong>Aéroport choisi :</strong> <?php echo ("$aeroport_nom");?></p>
            <p><strong>Parking choisi :</strong> <?php echo ("$lieu");?></p>
            <p><strong>Adresse :</strong> <?php echo ("$adresse");?> </p>
            <p><strong>Date d'arrivée :</strong> <?php echo ("$date_entree");?></p>
            <p><strong>Date de sortie :</strong> <?php echo ("$date_sortie");?></p>
            <p><strong>Tarif :</strong> <?php echo ("$prix_resa");?> euros</p>
                
            </div>
            
            <p>Nos parkings sont accessibles 7j/7, 24h/24. Une fois arrivé(e), présentez-vous à l'accueil pour
            une inspection du véhicule et la signature du contrat de réservation / location. Les places ne sont
            pas nominatives.</p>
            
            <!-- L'utilisateur rentre son nouveau véhicule ou choisi l'ancien dans la liste -->
            
            <h3>Informations sur ton véhicule :</h3>
            
            <?php 
            
                // Choix d'un véhicule déjà enregistré
            
                $voitures = getVoitureFromUtilisateur($_SESSION['id']);
                $nbr_vehicule = 0;
                foreach ($voitures as $voiture)
                {
                    // Formulaire pour envoyer toutes les infos sur le véhicule + la résa à la page de finalisation
                        echo("<div id=infos_vehicule>");
                        echo ("<p><strong>Type :</strong> $voiture->type</p>");
                        echo ("<p><strong>Couleur :</strong> $voiture->couleur</p>");
                        echo ("<p><strong>Marque :</strong> $voiture->marque</p>");
                        echo ("<p><strong>Nombre de places :</strong> $voiture->nb_places</p>");
                        echo ("<p><strong>Etat :</strong> $voiture->etat</p>");
                        
                        // Valeurs cachées du formulaire
                        echo("<form action=finalisation_reservation.php method=post>");
                        echo ("<input type=\"hidden\" value=\"$parking_id\" name=\"parking_id\"> ");
                        echo ("<input type=\"hidden\" value=$date_entree name=\"debut_disponibilite\"> ");
                        echo ("<input type=\"hidden\" value=$date_sortie name=\"fin_disponibilite\"> ");
                        echo ("<input type=\"hidden\" value=$prix_resa name=\"prix\"> ");
                        echo ("<input type=\"hidden\" value=\"oui\" name=\"copie\"> ");

                    echo ("<input type=\"hidden\" value=$voiture->id name=\"voiture_id\"> ");
                        
                        echo("<button type=\"submit\" class=\"btn btn-primary\">Réservez le parking avec ce véhicule</button>");
                        echo("</form>");
                        echo("</div>");
                        $nbr_vehicule++;
                              
                }

                if ($nbr_vehicule == 0) {echo("<p>Aucun véhicule enregistré</p>");}
                
               ?>
                
            </div>
            
            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
        
        </div>
        
    </body>
    
</html>

