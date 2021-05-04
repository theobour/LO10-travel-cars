<?php

// Démarrage de la session + connextion à la base de données

session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Variables transmises par les formulaires

$aeroport = ucwords(strtolower($_POST[aeroport]));
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

            if (!isset($_SESSION[pseudo])) {
                echo("<style>.container{display:none;}</style><br/>Tu n'es pas connecté(e)... <a href=connection.php>Me connecter</a>");
            }

            ?>
            
            <?php
            
                // Création d'un nouvel aéroport

                if(isset($_POST[aeroport])) { 

                        $req = $bdd->prepare('INSERT INTO aeroport(aeroport) VALUES(:aeroport)');

                        $req->execute(array(

                        'aeroport' => $aeroport

                        ));

                        echo("<p>L'aéroport $aeroport a été rajouté à la base de données.</p> ");

                }

                // Création d'un nouveau parking

                if(isset($_POST[lieu])) { 

                $req = $bdd->prepare('INSERT INTO site(lieu, aeroport, nb_places, prix) VALUES(:lieu, :aeroport, :nb_places, :prix)');

                        $req->execute(array(

                        'lieu' => $lieu,
                        'aeroport' => $lieu_aeroport,
                        'nb_places' => $lieu_nb_places,
                        'prix' => $lieu_prix

                        ));

                        echo("<p>Le parking $lieu de l'aéroport $lieu_aeroport a été rajouté à la base de données.</p> ");

                        }
                        
                // Supression d'un compte utilisateur

                if(isset($_POST[pseudo_suppression])) { 
                    
                        $sup_locations = $bdd->exec('UPDATE vehicule SET locataire = \"administrateur\" AND location = \"non\" WHERE locataire =\''. $_POST[pseudo_suppression].'\'');
                        $sup_vehicules = $bdd->exec('DELETE FROM vehicule WHERE proprietaire = \''.$_POST[pseudo_suppression].'\' ');
                        $sup_compte = $bdd->exec('DELETE FROM identifiant WHERE pseudo = \''.$_POST[pseudo_suppression].'\' ');

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
                    <input type="text" name="aeroport" placeholder="Ville, nom de l'aéroport..." required>

                </div>
                
                <button type="submit" >Rajouter cet aéroport</button>

            </form>
            
             <!-- Rajouter un parking -->
            
            <h2>Ajouter un lieu de parking</h2>
            
            <form action="insert_admin.php" method="post">

                <div>

                    <label for="aeroport">Lieu à rajouter ?</label>
                    <input type="text" name="lieu" placeholder="Nom du parking" required>

                </div>
                
                <div>

                            <label for="lieu_aeroport">Aeroport correspondant ?</label>
                            <select name="lieu_aeroport" required>
                                
                                <?php 
                                
                                $reponse = $bdd->query('SELECT aeroport FROM aeroport');

                                while ($donnees = $reponse->fetch())
                                        {
                                                echo ("<option value=\"$donnees[aeroport]\">$donnees[aeroport]</option>");
                                        } ?>
                                
                            </select>

                        </div>
                
                <div>

                    <label for="aeroport">Nombre de places disponibles ?</label>
                    <input type="number" name="lieu_nb_places" placeholder="25" required>

                </div>
                
                <div>

                    <label for="aeroport">Prix de la place de parking (en euros) ?</label>
                    <input type="number" name="lieu_prix" placeholder="15" required>

                </div>
                
                <button type="submit" >Rajouter cet endroit de stationnement</button>

            </form>
            
            <!-- Liste des aéroports -->
            
            <details>
                
                <summary><h2>Aéroports partenaires</h2></summary>
            
                <?php 
                
                $reponseaeroport = $bdd->query('SELECT aeroport FROM aeroport');
                
                $requeteaeroport = $bdd->query('SELECT COUNT(aeroport) AS NbAeroport FROM aeroport');
                
                $compteuraeroport = $requeteaeroport->fetch();
       
                ?>
                
                <table class="table table-bordered table-striped table-condensed"> 

                <caption>

                    <h4>Récupération des aéroports concernés (<?php echo($compteuraeroport[NbAeroport]); ?> au total)</h4>

                </caption>

                <thead>

                    <tr>

                        <th>Aeroport</th>

                    </tr>

                </thead>

                <tbody>
                
                    <?php 
                
                    while ($donneesaeroport = $reponseaeroport->fetch()) {
                        echo("<tr>");
                       echo("<td>$donneesaeroport[aeroport]</td>");
                       echo("</tr>");
                    }
                    
                    $reponseaeroport->closeCursor();
                    
                    ?>
                
                </tbody>

            </table>
                
            </details>
            
            <!-- Parkings -->
            
            <details>
                
                <summary><h2>Parking partenaires</h2></summary>
            
                <?php 
                
                $reponselieu = $bdd->query('SELECT lieu, aeroport, nb_places, prix FROM site');
                
                $requetelieu = $bdd->query('SELECT COUNT(lieu) AS NbLieu FROM site');
                
                $compteurlieu = $requetelieu->fetch();
       
                ?>
                
                <table class="table table-bordered table-striped table-condensed"> 

                <caption>

                    <h4>Récupération des parkings de stationnement des véhicules (<?php echo($compteurlieu[NbLieu]); ?> au total)</h4>

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
                
                    while ($donneeslieu = $reponselieu->fetch()) {
                        
                        $requetelieuspe = $bdd->query('SELECT COUNT(id) AS NbLieuSpe FROM vehicule WHERE lieu =\''. $donneeslieu[lieu].'\' ');
                
                        $compteurlieuspe = $requetelieuspe->fetch();
                        
                        $compteurtotal = $donneeslieu[nb_places] + $compteurlieuspe[NbLieuSpe];
                
                        echo("<tr>");
                       echo("<td>$donneeslieu[lieu]</td>");
                       echo("<td>$donneeslieu[aeroport]</td>");
                       echo("<td>$donneeslieu[nb_places] sur $compteurtotal</td>");
                       echo("<td>$donneeslieu[prix] €</td>");
                       echo("</tr>");
                    }
                    
                    $reponselieu->closeCursor();
                    
                    ?>
                
                </tbody>

            </table>
                
            </details>
            
            <!-- Utilisateurs -->
            
            <details>
                
                <summary><h2>Utilisateurs du site web</h2></summary>
            
                <?php 
                
                $reponsepseudo = $bdd->query('SELECT pseudo, prenom, nom, email, birthdate, telephone FROM identifiant WHERE pseudo != "administrateur"');
                
                $requetepseudo = $bdd->query('SELECT COUNT(pseudo) AS NbUtilisateurs FROM identifiant WHERE pseudo != "administrateur"');
                
                $compteurpseudo = $requetepseudo->fetch();
       
                ?>
                
                <table class="table table-bordered table-striped table-condensed"> 

                <caption>

                    <h4>Récupération des utilisateurs du site (<?php echo($compteurpseudo[NbUtilisateurs]); ?> au total)</h4>

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
                
                    while ($donneespseudo = $reponsepseudo->fetch()) {
                        echo("<tr>");
                       echo("<td>$donneespseudo[pseudo]</td>");
                       echo("<td>$donneespseudo[prenom]</td>");
                       echo("<td>$donneespseudo[nom]</td>");
                       echo("<td>$donneespseudo[email]</td>");
                       echo("<td>$donneespseudo[birthdate]</td>");
                       echo("<td>0$donneespseudo[telephone]</td>");
                       echo("<td><form method=post action=insert_admin.php>
                               <input type=hidden name=pseudo_suppression value=$donneespseudo[pseudo]>
                               <button type=submit>Supprimer</button></form></td>");
                       echo("</tr>");
                    }
                    
                    $reponsepseudo->closeCursor();
                    
                    ?>
                
                </tbody>

            </table>
                
            </details>
            
            <!-- Véhicules loués -->
            
            <details>
                
                <summary><h2>Véhicules stationnés et déjà loués</h2></summary>
            
                <?php 
                
                $reponsevehiculeloue = $bdd->query('SELECT type, datedebut, datefin, aeroport, proprietaire, lieu, locataire FROM vehicule WHERE locataire != "administrateur"');
                
                $requetevehiculeloue = $bdd->query('SELECT COUNT(locataire) AS NbVehiculesLoues FROM vehicule WHERE locataire != "administrateur"');
                
                $compteurvehiculeloue = $requetevehiculeloue->fetch();
       
                ?>
                
                <table class="table table-bordered table-striped table-condensed"> 

                <caption>

                    <h4>Récupération des véhicules loués (<?php echo($compteurvehiculeloue[NbVehiculesLoues]); ?> au total)</h4>

                </caption>

                <thead>

                    <tr>

                        <th>Type</th>
                        <th>Propriétaire</th>
                        <th>Locataire</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Lieu de stationnement</th>

                    </tr>

                </thead>

                <tbody>
                
                    <?php 
                
                    while ($donneesvehiculeloue = $reponsevehiculeloue->fetch()) {
                        echo("<tr>");
                       echo("<td>$donneesvehiculeloue[type]</td>");
                       echo("<td>$donneesvehiculeloue[proprietaire]</td>");
                       echo("<td>$donneesvehiculeloue[locataire]</td>");
                       echo("<td>$donneesvehiculeloue[datedebut]</td>");
                       echo("<td>$donneesvehiculeloue[datefin]</td>");
                       echo("<td>$donneesvehiculeloue[lieu], à $donneesvehiculeloue[aeroport]</td>");
                       echo("</tr>");
                    }
                    
                    $reponsevehiculeloue->closeCursor();
                    
                    ?>
                
                </tbody>

            </table>
                
            </details>
            
            <!-- Véhicules non loués -->
            
            <details>
                
                <summary><h2>Véhicules stationnés mais non loués</h2></summary>
            
                <?php 
                
                $reponsevehicule = $bdd->query('SELECT type, couleur, marque, car_places, car_etat, date_entree, date_sortie, aeroport, proprietaire, lieu FROM vehicule WHERE locataire = "administrateur"');
                
                $requetevehicule = $bdd->query('SELECT COUNT(id) AS NbVehicules FROM vehicule WHERE locataire = "administrateur"');
                
                $compteurvehicule = $requetevehicule->fetch();
       
                ?>
                
                <table class="table table-bordered table-striped table-condensed"> 

                <caption>

                    <h4>Récupération des véhicules non-loués stationnés (<?php echo($compteurvehicule[NbVehicules]); ?> au total)</h4>

                </caption>

                <thead>

                    <tr>

                        <th>Type</th>
                        <th>Propriétaire</th>
                        <th>Couleur</th>
                        <th>Marque</th>
                        <th>Etat du véhicule</th>
                        <th>Nombre de places</th>
                        <th>Date d'entrée</th>
                        <th>Date de sortie</th>
                        <th>Lieu de stationnement</th>

                    </tr>

                </thead>

                <tbody>
                
                    <?php 
                
                    while ($donneesvehicule = $reponsevehicule->fetch()) {
                        echo("<tr>");
                       echo("<td>$donneesvehicule[type]</td>");
                       echo("<td>$donneesvehicule[proprietaire]</td>");
                       echo("<td>$donneesvehicule[couleur]</td>");
                       echo("<td>$donneesvehicule[marque]</td>");
                       echo("<td>$donneesvehicule[car_etat]</td>");
                       echo("<td>$donneesvehicule[car_places]</td>");
                       echo("<td>$donneesvehicule[date_entree]</td>");
                       echo("<td>$donneesvehicule[date_sortie]</td>");
                       echo("<td>$donneesvehicule[lieu], à $donneesvehicule[aeroport]</td>");
                       echo("</tr>");
                    }
                    
                    $reponsepseudo->closeCursor();
                    
                    ?>
                
                </tbody>

            </table>
                
            </details>
            
        </div>
        
    </body>

</html>