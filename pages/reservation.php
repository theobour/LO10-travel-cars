<?php

// Démarrage session + connexion BDD

session_start();
require_once('./api_call.php');
try {
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<html>

<head>

    <meta charset="UTF-8">
    <title>TravelCars - Réservation</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">

</head>

<body>

<div class="container">

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

    <div id="partie_description_resa">

        <?php

        // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

        if (!isset($_SESSION["pseudo"])) {
            echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>.");
        }

        // Variables récupérées du formualire pour le choix des date et de l'aéroport
        $aeroport_id = $_POST["aeroport_id"];
        $date_entree_res = $_POST["date_entree_res"];
        $date_sortie_res = $_POST["date_sortie_res"];

        if ($date_entree_res >= $date_sortie_res) {
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

        } else {
            echo("<style>#footer_connexion {display: none;}</style>");
        }

        ?>

        <div id="resultat_reservation">

            <h2>Résultats de ta recherche : <a href="accueil.php">(modifier ma recherche)</a></h2>


            <!-- Affichage de la liste de places de parking dispos -->

            <?php $parkings = getParkingOfOneAeroport($aeroport_id);
            $nombre_reservations = 0;
            foreach ($parkings as $parking) {
                echo("<div id=liste_reservation>");
                echo("<strong>Aéroport choisi :</strong> $parking->aeroport_nom <br/>");
                echo("<strong>Site proposé :</strong> $parking->lieu <br/>");
                echo("<strong>Adresse :</strong> $parking->adresse <br/>");
                echo("<strong>Nombre de places restantes :</strong> $parking->nb_places <br/>");
                echo("<strong>Prix par jour :</strong> $parking->prix €<br/>");

                $nombre_reservations++;

                echo("<br/>");
                echo("<form action=check_reservation.php method=post>
                                                          <input type=hidden name=aeroport_id value=\"$parking->aeroport_id\" >
                                                          <input type=hidden name=aeroport_nom value=\"$parking->aeroport_nom\" >
                                                          <input type=hidden name=parking_id value=\"$parking->id\" >
                                                          <input type=hidden name=lieu value=\"$parking->lieu\" >
                                                          <input type=hidden name=date_entree value=$date_entree_res >
                                                          <input type=hidden name=date_sortie value=$date_sortie_res >
                                                          <input type=hidden name=prix_choisi value=$parking->prix >
                                                          <input type=hidden name=adresse value=\"$parking->adresse\" >
                                                          <button type=submit >Choisir cette place</button>
                                                       </form>"

                );
                echo("</div>");
            }


            // Si aucune place de parking n'est disponible pour ces dates.
            /**
            if ($nombre_reservations == 0) {
                echo("Aucune place de parking n'est disponible à l'aéroport $aeroport du $date_entree_loc au $date_sortie_loc.<br/>
                                                                            Modifie tes dates ou trouve un autre aéroport.");

            } * **/ ?>

            <!-- Champs cachés -->

            <form action="check_reservation.php" method="post">

                <input type="hidden" name="date_entree_res" value=<?php echo($date_entree_res); ?>>
                <input type="hidden" name="date_sortie_res" value=<?php echo($date_sortie_res); ?>>

            </form>

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
