<?php

// Démarrage de la session + connexion base de données

session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
        
}

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
            
            <div id="partie_description_resa">
            
            <?php

            // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

            if (!isset($_SESSION[pseudo])) {
                echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
            }

            // Variables récupérées du formulaire de choix d'aéroport pour la réservation

            $aeroport = $_POST[aeroport_loc];
            $date_entree_loc = $_POST[date_entree_loc];
            $date_sortie_loc = $_POST[date_sortie_loc];

            if ($date_entree_loc >= $date_sortie_loc) { 
                echo("<div id=message_erreur_dates>");
                echo("<h2>Tes dates ne sont pas correctes...</h2>"); 
                echo("<p><a href=accueil.php>Modifier les dates saisies</a></p>");
                echo("<style>#footer_connexion {
                                    width: 100%;
                                    position: fixed;
                                    bottom: 0px;
                                    padding: 10px;
                                    background-color: #2B0A40;
                                    color: white;
                                    margin: 0px;
                                    z-index: 1000;
                                    text-align: center;
                                    font-size: 12px;
                                }

                                #footer_connexion a{
                                    color: white;
                                }

                                #footer_connexion a:hover{
                                    color: white;
                                    font-weight: bold;
                                    text-decoration: none;
                                }
                                
                                #footer_index {display: none;}
                                
                                #resultat_reservation {display: none;}
                                
                                body {
                                  background-image: url(../images/img4.jpg);
                                  background-repeat: no-repeat;
                                  background-size: cover;
                                  background-attachment: fixed;
                                  background-position: center;
                                  height: 100%;
                                }
                                </style>");
                echo("</div>");
            }
            
            else {
                echo("<style>#footer_connexion {display: none;}</style>");
            }

            ?>
            
            <!-- Résultats de la recherche effectuée -->
            
            <div id="resultat_reservation"> 
            
            <h2>Résultats de ta recherche : <a href="accueil.php">(modifier ma recherche)</a></h2>
            
            <?php $reponse = $bdd->query('SELECT id, type, couleur, marque, car_places, car_etat, lieu FROM vehicule WHERE aeroport =\''. $aeroport.'\' AND date_entree <= \''.$date_entree_loc.'\' AND date_sortie >= \''.$date_sortie_loc.'\' AND location = \'non\' ');

                                        // Récupération des différents véhicules qui vérifient les conditions 
            
                                        $nombre_locations = 0;
                                        while ($donnees = $reponse->fetch())
                                        {
                                                echo("<div id=liste_reservation>");
                                                echo ("<strong>Véhicule disponible :</strong> $donnees[type] <br/>");
                                                echo ("<strong>Couleur :</strong> $donnees[couleur] <br/>");
                                                echo ("<strong>Marque :</strong> $donnees[marque] <br/>");
                                                echo ("<strong>Nombre de places :</strong> $donnees[car_places] <br/>");
                                                echo ("<strong>Etat :</strong> $donnees[car_etat] <br/>");
                                                echo ("<strong>Lieu de stationnement :</strong> $donnees[lieu] <br/>");
                                                
                                                $nombre_locations++;
                                                
                                        $reponse2 = $bdd->query('SELECT prix FROM site WHERE lieu =\''. $donnees[lieu].'\' ');

                                            while ($donnees2 = $reponse2->fetch())
                                            {
                                                    $date_entree = $date_entree_loc;
                                                    $date_sortie = $date_sortie_loc;

                                                    $date_entree_modif = strtotime($date_entree);
                                                    $date_sortie_modif = strtotime($date_sortie);
                                                    $nbjours_loc_stamp = $date_sortie_modif - $date_entree_modif;
                                                    $nbjours_loc = $nbjours_loc_stamp/86400;

                                                    $prix_loc = $donnees2[prix]*($nbjours_loc+1)*1.5;
                                                    
                                                    echo ("<strong>Prix de la location :</strong> $prix_loc €<br/>");

                                            }
                                            
                                                echo ("<form action=check_location.php method=post>
                                                          <input type=hidden name=numero_vehicule value=\"$donnees[id]\" >
                                                          <input type=hidden name=aeroport_choisi value=\"$aeroport\" >
                                                          <input type=hidden name=date_entree value=$date_entree_loc >
                                                          <input type=hidden name=date_sortie value=$date_sortie_loc >
                                                          <input type=hidden name=prix_loc value=$prix_loc >
                                                          <button type=submit >Choisir ce véhicule</button>
                                                       </form>"
                                                          
                                                        );
                                                echo("</div>");
                                        }

                                        $reponse->closeCursor(); 
                                        
                                        // Si aucun véhicule n'est disponible
                                        if ($nombre_locations == 0) {
                                            echo("<p>Aucun véhicule n'est disponible à l'aéroport $aeroport du $date_entree_loc au $date_sortie_loc.<br/>
                                                                            Modifie tes dates ou trouve un autre aéroport.</p>"); 
                                            
                                            echo("<p><strong><a href=accueil.php>Modifier les dates saisies</a></strong></p>");
                                            
                                            echo("<style>
                                                
                                                            #footer_connexion {display: block;}
                                                            #footer_connexion {
                                                                    width: 100%;
                                                                    position: fixed;
                                                                    bottom: 0px;
                                                                    padding: 10px;
                                                                    background-color: #2B0A40;
                                                                    color: white;
                                                                    margin: 0px;
                                                                    z-index: 1000;
                                                                    text-align: center;
                                                                    font-size: 12px;
                                                                }

                                                                #footer_connexion a{
                                                                    color: white;
                                                                }

                                                                #footer_connexion a:hover{
                                                                    color: white;
                                                                    font-weight: bold;
                                                                    text-decoration: none;
                                                                }

                                                                #footer_index {display: none;}

                                                                body {
                                                                  background-image: url(../images/img13.jpg);
                                                                  background-repeat: no-repeat;
                                                                  background-size: cover;
                                                                  background-attachment: fixed;
                                                                  background-position: center;
                                                                  height: 100%;
                                                                }
                                                                </style>");
                                        }
                                        ?>
            
            </div>
            
            </div>
            
            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
            <div class="row" id="footer_connexion">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>

