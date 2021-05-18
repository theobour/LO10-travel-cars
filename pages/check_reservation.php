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
            
            <h3>Enregistrer un nouveau véhicule :</h3>
            
            <!-- Si pas de véhicule enregistré ou un nouveau, il le crée ici -->
            
            <div id="new_vehicule">
                
            <form action="finalisation_reservation.php" method="post">
                
            <fieldset>

                        <div class='form-group'>

                            <label for="type_voiture">Type de voiture :</label>

                            <select name="type_voiture" required class='form-control'>
                                <option value="Berline">Berline / Coupé</option>
                                <option value="Familiale">Familiale / Monospace</option>
                                <option value="Pickup">Pickup</option>
                                <option value="Crossover">Crossover</option>
                                <option value="SUV">SUV</option>
                                <option value="Citadine">Citadines & mini-citadines</option>
                                <option value="Autre">Autre</option>
                            </select>

                        </div>

                        <div class='form-group'>

                            <label for="couleur">Couleur de la voiture :</label>
                            <input list="couleurs" name="couleur" required class='form-control'>
                            <datalist id="couleurs">
                                <option value="Argentée">Argentée</option>
                                <option value="Autre">Autre</option>
                                <option value="Beige">Beige</option>
                                <option value="Blanche">Blanche</option>
                                <option value="Bleue">Bleue</option>
                                <option value="Dorée">Dorée</option>
                                <option value="Grise">Grise</option>
                                <option value="Jaune">Jaune</option>
                                <option value="Marron">Marron</option>
                                <option value="Noire">Noire</option>
                                <option value="Orange">Orange</option>
                                <option value="Rose">Rose</option>
                                <option value="Rouge">Rouge</option>
                                <option value="Turquoise">Turquoise</option>
                                <option value="Verte">Verte</option>
                                <option value="Violette">Violette</option>   
                            </datalist>

                        </div>

                        <div class='form-group'> 

                            <label for="marque_voiture">Marque de la voiture :</label>
                            <input list="marques" name="marque" required class='form-control'>
                            <datalist id="marques">
                                <option value="Audi">Audi</option>
                                <option value="BMW">BMW</option>
                                <option value="Citroen">Citroën</option>
                                <option value="Dacia">Dacia</option>
                                <option value="Fiat">Fiat</option>
                                <option value="Ford">Ford</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Kia">Kia</option>
                                <option value="Mercedes">Mercedes</option>
                                <option value="Mini">Mini</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Opel">Opel</option>
                                <option value="Peugeot">Peugeot</option>
                                <option value="Renault">Renault</option>
                                <option value="Skoda">Skoda</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Volkswagen">Volkswagen</option>
                                <option value="Volvo">Volvo</option>
                                <option value="Autre">Autre</option>
                            </datalist>

                        </div>
                
                        <div class='form-group'>

                        <label for="nb_places">Nombre de places dans la voiture :</label>

                        <select multiple class='form-control' name='nb_places' size='5' required>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6 et plus'>6 et plus</option>
                        </select>

                        </div>

                        <div class='form-group'>

                            <label for="etat_voiture">Etat de la voiture :</label>

                            <select name="etat_voiture" required class='form-control'>
                                <option value="Neuve">Neuve</option>
                                <option value="Très Bon">Très bon état</option>
                                <option value="Bon">Bon état</option>
                                <option value="Correct">Etat correct</option>
                                <option value="Passable">Etat passable</option>
                            </select>

                        </div>
                        
                    </fieldset>
                
                <div>

                    <p>En confirmant ta réservation, tu acceptes les conditions générales de TravelCars.</p>

                </div>
                
                <!-- Champs cachés pour le formulaire -->
                
                <input type="hidden" value="<?php echo($lieu_choisi); ?>" name="lieu_choisi">
                <input type="hidden" value="<?php echo($date_entree); ?>" name="date_entree">
                <input type="hidden" value="<?php echo($date_sortie); ?>" name="date_sortie">
                <input type="hidden" value="<?php echo($aeroport_choisi); ?>" name="aeroport_choisi">
                <input type="hidden" value="<?php echo($_SESSION[pseudo]);?>" name="proprietaire">
                <input type="hidden" value="non" name="copie">
                
                <button type="submit" >Réservez le parking</button>
                
            </form>
                
            </div>
            
            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
        
        </div>
        
    </body>
    
</html>

