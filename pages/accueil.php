<?php

// Démarrage de la session
require_once('./api_call.php');
session_start();

$pseudo = $_SESSION['pseudo'];
// Défition du pseudo de l'administrateur du site.
$pseudoadministrateur = "administrateur";

?>

<html>

<head>

    <meta charset="UTF-8">
    <title>TravelCars - Accueil</title>
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

    <?php

    // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

    if (!isset($_SESSION['prenom'])) {
        echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
    }

    ?>

    <h1 id="titre_accueil">Bienvenue, <?php echo $_SESSION["prenom"] . " " . $_SESSION["nom_user"]; ?> </h1>

    <div id="texte_accueil">

        <div class="row">

            <div class="col-sm-2"></div>

            <div class="col-sm-3">

                <p>Sur le départ ? Réserve ton parking et gare ta voiture en toute sécurité pour
                    un prix attractif. Loue-la pendant ton absence !</p>
                <center><a href=#partie_reservation class="btn btn-secondary btn-lg active" role="button">Réserver une
                        place de parking</a></center>

            </div>

            <div class="col-sm-2"></div>

            <div class="col-sm-3">

                <p>Juste arrivé(e) ? Loue une voiture à ta sortie de l'aéroport. Sans frais
                    supplémentaires, facilement accessibles, dispose de la voiture de ton choix !</p>
                <center><a href=#partie_location class="btn btn-secondary btn-lg active" role="button">Louer un
                        véhicule</a></center>

            </div>

            <div class="col-sm-2"></div>

        </div>

    </div>

    <div id="partie_description_accueil">

        <?php

        // On teste si l'utilisateur est l'administrateur du site.
        if ($pseudo == $pseudoadministrateur) {
            echo("<p><a href=insert_admin.php>Accéder aux informations du site web (gestion du contenu)</a></p>");
        }
        ?>

        <p>TravelCars est un site qui permet aux propriétaires et aux locataires de véhicules d'accéder à plusieurs
            offres
            dans de nombreux aéroports participants. Avec ce service, tu peux économiser de l'argent sur ta réservation
            de parkings
            pour la durée de ton séjour, pendant qu'une autre personne pourra te la louer, à un tarif plus que
            raisonnable.<br/>
            C'est ça, l'objectif de TravelCars : pouvoir voyager en toute sérennité, sans avoir à se soucier des soucis
            que peut
            engendrer la gestion de sa voiture !</p>

        <p><a href='profil.php'>Accéder à mon compte</a> - <a href="index.php">Se déconnecter</a></p>

    </div>

    <!-- Partie RESERVATION -->

    <div id="partie_reservation">

        <h2>Réserver une place de parking</h2>

        <form action="reservation.php" method="post">

            <fieldset>

                <div>

                    <label for="aeroport_resa">Aeroport choisi :</label>
                    <select name="aeroport_resa" required>

                        < <?php
                        $r = getAeroport();

                        foreach ($r as $aeroport) {
                            echo("<option value=\"$aeroport->id\">$aeroport->nom</option>");
                        }
                        ?>

                    </select>

                </div>

                <div>

                    <label for="date_entree_res">Date d'entrée :</label>
                    <input type="date" name="date_entree_res" placeholder="01/06/2019" required>

                </div>

                <div>

                    <label for="date_sortie_res">Date de sortie :</label>
                    <input type="date" name="date_sortie_res" placeholder="09/06/2019" required>

                </div>

            </fieldset>

            <button type="submit">Voir les places disponibles</button>

        </form>

    </div>

    <!-- Partie LOCATION -->

    <div id="partie_location">

        <h2>Louer une voiture</h2>

        <form action="location.php" method="post">

            <fieldset>

                <div>

                    <label for="aeroport_loc">Aeroport choisi :</label>
                    <select name="aeroport_loc" required>

                        <?php
                        $r = getAeroport();

                        foreach ($r as $aeroport) {
                            echo("<option value=\"$aeroport->id\">$aeroport->nom</option>");
                        }
                        ?>

                    </select>

                </div>

                <div>

                    <label for="date_entree_loc">Date de départ :</label>
                    <input type="date" name="date_entree_loc" placeholder="01/06/2019" required>

                </div>

                <div>

                    <label for="date_sortie_loc">Date de fin :</label>
                    <input type="date" name="date_sortie_loc" placeholder="09/06/2019" required>

                </div>

            </fieldset>

            <button type="submit">Voir les véhicules disponibles</button>

        </form>

    </div>

    <div id='partie_description_accueil'>

        <h2>Découvre le monde, on s'occupe de ton véhicule !</h2>
        <p>Près d'une dizaine d'aéroports sont en partenariat avec notre plateforme. Au final, tu disposes
            de plus de 100 destinations en partance de nos sites partenaires, profites-en !</p>
        <p><img src='../images/img8.png' alt='Carte du monde'/>
    </div>

</div>

<div class="row" id="footer_index">
    <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
</div>

</div>

</body>

</html>