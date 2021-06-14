<?php

require_once "../services/trafic_api.php";

$Trafic = Trafic::getInstance();

?>

<html>

    <head>

        <meta charset="UTF-8">
        <title>TravelCars - Plannifier mon trajet</title>
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

            <br/><br/><br/><br/>
            <h4>plannifiez votre trajet</h4>

            <br/>
            <h5>Utilisez cette page pour connaitre des informations sur le trafic des principales voies routières en France.</h5>
            <h5>il vous suffit d'indiquer le nom d'une route / autoroute pour connaitre ses donénes si elles existent</h5>

            <div id="infos_resa">
                <form method="GET" action="check_trafic.php">
                    <label for="voies">Nom de la voie </label>
                    <input type="text" name="voie">
                    <button type="submit">Vérifier trafic</button>
                </form>

                <?php
                    if (isset($_GET['voie'])) {
                        $ids = $Trafic->idFromAxe($_GET['voie']);
                        $flowsum = 0;
                        $speedsum = 0;

                        foreach($ids as $id) {
                            $data = $Trafic->data($id);
                            $flowsum += $data['flow'];
                            $speedsum += $data['speed'];
                        }

                        $flow = $flowsum / (count($ids) > 0 ? count($ids) : 1);
                        $speed = $speedsum / (count($ids) > 0 ? count($ids) : 1);

                        if (count($ids) == 0) {
                            echo "Nous n'avons pas de données sur cette voie";
                        } else {
                            print("Il y a ".round($flow)." voitures pour une vitesse moyenne de ".round($speed)." km/h");
                        }
                    }
                ?>
            </div>

            </div>

            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>

        </div>

    </body>

</html>

