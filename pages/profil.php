<?php

// Démarrage de la session + connection à la BDD

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
    <title>TravelCars - Mon compte</title>
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


    <h2 id="titre_accueil"><?php echo("$_SESSION[prenom] $_SESSION[nom_user]"); ?></h2>

    <?php

    $location_nom = "non";
    $locataire_nom = "administrateur";

    // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

    if (!isset($_SESSION["pseudo"])) {
        echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
    }

    // Mise à jour des informations concernant l'utilisateur

    // Supprimer un véhicule
    if (isset($_POST["numero_voiture"])) {
        $delete = deleteVoiture($_POST["numero_voiture"]);
        if ($delete) {
            echo("<p id=message_alerte>Ton véhicule a bien été supprimé.</p>");
        } else {
            echo("<p id=message_alerte>Ton véhicule n'a pas été supprimé.</p>");
        }

    }

    // Supprimer une location
    if (isset($_POST["numero_location"])) {
        $nb_modif1 = $bdd->exec('UPDATE vehicule SET location = \'' . $location_nom . '\' WHERE id =\'' . $_POST[numero_location] . '\'');
        $nb_modif2 = $bdd->exec('UPDATE vehicule SET locataire = \'' . $locataire_nom . '\' WHERE id =\'' . $_POST[numero_location] . '\'');
        $prix_loc_rembourse = $_POST[prix_loc] / 2;
        echo("<p id=message_alerte>La location a été supprimée. Le remboursement sera de $prix_loc_rembourse €.</p>");
    }

    // Annuler une réservation de parking suivant certaines conditions
    if (isset($_POST["numero_reservation"]) and $_POST["location_voiture"] == "non") {
        $nb_modifs = $bdd->exec('DELETE FROM vehicule WHERE id = \'' . $_POST[numero_reservation] . '\' ');
        $prix_resa_rembourse = $_POST[prix_resa] / 2;
        echo("<p id=message_alerte>Ta réservation a bien été annulée. Le remboursement sera de $prix_resa_rembourse €.</p>");
    }

    // Message d'erreur si réservation peut pas être annulée
    if (isset($_POST["numero_reservation"]) and $_POST["location_voiture"] == "oui") {
        echo("<p id=message_alerte>Tu ne peux pas annuler ta réservation, ta voiture a déjà été louée.</p>");
    }

    // Changement du profil
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['naissance']) && isset($_POST['telephone']) && isset($_POST['mdp'])) {
        $update = updateUserProfile($_SESSION['id'], array(
                'prenom'=>$_POST['prenom'],
                'nom'=>$_POST['nom'],
                'email'=>$_POST['email'],
                'naissance'=>$_POST['naissance'],
                'telephone'=>$_POST['telephone'],
                'password'=>$_POST['mdp'],
        ));
        if ($update) {
            echo("<p id=message_alerte>Ton profil a été modifié.</p>");
        } else {
            echo("<p id=message_alerte>Ton profil n'a pas été modifié.</p>");
        }
    }

    ?>

    <?php

    // Afichage des informations

    $utilisateur = getOneUser($_SESSION['id']);

    echo("<div id=infos_perso>");
    echo("<p><strong>Pseudo :</strong> $utilisateur->pseudo</p>");
    echo("<p><strong>Prénom :</strong> $utilisateur->prenom</p>");
    echo("<p><strong>Nom :</strong> $utilisateur->nom</p>");
    echo("<p><strong>Email :</strong> $utilisateur->email</p>");
    echo("<p><strong>Date de naissance :</strong> $utilisateur->naissance</p>");
    echo("<p><strong>Numéro de téléphone :</strong> $utilisateur->telephone</p>");
    echo("</div>");

    // Modifications des informations persos

    echo("<h3>Modifier mes informations personnelles</h3>");

    // Modifications du PRENOM
    echo("<div id=\"new_vehicule2\">");
    echo("<form action=profil.php method=post>
            <input type=text name=prenom value=\"$utilisateur->prenom\" >
            <input type=text name=nom value=\"$utilisateur->nom\" >
             <input type=email name=email value=\"$utilisateur->email\" >
             <input type=date name=naissance value=\"$utilisateur->naissance\" >
             <input type=tel name=telephone value=\"$utilisateur->telephone\" >
               <input type=password name=mdp value='' >
            <button type=submit >Modifier mes informations</button>
            </form>"
    );


    ?>

    <!-- Véhicules de l'utilisateur -->

    <details id="partie_profil">

        <summary><h2>Mes véhicules</h2></summary>

        <?php $voitures = getVoitureFromUtilisateur($_SESSION['id']);
        $i1 = 0;
        foreach ($voitures as $voiture) {
            echo("<div id=vehicule_profil>");
            echo("<p><strong>Catégorie :</strong> $voiture->type </p>");
            echo("<p><strong>Couleur :</strong> $voiture->couleur</p>");
            echo("<p><strong>Marque :</strong> $voiture->marque</p>");
            echo("<p><strong>Nombre de places :</strong> $voiture->nb_place</p>");
            echo("<p><strong>Etat du véhicule :</strong> $voiture->etat</p>");
            echo("<br/>");
            $i1 = $i1 + 1;

            // Pour supprimer un véhicule de la liste
            echo("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_voiture value=\"$voiture->id\" >
                                                              <button type=submit >Supprimer ce véhicule</button>
                                                           </form>"

            );
        }

        // Si l'utilisateur n'a pas de véhicules enregistrés
        // Possibilité de le faire avec un SELECT COUNT
        if ($i1 == 0) {
            echo("<p>Tu n'as pas de véhicules enregistrés.</p>");
        }
        ?>

    </details>

    <!-- Locations de l'utilisateur -->

    <details id="partie_profil">

        <summary><h2>Mes locations de véhicules</h2></summary>

        <?php $reservations = getReservationFromLocataire($_SESSION['id']);
        $i2 = 0;
        foreach ($reservations as $reservation) {
            echo("<div id=vehicule_profil>");
            echo("<p><strong>Catégorie :</strong> $reservation->type</p>");
            echo("<p><strong>Couleur :</strong> $reservation->couleur</p>");
            echo("<p><strong>Marque :</strong> $reservation->marque</p>");
            echo("<p><strong>Aéroport :</strong> $reservation->aeroport (stationnée au $reservation->lieu)</p>");
            echo("<p><strong>Début de location :</strong> $reservation->date_debut</p>");
            echo("<p><strong>Fin de location :</strong> $reservation->date_fin</p>");
            echo("<p><strong>Prix :</strong> $reservation->prix</p>");
            $i2 = $i2 + 1;


            // Pour supprimer une location de la liste
            echo("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_location value=\"$reservation->id\" >
                                                              <input type=hidden name=prix_loc value=\"$reservation->prix\" >
                                                              <button type=submit >Annuler cette location</button>
                                                           </form></div>"

            );
        }

        // Si l'utilisateur n'a pas de location effectuée.
        // Idem, on peut utiliser un SELECT COUNT
        if ($i2 == 0) {
            echo("<p>Tu n'as pas de loué de véhicules pour le moment.</p>");
        }
        ?>

    </details>

    <!-- Réservations de parking de l'utilisateur -->

    <details id="partie_profil">

        <summary><h2>Mes réservations de parking</h2></summary>

        <?php $reponse = $bdd->query('SELECT id, date_entree, date_sortie, aeroport, lieu, location FROM vehicule WHERE proprietaire =\'' . $_SESSION[pseudo] . '\' ');

        $i3 = 0;
        while ($donnees = $reponse->fetch()) {
            echo("<div id=vehicule_profil>");
            echo("<p><strong>Date d'entrée :</strong> $donnees[date_entree]</p>");
            echo("<p><strong>Date de sortie :</strong> $donnees[date_sortie]</p>");
            echo("<p><strong>Aéroport :</strong $donnees[aeroport]</p>");
            echo("<p><strong>Lieu de stationnement :</strong> $donnees[lieu]</p>");
            $i3 = $i3 + 1;

            // Enregistrement du prix de la réservation

            $reponse2 = $bdd->query('SELECT prix FROM site WHERE lieu =\'' . $donnees[lieu] . '\' ');

            while ($donnees2 = $reponse2->fetch()) {
                $date_entree = $donnees[date_entree];
                $date_sortie = $donnees[date_sortie];

                $date_entree_modif = strtotime($date_entree);
                $date_sortie_modif = strtotime($date_sortie);
                $nbjours_resa_stamp = $date_sortie_modif - $date_entree_modif;
                $nbjours_resa = $nbjours_resa_stamp / 86400;

                $lieu_choisi = $_POST[lieu_choisi];

                $prix_resa = $donnees2[prix] * ($nbjours_resa + 1);

                echo("<p><strong>Prix de la réservation :</strong> $prix_resa €</p>");

            }

            // Pour supprimer une réservation de la liste
            echo("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_reservation value=\"$donnees[id]\" >
                                                              <input type=hidden name=location_voiture value=\"$donnees[location]\" >
                                                              <input type=hidden name=prix_resa value=\"$prix_resa\" >
                                                              <button type=submit >Annuler cette réservation</button>
                                                           </form></div>"

            );
        }

        // Si l'utilisateur n'a pas de réservation effectuée.
        // Idem, on peut utiliser un SELECT COUNT
        if ($i3 == 0) {
            echo("<p>Tu n'as pas réservé de places de parking.</p>");
        }

        $reponse->closeCursor(); ?>

    </details>

    <div class="row" id="footer_index">
        <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
    </div>

</div>

</body>

</html>

