<?php

// Démarrage session + connexion BDD

session_start();
unset ($_SESSION['pseudo']);

// Récupération du pseudo de l'utilisateur

$pseudo = $_POST['id_user'];

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        //die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT pseudo, nom, prenom FROM identifiant WHERE pseudo =\''. $pseudo.'\'');

$donnees = $reponse->fetch();

// Création des variables de session
$_SESSION['prenom'] = ucfirst(strtolower($donnees[prenom]));
$_SESSION['nom_user'] = ucfirst(strtolower($donnees[nom]));
$_SESSION['pseudo'] = $donnees[pseudo];
$_SESSION['connection'] = "non";


                $req = $bdd->prepare('SELECT pseudo, mdp FROM identifiant WHERE pseudo = :pseudo');

                $req->execute(array(

                    'pseudo' => $pseudo));
                

                    $resultat = $req->fetch();

                // Comparaison du pass envoyé via le formulaire avec la base

                $isPasswordCorrect = password_verify($_POST['mdp'], $resultat['mdp']);


                if (!$resultat)

                {
                        $_SESSION[connection] = "non";
                        
                        header('Location: http://localhost:8888/projet_lo07/pages/connection.php');
                        exit();
                        
                }

                else

                {

					
                    if ($isPasswordCorrect == FALSE) {
                        
                        
                        $_SESSION[connection] = "non";
                        header('Location: http://localhost:8888/projet_lo07/pages/connection.php');
                        exit();

                    }

                    else {
                    
                        $_SESSION[pseudo] = $pseudo;
                        unset($_SESSION['connection']);
                        header('Location: http://localhost:8888/projet_lo07/pages/accueil.php');
                        exit();
                        

                    }

                }

        ?>