<?php

// Démarrage de la session
require_once('./api_call.php');
$url_to_redirect = "http://localhost:8890/project/LO10-travel-cars/pages";
if (!isset($_SESSION['auth'])) {
    header('Location: ' . $url_to_redirect . '/index.php');
}
// Défition du pseudo de l'administrateur du site.
$pseudoadministrateur = "admin";


require("./../services/parkingAPI.php");
$tab_localisation = get_localisation();
?>

<html>

<head>

    <meta charset="UTF-8">
    <title>TravelCars - Accueil</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">
	
	<meta charset="utf-8">
        <!-- Nous chargeons les fichiers CDN de Leaflet. Le CSS AVANT le JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
        <style type="text/css">
	    #map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
	        height:300px;
	    }
	</style>
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
                    <select name="aeroport_id" required>

                        <?php
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

<div id='partie_map'>

		<h2>Besoin d'une place de parking ?</h2>
		<p>Rechercher une place de parking parmi des centaines disponibles partout en France !</p>

        <div id="map">
	    <!-- Ici s'affichera la carte -->
	    </div>
    </div>

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


<!-- Fichiers Javascript -->
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
        <script type='text/javascript' src='https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js'></script>
	<script type="text/javascript">

	    // On initialise la latitude et la longitude de Paris (centre de la carte)
	    var lat = 48.852969;
	    var lon = 2.349903;
	    var macarte = null;
            var markerClusters; // Servira à stocker les groupes de marqueurs
            // Nous initialisons une liste de marqueurs
			
			
            var parkings_loc = <?php echo json_encode($tab_localisation)?>;
			
	    // Fonction d'initialisation de la carte
            function initMap() {
		// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
                macarte = L.map('map').setView([lat, lon], 10);
                markerClusters = L.markerClusterGroup(); // Nous initialisons les groupes de marqueurs
                // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    // Il est toujours bien de laisser le lien vers la source des données
                    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                    minZoom: 1,
                    maxZoom: 20
                }).addTo(macarte);4
				
				
                // Nous parcourons la liste des villes
                for (p in parkings_loc) {
                    var marker = L.marker([parkings_loc[p].Lat, parkings_loc[p].Long]); // pas de addTo(macarte), l'affichage sera géré par la bibliothèque des clusters
					marker.bindPopup(
						'<ul><h3>'+parkings_loc[p].nom+'</h3>'+
						'<a href ="'+parkings_loc[p].url+'">'+parkings_loc[p].adresse+'</a>'+
						'<li>1h : '+parkings_loc[p].Prix1H+'€</li>'+
						'<li>2h : '+parkings_loc[p].Prix2H+'€</li>'+
						'<li>3h : '+parkings_loc[p].Prix3H+'€</li>'+
						'<li>4h : '+parkings_loc[p].Prix4H+'€</li>'+
						'<li>24h : '+parkings_loc[p].Prix24H+'€</li></ul>'+
						'<p>Nombre de places : '+parkings_loc[p].nbPlace+'</p>');
                    markerClusters.addLayer(marker); // Nous ajoutons le marqueur aux groupes
                }
                macarte.addLayer(markerClusters);
            }
	    window.onload = function(){
		// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
		initMap(); 
	    };
	</script>
</body>

</html>