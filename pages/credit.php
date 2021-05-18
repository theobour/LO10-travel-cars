<?php

    // Connection à la base de données
require_once('./api_call.php');
    // Démarrage de la session

    session_start();

    $pseudo = $_SESSION[pseudo];

?>

<html>

    <head>

        <title>TravelCars - Crédits</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">

        <script>

            var slideIndex = 1;
            showSlides(slideIndex);

            // Next/previous controls
            function plusSlides(n) {
              showSlides(slideIndex += n);
            }

            // Thumbnail image controls
            function currentSlide(n) {
              showSlides(slideIndex = n);
            }

            function showSlides(n) {
              var i;
              var slides = document.getElementsByClassName("mySlides");
              var dots = document.getElementsByClassName("dot");
              if (n > slides.length) {slideIndex = 1}
              if (n < 1) {slideIndex = slides.length}
              for (i = 0; i < slides.length; i++) {
                  slides[i].style.display = "none";
              }
              for (i = 0; i < dots.length; i++) {
                  dots[i].className = dots[i].className.replace(" active", "");
              }
              slides[slideIndex-1].style.display = "block";
              dots[slideIndex-1].className += " active";
            }

        </script>

    </head>

    <body>

        <div class="container">

            <?php

            if (isset ($_SESSION[pseudo])) {
                echo("<div class=\"row\" id=\"menu\">
                        <div class=\"col-sm-2\"><strong><a href=accueil.php>TravelCars</a></strong></div>
                        <div class=\"col-sm-7\"></div>
                        <div class=\"col-sm-2\"><center><a href=\"profil.php\" >Mon compte</a></center></div>
                        <div class=\"col-sm-1\"><center><a href=\"index.php\">Déconnexion</a></center></div>
            </div>");
            }

            else {
                echo("<div class=\"row\" id=\"menu\">
                        <div class=\"col-sm-2\"><strong><a href=index.php>TravelCars</a></strong></div>
                        <div class=\"col-sm-7\"></div>
                        <div class=\"col-sm-2\"><center><a href=\"connection.php\" >Se connecter</a></center></div>
                        <div class=\"col-sm-1\"><center><a href=\"inscription.php\">S'inscrire</a></center></div>
            </div>");
            }

            ?>

            <h2 id="titre_accueil">Facilite tes déplacements avec TravelCars</h2>

            <div id="infos_loc">

            <p>
                TravelCars est un site qui te permet de réserver des places de parking à proximité
                des aéroports à prix réduit. Tu peux également louer des véhicules d'autres utilisateurs de
                la plateforme, qui laissent leurs voitures dans les lieux de stationnement partenaires.
            </p>

            <p>
                En utilisant ce site, tu affirmes avoir plus de 18 ans, de posséder ton permis B ou plus depuis
                au moins 2 ans révolus. Des pièces d'identité et de contrôle te seront demandées au guichet
                lors de la validation de ta réservation ou de ta location. TravelCars ne put pas s'engager à te remboursé
                l'intégralité de ta réservation / location si ces conditions ne sont pas respectées.
            </p>

            </div>

            <div id='partie_credits'>

                <h2>Des centaines de destinations t'attendent depuis nos aéroports partenaires :</h2>

                <?php

                                echo("<p>");
                                // On récupère tous les aéroports partenaires.
                                $aeroports = getAeroport();
                                foreach ($aeroports as $aeroport)
                                        {
                                                echo ("$aeroport->nom<br/>");
                                        }
                                echo("</p>");?>

            </div>

            <div id="infos_loc">

            <p>Ce site a été réalisé dans le cadre de l'UE LOO7, proposé par l'Université de Technologie de Troyes,
            au semestre de printemps 2019. Il a été conçu par Candice Alcaraz et Alice Lusardi, élèves de TC4. Ce site n'a
            pas vocation à être commercial, et s'appuie sur le concept de <a href="https://www.travelcar.com/fr-FR/" target="_blank">TravelCar</a>.</p>

            </div>

            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>

        </div>

    </body>

</html>