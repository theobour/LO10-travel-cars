<?php

// Démarrage de la session + connection à la BDD

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
        <title>TravelCars - Mon compte</title>
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
            
            
            
            <h2 id="titre_accueil"><?php echo ("$_SESSION[prenom] $_SESSION[nom_user]"); ?></h2>
            
            <?php 
            
                $location_nom = "non";
                $locataire_nom = "administrateur";

                // On teste si la personne est connectée, sinon on cache le corps du texte et on la renvoie vers page de connexion.

                if (!isset($_SESSION[pseudo])) {
                    echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
                }

                // Mise à jour des informations concernant l'utilisateur

                // Supprimer un véhicule
                if (isset($_POST[numero_voiture])) {
                    $nb_modifs = $bdd->exec('DELETE FROM vehicule WHERE id = \''.$_POST[numero_voiture].'\' ');
                    echo ("<p id=message_alerte>Ton véhicule a bien été supprimé.</p>");
                }

                // Supprimer une location
                if (isset($_POST[numero_location])) {
                    $nb_modif1 = $bdd->exec('UPDATE vehicule SET location = \''.$location_nom.'\' WHERE id =\''. $_POST[numero_location].'\'');
                    $nb_modif2 = $bdd->exec('UPDATE vehicule SET locataire = \''. $locataire_nom.'\' WHERE id =\''. $_POST[numero_location].'\'');
                    $prix_loc_rembourse = $_POST[prix_loc]/2;
                    echo ("<p id=message_alerte>La location a été supprimée. Le remboursement sera de $prix_loc_rembourse €.</p>");
                }

                // Annuler une réservation de parking suivant certaines conditions
                if (isset($_POST[numero_reservation]) AND $_POST[location_voiture]=="non") {
                    $nb_modifs = $bdd->exec('DELETE FROM vehicule WHERE id = \''.$_POST[numero_reservation].'\' ');
                    $prix_resa_rembourse = $_POST[prix_resa]/2;
                    echo ("<p id=message_alerte>Ta réservation a bien été annulée. Le remboursement sera de $prix_resa_rembourse €.</p>");
                }

                // Message d'erreur si réservation peut pas être annulée
                if (isset($_POST[numero_reservation]) AND $_POST[location_voiture]=="oui") { echo("<p id=message_alerte>Tu ne peux pas annuler ta réservation, ta voiture a déjà été louée.</p>"); }

                // Changement du prénom
                if (isset($_POST[prenom])) {
                    $modif_prenom = $bdd->exec('UPDATE identifiant SET prenom =\''. ucfirst(strtolower($_POST[prenom])).'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    unset($_SESSION['prenom']);
                    $_SESSION['prenom'] = $_POST[prenom];
                    echo ("<p id=message_alerte>Le prénom a été modifié.</p>");
                }

                // Changement du nom
                if (isset($_POST[nom])) {
                    $modif_nom = $bdd->exec('UPDATE identifiant SET nom =\''. ucfirst(strtolower($_POST[nom])).'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    unset($_SESSION['nom_user']);
                    $_SESSION['nom_user'] = $_POST[nom];
                    echo ("<p id=message_alerte>Le nom a été modifié.</p>");
                }

                // Changement de l'email
                if (isset($_POST[email])) {
                    $modif_email = $bdd->exec('UPDATE identifiant SET email =\''. $_POST[email].'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    echo ("<p id=message_alerte>L'email a été modifié.</p>");
                }

                // Changement de la date de naissance
                if (isset($_POST[birthdate])) {
                    $modif_birthdate = $bdd->exec('UPDATE identifiant SET birthdate =\''. $_POST[birthdate].'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    echo ("<p id=message_alerte>La date de naissance a été modifiée.</p>");
                }

                // Changement du téléphone
                if (isset($_POST[telephone])) {
                    $modif_telephone = $bdd->exec('UPDATE identifiant SET telephone =\''. $_POST[telephone].'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    echo ("<p id=message_alerte>Le numéro de téléphone a été modifié.</p>");
                }
                
                // Changement du téléphone
                if (isset($_POST[mdp])) {
                    $modif_mdp = $bdd->exec('UPDATE identifiant SET mdp =\''. password_hash($_POST[mdp], PASSWORD_DEFAULT).'\' WHERE pseudo =\''. $_SESSION[pseudo].'\'');
                    echo ("<p id=message_alerte>Le mot de passe a été modifié.</p>");
                }

                ?>
            
            <!-- Informations sur mon profil -->
            
            <?php 
            
            // Afichage des informations
            
            $reponse = $bdd->query('SELECT pseudo, prenom, nom, email, birthdate, telephone, mdp FROM identifiant WHERE pseudo =\''. $_SESSION[pseudo].'\' ');

                                            while ($donnees = $reponse->fetch())
                                            {
                                                    echo("<div id=infos_perso>");
                                                    echo ("<p><strong>Pseudo :</strong> $donnees[pseudo]</p>");
                                                    echo ("<p><strong>Prénom :</strong> $donnees[prenom]</p>");
                                                    echo ("<p><strong>Nom :</strong> $donnees[nom]</p>");
                                                    echo ("<p><strong>Email :</strong> $donnees[email]</p>");
                                                    echo ("<p><strong>Date de naissance :</strong> $donnees[birthdate]</p>");
                                                    echo ("<p><strong>Numéro de téléphone :</strong> 0$donnees[telephone]</p>");
                                                    echo("</div>");
            
            // Modifications des informations persos
                                            
            echo("<h3>Modifier mes informations personnelles</h3>");
            
            // Modifications du PRENOM
            echo("<div id=\"new_vehicule2\">");
            echo ("<form action=profil.php method=post>
            <input type=text name=prenom value=\"$donnees[prenom]\" >
            <button type=submit >Modifier mon prénom</button>
            </form>"
            );
            
            // Modification du NOM
            
            echo ("<form action=profil.php method=post>
            <input type=text name=nom value=\"$donnees[nom]\" >
            <button type=submit >Modifier mon nom</button>
            </form>"
            );
            
            // Modification de l'EMAIL
            
            echo ("<form action=profil.php method=post>
            <input type=email name=email value=\"$donnees[email]\" >
            <button type=submit >Modifier mon email</button>
            </form>"
            );
            
            // Modification de la DATE DE NAISSANCE
            
            echo ("<form action=profil.php method=post>
            <input type=date name=birthdate value=\"$donnees[birthdate]\" >
            <button type=submit >Modifier ma date de naissance</button>
            </form>"
            );
            
            // Modification du TELEPHONE
            
            echo ("<form action=profil.php method=post>
            <input type=tel name=telephone value=\"$donnees[telephone]\" >
            <button type=submit >Modifier mon numéro de téléphone</button>
            </form>"
            );
            
            // Modification du MOT DE PASSE
            
            echo ("<form action=profil.php method=post>
            <input type=password name=mdp value=\"$_SESSION[pseudo]\" >
            <button type=submit >Modifier mon mot de passe</button>
            </form></div>"
            );
            
            }
            
            $reponse->closeCursor(); 
           
            ?>
            
            <!-- Véhicules de l'utilisateur -->
            
            <details id="partie_profil">
                
                <summary><h2>Mes véhicules</h2></summary>
            
                <?php $reponse = $bdd->query('SELECT id, type, couleur, marque, car_places, car_etat FROM vehicule WHERE proprietaire =\''. $_SESSION[pseudo].'\' AND copie = "non" ');

                                            $i1 = 0;
                                            while ($donnees = $reponse->fetch())
                                            {
                                                    echo ("<div id=vehicule_profil>");
                                                    echo ("<p><strong>Catégorie :</strong> $donnees[type] </p>");
                                                    echo ("<p><strong>Couleur :</strong> $donnees[couleur]</p>");
                                                    echo ("<p><strong>Marque :</strong> $donnees[marque]</p>");
                                                    echo ("<p><strong>Nombre de places :</strong> $donnees[car_places]</p>");
                                                    echo ("<p><strong>Etat du véhicule :</strong> $donnees[car_etat]</p>");
                                                    echo("<br/>");
                                                    $i1 = $i1 + 1;

                                                    // Pour supprimer un véhicule de la liste
                                                    echo ("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_voiture value=\"$donnees[id]\" >
                                                              <button type=submit >Supprimer ce véhicule</button>
                                                           </form>"

                                                            );
                                            }

                                            // Si l'utilisateur n'a pas de véhicules enregistrés
                                            // Possibilité de le faire avec un SELECT COUNT
                                            if ($i1 == 0) { echo ("<p>Tu n'as pas de véhicules enregistrés.</p>"); }

                                            $reponse->closeCursor(); ?>
                
            </details>
            
            <!-- Locations de l'utilisateur -->
            
            <details id="partie_profil">
            
                <summary><h2>Mes locations de véhicules</h2></summary>
            
                <?php $reponse = $bdd->query('SELECT id, type, couleur, marque, datedebut, datefin, aeroport, lieu FROM vehicule WHERE locataire =\''. $_SESSION[pseudo].'\' ');

                                            $i2 = 0;
                                            while ($donnees = $reponse->fetch())
                                            {
                                                    echo ("<div id=vehicule_profil>");
                                                    echo ("<p><strong>Catégorie :</strong> $donnees[type]</p>");
                                                    echo ("<p><strong>Couleur :</strong> $donnees[couleur]</p>");
                                                    echo ("<p><strong>Marque :</strong> $donnees[marque]</p>");
                                                    echo ("<p><strong>Aéroport :</strong> $donnees[aeroport] (stationnée au $donnees[lieu])</p>");
                                                    echo ("<p><strong>Début de location :</strong> $donnees[datedebut]</p>");
                                                    echo ("<p><strong>Fin de location :</strong> $donnees[datefin]</p>");
                                                    $i2 = $i2 + 1;
                                                    
                                            // Enregistrement du prix de la location
                                            
                                            $reponse4 = $bdd->query('SELECT prix FROM site WHERE lieu =\''. $donnees[lieu].'\' ');

                                            while ($donnees4 = $reponse4->fetch())
                                            {
                                                    $datedebut = $donnees[datedebut];
                                                    $datefin = $donnees[datefin];

                                                    $datedebut_modif = strtotime($datedebut);
                                                    $datefin_modif = strtotime($datefin);
                                                    $nbjours_loc_stamp = $datefin_modif - $datedebut_modif;
                                                    $nbjours_loc = $nbjours_loc_stamp/86400;

                                                    $prix_loc = $donnees4[prix]*($nbjours_loc+1)*1.5;
                                                    
                                                    echo ("<p><strong>Prix de la location :</strong> $prix_loc €</p>");

                                            }

                                                    // Pour supprimer une location de la liste
                                                    echo ("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_location value=\"$donnees[id]\" >
                                                              <input type=hidden name=prix_loc value=\"$prix_loc\" >
                                                              <button type=submit >Annuler cette location</button>
                                                           </form></div>"

                                                            );
                                            }

                                            // Si l'utilisateur n'a pas de location effectuée.
                                            // Idem, on peut utiliser un SELECT COUNT
                                            if ($i2 == 0) { echo ("<p>Tu n'as pas de loué de véhicules pour le moment.</p>"); }

                                            $reponse->closeCursor(); ?>
                
            </details>
            
            <!-- Réservations de parking de l'utilisateur -->
            
            <details id="partie_profil">
            
                <summary><h2>Mes réservations de parking</h2></summary>
            
                <?php $reponse = $bdd->query('SELECT id, date_entree, date_sortie, aeroport, lieu, location FROM vehicule WHERE proprietaire =\''. $_SESSION[pseudo].'\' ');

                                            $i3 = 0;
                                            while ($donnees = $reponse->fetch())
                                            {
                                                    echo ("<div id=vehicule_profil>");
                                                    echo ("<p><strong>Date d'entrée :</strong> $donnees[date_entree]</p>");
                                                    echo ("<p><strong>Date de sortie :</strong> $donnees[date_sortie]</p>");
                                                    echo ("<p><strong>Aéroport :</strong $donnees[aeroport]</p>");
                                                    echo ("<p><strong>Lieu de stationnement :</strong> $donnees[lieu]</p>");
                                                    $i3 = $i3 + 1;
                                                    
                        // Enregistrement du prix de la réservation
                                            
                        $reponse2 = $bdd->query('SELECT prix FROM site WHERE lieu =\''. $donnees[lieu].'\' ');

                                            while ($donnees2 = $reponse2->fetch())
                                            {
                                                    $date_entree = $donnees[date_entree];
                                                    $date_sortie = $donnees[date_sortie];

                                                    $date_entree_modif = strtotime($date_entree);
                                                    $date_sortie_modif = strtotime($date_sortie);
                                                    $nbjours_resa_stamp = $date_sortie_modif - $date_entree_modif;
                                                    $nbjours_resa = $nbjours_resa_stamp/86400;

                                                    $lieu_choisi = $_POST[lieu_choisi];

                                                    $prix_resa = $donnees2[prix]*($nbjours_resa+1);
                                                    
                                                    echo ("<p><strong>Prix de la réservation :</strong> $prix_resa €</p>");

                                            }
                                            
                                            // Pour supprimer une réservation de la liste
                                                    echo ("<form action=profil.php method=post>
                                                              <input type=hidden name=numero_reservation value=\"$donnees[id]\" >
                                                              <input type=hidden name=location_voiture value=\"$donnees[location]\" >
                                                              <input type=hidden name=prix_resa value=\"$prix_resa\" >
                                                              <button type=submit >Annuler cette réservation</button>
                                                           </form></div>"

                                                            ); }

                                            // Si l'utilisateur n'a pas de réservation effectuée.
                                            // Idem, on peut utiliser un SELECT COUNT
                                            if ($i3 == 0) { echo ("<p>Tu n'as pas réservé de places de parking.</p>"); }

                                            $reponse->closeCursor(); ?>
                
            </details>
            
            <div class="row" id="footer_index">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>

