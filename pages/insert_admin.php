<?php

// Démarrage de la session + connextion à la base de données

session_start();
require_once('./api_call.php');
try {
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Variables transmises par les formulaires

$lieu = ucwords(strtolower($_POST[lieu]));
$lieu_aeroport = $_POST[lieu_aeroport];
$lieu_nb_places = $_POST[lieu_nb_places];
$lieu_prix = $_POST[lieu_prix];

?>

<html>

<head>

    <title>TravelCars - Administrateur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>

</head>

<body>

<div class="container">

    <?php

    // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

    if (!isset($_SESSION["pseudo"])) {
        echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
    }

    ?>

    <?php

    // Création d'un nouvel aéroport

    if (isset($_POST["aeroport_nom"]) && isset($_POST["aeroport_code"])) {
        $creation = createAeroport(array(
            'nom' => $_POST['aeroport_nom'],
            'code' => $_POST['aeroport_code']
        ));
        if ($creation) {
            echo("<p>L'aéroport $_POST[aeroport_nom] a été rajouté à la base de données.</p> ");
        } else {
            echo("<p>Un problème est survenu.</p> ");
        }
    }

    // Création d'un nouveau parking

    if (isset($_POST["parking_lieu"]) && isset($_POST["parking_aeroport_id"]) && isset($_POST["parking_prix"]) && isset($_POST["parking_nb_places"]) && isset($_POST["parking_adresse"])) {

        $creation = createParking(array(
            "nb_places" => $_POST["parking_nb_places"],
            "lieu" => $_POST["parking_lieu"],
            "aeroport_id" => $_POST["parking_aeroport_id"],
            "prix" => $_POST["parking_prix"],
            "adresse" => $_POST["parking_adresse"],
        ));
        if ($creation) {
            echo("<p>Le parking $lieu de l'aéroport $lieu_aeroport a été rajouté à la base de données.</p> ");
        } else {
            echo("<p>Un problème est survenu.</p> ");
        }


    }

    // Supression d'un compte utilisateur

    if (isset($_POST[pseudo_suppression])) {

        $sup_locations = $bdd->exec('UPDATE vehicule SET locataire = \"administrateur\" AND location = \"non\" WHERE locataire =\'' . $_POST[pseudo_suppression] . '\'');
        $sup_vehicules = $bdd->exec('DELETE FROM vehicule WHERE proprietaire = \'' . $_POST[pseudo_suppression] . '\' ');
        $sup_compte = $bdd->exec('DELETE FROM identifiant WHERE pseudo = \'' . $_POST[pseudo_suppression] . '\' ');

        echo("<p>Le compte $_POST[pseudo_suppression] a été supprimé.</p> ");

    }

    ?>

    <p>L'administrateur peut sur cette page accéder aux différentes informations concernant le
        site web mais peut également rajouter des aérports et des lieux de parking à sa convenance.</p>

    <a href='accueil.php'>Retourner à l'accueil</a>

    <!-- Rajouter un aéroport -->

    <h2>Ajouter un aéroport</h2>

    <form action="insert_admin.php" method="post">

        <div>

            <label for="aeroport">Aéroport à rajouter ?</label>
            <p>Entrer le nom : </p>
            <input type="text" name="aeroport_nom" placeholder="Nom de l'aéroport..." required>
            <p>Entrer le code : </p>
            <input type="text" name="aeroport_code" placeholder="Code de l'aéroport" required>

        </div>

        <button type="submit">Rajouter cet aéroport</button>

    </form>

    <!-- Rajouter un parking -->

    <h2>Ajouter un lieu de parking</h2>

    <form action="insert_admin.php" method="post">

        <div>

            <label for="aeroport">Lieu à rajouter ?</label>
            <input type="text" name="parking_lieu" placeholder="Nom du parking" required>
            <label for="aeroport">Adresse</label>
            <input type="text" name="parking_adresse" placeholder="Nom du parking" required>

        </div>

        <div>

            <label for="lieu_aeroport">Aeroport correspondant ?</label>
            <select name="parking_aeroport_id" required>

                <?php

                $aeroports = getAeroport();

                foreach ($aeroports as $aeroport) {
                    echo("<option value=\"$aeroport->id\">$aeroport->nom</option>");
                } ?>

            </select>

        </div>

        <div>

            <label for="aeroport">Nombre de places disponibles ?</label>
            <input type="number" name="parking_nb_places" placeholder="25" required>

        </div>

        <div>

            <label for="aeroport">Prix de la place de parking (en euros) ?</label>
            <input type="number" name="parking_prix" placeholder="15" required>

        </div>

        <button type="submit">Rajouter cet endroit de stationnement</button>

    </form>
    <details>

        <summary><h2>Utilisateurs du site web</h2></summary>

        <?php

        $utilisateurs = getUsers();

        ?>
        <table class="table table-bordered table-striped table-condensed">

            <caption>

                <h4>Récupération des utilisateurs du site (<?php echo(sizeof($utilisateurs)); ?> au
                    total)</h4>

            </caption>

            <thead>

            <tr>

                <th>Pseudo</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date de naissance</th>
                <th>Telephone</th>
                <th>Suppression ?</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($utilisateurs as $utilisateur) {
                echo("<tr>");
                echo("<td>$utilisateur->pseudo</td>");
                echo("<td>$utilisateur->prenom</td>");
                echo("<td>$utilisateur->nom</td>");
                echo("<td>$utilisateur->email</td>");
                echo("<td>$utilisateur->birthdate</td>");
                echo("<td>0$utilisateur->telephone</td>");
                echo("<td><form method=post action=insert_admin.php>
                               <input type=hidden name=pseudo_suppression value=$utilisateur->pseudo>
                               <button type=submit>Supprimer</button></form></td>");
                echo("</tr>");
            }

            ?>

            </tbody>

        </table>

    </details>

    <!-- Liste des aéroports -->

    <details>

        <summary><h2>Aéroports partenaires</h2></summary>

        <?php

        $aeroports = getAeroport()

        ?>

        <table class="table table-bordered table-striped table-condensed">

            <caption>

                <h4>Récupération des aéroports concernés (<?php echo(sizeof($aeroports)); ?> au total)</h4>

            </caption>

            <thead>

            <tr>

                <th>Aeroport</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($aeroports as $aeroport) {
                echo("<tr>");
                echo("<td>$aeroport->nom</td>");
                echo("</tr>");
            }


            ?>

            </tbody>

        </table>

    </details>

    <!-- Parkings -->

    <details>

        <summary><h2>Parking partenaires</h2></summary>

        <?php

        $parkings = getParkings()

        ?>

        <table class="table table-bordered table-striped table-condensed">

            <caption>

                <h4>Récupération des parkings de stationnement des véhicules (<?php echo(sizeof($parkings)); ?> au
                    total)</h4>

            </caption>

            <thead>

            <tr>

                <th>Parking</th>
                <th>Aéroport concerné</th>
                <th>Nombre de places restantes</th>
                <th>Tarif</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($parkings as $parking) {

                echo("<tr>");
                echo("<td>$parking->lieu</td>");
                echo("<td>$parking->aeroport_nom</td>");
                echo("<td>$parking->nb_places</td>");
                echo("<td>$parking->prix €</td>");
                echo("</tr>");
            }

            ?>

            </tbody>

        </table>

    </details>


    <!-- Véhicules loués -->
    <?php

    /**
     * <details>
     *
     * <summary><h2>Véhicules stationnés et déjà loués</h2></summary>
     *
     * <?php
     *
     * $reponsevehiculeloue = $bdd->query('SELECT type, datedebut, datefin, aeroport, proprietaire, lieu, locataire FROM vehicule WHERE locataire != "administrateur"');
     *
     * $requetevehiculeloue = $bdd->query('SELECT COUNT(locataire) AS NbVehiculesLoues FROM vehicule WHERE locataire != "administrateur"');
     *
     * $compteurvehiculeloue = $requetevehiculeloue->fetch();
     *
     * ?>
     *
     * <table class="table table-bordered table-striped table-condensed">
     *
     * <caption>
     *
     * <h4>Récupération des véhicules loués (<?php echo($compteurvehiculeloue[NbVehiculesLoues]); ?> au
     * total)</h4>
     *
     * </caption>
     *
     * <thead>
     *
     * <tr>
     *
     * <th>Type</th>
     * <th>Propriétaire</th>
     * <th>Locataire</th>
     * <th>Date de début</th>
     * <th>Date de fin</th>
     * <th>Lieu de stationnement</th>
     *
     * </tr>
     *
     * </thead>
     *
     * <tbody>
     *
     * <?php
     *
     * while ($donneesvehiculeloue = $reponsevehiculeloue->fetch()) {
     * echo("<tr>");
     * echo("<td>$donneesvehiculeloue[type]</td>");
     * echo("<td>$donneesvehiculeloue[proprietaire]</td>");
     * echo("<td>$donneesvehiculeloue[locataire]</td>");
     * echo("<td>$donneesvehiculeloue[datedebut]</td>");
     * echo("<td>$donneesvehiculeloue[datefin]</td>");
     * echo("<td>$donneesvehiculeloue[lieu], à $donneesvehiculeloue[aeroport]</td>");
     * echo("</tr>");
     * }
     *
     * $reponsevehiculeloue->closeCursor();
     *
     * ?>
     *
     * </tbody>
     *
     * </table>
     *
     * </details>
     *
     * <!-- Véhicules non loués -->
     *
     * <details>
     *
     * <summary><h2>Véhicules stationnés mais non loués</h2></summary>
     *
     * <?php
     *
     * $reponsevehicule = $bdd->query('SELECT type, couleur, marque, car_places, car_etat, date_entree, date_sortie, aeroport, proprietaire, lieu FROM vehicule WHERE locataire = "administrateur"');
     *
     * $requetevehicule = $bdd->query('SELECT COUNT(id) AS NbVehicules FROM vehicule WHERE locataire = "administrateur"');
     *
     * $compteurvehicule = $requetevehicule->fetch();
     *
     * ?>
     *
     * <table class="table table-bordered table-striped table-condensed">
     *
     * <caption>
     *
     * <h4>Récupération des véhicules non-loués stationnés (<?php echo($compteurvehicule[NbVehicules]); ?> au
     * total)</h4>
     *
     * </caption>
     *
     * <thead>
     *
     * <tr>
     *
     * <th>Type</th>
     * <th>Propriétaire</th>
     * <th>Couleur</th>
     * <th>Marque</th>
     * <th>Etat du véhicule</th>
     * <th>Nombre de places</th>
     * <th>Date d'entrée</th>
     * <th>Date de sortie</th>
     * <th>Lieu de stationnement</th>
     *
     * </tr>
     *
     * </thead>
     *
     * <tbody>
     *
     * <?php
     *
     * while ($donneesvehicule = $reponsevehicule->fetch()) {
     * echo("<tr>");
     * echo("<td>$donneesvehicule[type]</td>");
     * echo("<td>$donneesvehicule[proprietaire]</td>");
     * echo("<td>$donneesvehicule[couleur]</td>");
     * echo("<td>$donneesvehicule[marque]</td>");
     * echo("<td>$donneesvehicule[car_etat]</td>");
     * echo("<td>$donneesvehicule[car_places]</td>");
     * echo("<td>$donneesvehicule[date_entree]</td>");
     * echo("<td>$donneesvehicule[date_sortie]</td>");
     * echo("<td>$donneesvehicule[lieu], à $donneesvehicule[aeroport]</td>");
     * echo("</tr>");
     * }
     *
     * $reponsepseudo->closeCursor();
     *
     * ?>
     *
     * </tbody>
     *
     * </table>
     *
     * </details>
     **/ ?>
</div>

</body>

</html>