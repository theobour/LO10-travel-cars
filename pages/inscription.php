<?php

//Démarrage de la session
session_start();

?>

<html>
    
    <head>
        
        <meta charset="UTF-8">
        <title>TravelCars - Inscription</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">
        
    </head>
    
    <body>
        
        <div class="container" id="body_inscription">
            
            <div class="row" id="menu">
                <div class="col-sm-2"><strong><a href=index.php>TravelCars</a></strong></div>
                <div class="col-sm-7"></div>
                <div class="col-sm-2"><center><a href="connection.php" >Se connecter</a></center></div>
                <div class="col-sm-1"><center><a href="inscription.php">S'inscrire</a></center></div>
            </div>
            
            <!-- Formulaire pour l'inscription de l'utilisateur -->
            
            <form action="verification_inscription.php" method="post">

                <div>

                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" placeholder="Martin" required>

                </div>
                
                <div>

                    <label for="nom_user">Nom :</label>
                    <input type="text" name="nom" placeholder="Roquet" required>

                </div>
                
                <?php
                    
                // Message d'erreur si le pseudo est déjà utilisé
                if (isset($_SESSION['inscription'])) {
                
                echo("<p id=message_alerte >Le pseudo $_SESSION[inscription] est déjà utilisé.</p>");
                
                }
                
                ?>
                
                <div>

                    <label for="id_user">Pseudoynyme :</label>
                    <input type="text" name="pseudo" placeholder="Identifiant" required>

                </div>
                
                <div>

                    <label for="mdp">Mot de passe :</label>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>

                </div>
                
                <div>

                    <label for="email">Email :</label>
                    <input type="email" name="email" placeholder="michel.roquet@gmail.com" size="15">

                </div>
                
                <div>

                    <label for="birthdate">Date de naissance :</label>
                    <input type="date" name="naissance" >

                </div>
                
                <div>

                    <label for="telephone">Téléphone :</label>
                    <input type="tel" name="telephone" placeholder="06 59 14 48 67" size="9">

                </div>
                
                <button type="submit" >S'inscrire</button>

            </form>
            
            <!-- Si déjà inscrit -->
            
            <p>Déjà inscrit ? <a href="connection.php" >Connectez-vous</a></p>
            
            <div class="row" id="footer_connexion">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
        
        </div>
        
    </body>
    
</html>

