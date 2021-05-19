<?php
session_start();
?>
<html>

<head>

    <meta charset="UTF-8">
    <title>TravelCars - Création voiture</title>
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
    <h3>Enregistrer un nouveau véhicule :</h3>

    <!-- Si pas de véhicule enregistré ou un nouveau, il le crée ici -->

    <div id="new_vehicule">

        <form action="finalisation_creation_voiture.php" method="post">

            <fieldset>

                <div class='form-group'>

                    <label for="type_voiture">Type de voiture :</label>

                    <select name="type" required class='form-control'>
                        <option value="Berline">Berline / Coupé</option>
                        <option value="Familiale">Familiale / Monospace</option>
                        <option value="Pickup">Pickup</option>
                        <option value="Crossover">Crossover</option>
                        <option value="SUV">SUV</option>
                        <option value="Citadine">Citadines & mini-citadines</option>
                        <option value="Autre">Autre</option>
                    </select>

                </div>

                <div class='form-group'>

                    <label for="couleur">Couleur de la voiture :</label>
                    <input list="couleurs" name="couleur" required class='form-control'>
                    <datalist id="couleurs">
                        <option value="Argentée">Argentée</option>
                        <option value="Autre">Autre</option>
                        <option value="Beige">Beige</option>
                        <option value="Blanche">Blanche</option>
                        <option value="Bleue">Bleue</option>
                        <option value="Dorée">Dorée</option>
                        <option value="Grise">Grise</option>
                        <option value="Jaune">Jaune</option>
                        <option value="Marron">Marron</option>
                        <option value="Noire">Noire</option>
                        <option value="Orange">Orange</option>
                        <option value="Rose">Rose</option>
                        <option value="Rouge">Rouge</option>
                        <option value="Turquoise">Turquoise</option>
                        <option value="Verte">Verte</option>
                        <option value="Violette">Violette</option>
                    </datalist>

                </div>

                <div class='form-group'>

                    <label for="marque_voiture">Marque de la voiture :</label>
                    <input list="marques" name="marque" required class='form-control'>
                    <datalist id="marques">
                        <option value="Audi">Audi</option>
                        <option value="BMW">BMW</option>
                        <option value="Citroen">Citroën</option>
                        <option value="Dacia">Dacia</option>
                        <option value="Fiat">Fiat</option>
                        <option value="Ford">Ford</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Kia">Kia</option>
                        <option value="Mercedes">Mercedes</option>
                        <option value="Mini">Mini</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Opel">Opel</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Renault">Renault</option>
                        <option value="Skoda">Skoda</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Volkswagen">Volkswagen</option>
                        <option value="Volvo">Volvo</option>
                        <option value="Autre">Autre</option>
                    </datalist>

                </div>

                <div class='form-group'>

                    <label for="nb_place">Nombre de places dans la voiture :</label>

                    <select multiple class='form-control' name='nb_place' size='5' required>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6 et plus'>6 et plus</option>
                    </select>

                </div>

                <div class='form-group'>

                    <label for="etat">Etat de la voiture :</label>

                    <select name="etat" required class='form-control'>
                        <option value="Neuve">Neuve</option>
                        <option value="Très Bon">Très bon état</option>
                        <option value="Bon">Bon état</option>
                        <option value="Correct">Etat correct</option>
                        <option value="Passable">Etat passable</option>
                    </select>

                </div>

            </fieldset>
            <input type="hidden" name="proprietaire_id" value="<?php echo $_SESSION["id"]; ?>">

            <button type="submit">Créer la voiture</button>

        </form>
    </div>
</div>
</body>
</html>