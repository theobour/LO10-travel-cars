<?php

// Création du compte : pseudo et mdp

$id_user = $_POST[id_user];
$mdp = $_POST[mdp];
$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
$email_user = $_POST[email_user];
$birthdate = $_POST[birthdate];
$telephone = $_POST[telephone];

// Démarrage de la session

session_start();

// Création des variables de session

$_SESSION[prenom] = ucfirst(strtolower($_POST[prenom]));
$_SESSION[nom_user] = ucfirst(strtolower($_POST[nom_user]));
$_SESSION[pseudo] = ($_POST[id_user]);

// Connexion BDD

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'CandiceAlcaraz32');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

                // Vérification que le pseudo est pas déjà utilisé

                    $req = $bdd->query('SELECT  COUNT(*) as verifpseudo FROM identifiant WHERE pseudo =\''. $id_user.'\'');

                    $donnees = $req->fetch();
                    $req->closeCursor();

                if ($donnees['verifpseudo'] == 1)
                    {
                        $_SESSION[inscription] = $_SESSION[pseudo];
                        header("Location: http://localhost:8888/projet_lo07/pages/inscription.php");

                    }

                else {

                        // Le pseudo est disponible et le mot de passe correspond
                       
                        $req = $bdd->prepare('INSERT INTO identifiant(pseudo, mdp, prenom, nom, email, birthdate, telephone) VALUES(:pseudo, :mdp, :prenom, :nom, :email, :birthdate, :telephone)');

                        // Création du compte

                        $req->execute(array(

                        'pseudo' => $id_user,

                        'mdp' => $mdp_hash,

                        'prenom' => $_SESSION[prenom],

                        'nom' => $_SESSION[nom_user],
                                
                        'email' => $email_user,
                            
                        'birthdate' => $birthdate,
                            
                        'telephone' => $telephone

                        )); 
                } 
                
                header("Location: http://localhost:8888/projet_lo07/pages/accueil.php");

            ?>
