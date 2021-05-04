<?php

// Démarrage de la session, pas besoin de se connecter à la BDD.
session_start();
//$_SESSION[connection] = "non";

?>

<html>
    
    <head>
        
        <meta charset="UTF-8">
        <title>TravelCars - Connection</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/style_perso.css?t=<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC" rel="stylesheet">
        
    </head>
    
    <body>
        
        <div class="container" id="body_connection">
            
            <div class="row" id="menu">
                <div class="col-sm-2"><strong><a href=index.php>TravelCars</a></strong></div>
                <div class="col-sm-7"></div>
                <div class="col-sm-2"><center><a href="connection.php" >Se connecter</a></center></div>
                <div class="col-sm-1"><center><a href="inscription.php">S'inscrire</a></center></div>
            </div>
            
            <center><form action="verification_id.php" method="post">

                <div>

                    <label for="id_user">Identifiant ?</label>
                    <input type="text" name="id_user" placeholder="Identifiant" required>

                </div>
                
                <div>

                    <label for="mdp">Mot de passe ?</label>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>

                </div>
                    
                <?php
                  
                // Si le mot de passe ou l'identifiant est/ sont incorrect(s)
                if (isset($_SESSION['connection'])) {
                
                echo("<p id=\"message_alerte\" >Mauvais identifiant ou mot de passe, réessaye.</p>");
                
                }
                
                ?>
                    
                <p>Tu n'as pas de compte ? <a href=inscription.php>Inscris-toi !</a></p>
                
                <button type="submit" >Se connecter</button>

            </form></center>
            
            <div class="row" id="footer_connexion">
                <div class="col-sm-12"><a href="credit.php">Plus d'informations</a></div>
            </div>
            
        </div>
        
    </body>
    
</html>

