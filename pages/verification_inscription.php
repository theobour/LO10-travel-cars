<?php
require_once('./api_call.php');
// Création du compte : pseudo et mdp


// Démarrage de la session

$url_to_redirect = "http://localhost:8890/project/LO10-travel-cars/pages";
// Création des variables de session
$mdp = $_POST["mdp"];
$email = $_POST["email"];
$naissance = $_POST["naissance"];
$telephone = $_POST["telephone"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$pseudo = $_POST['pseudo'];

// Connexion BDD

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=lo07;charset=utf8', 'root', 'root');
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Vérification que le pseudo est pas déjà utilisé
$creation = createUser(array(
    'prenom'=>$prenom,
    'nom'=>$nom,
    'email'=>$email,
    'naissance'=>$naissance,
    'telephone'=>$telephone,
    'pseudo'=>$pseudo,
    'mdp'=>$mdp
));
if ($creation) {
    $r = login($pseudo, $mdp);
    $_SESSION['prenom'] = $r->prenom;
    $_SESSION['nom_user'] = $r->nom;
    $_SESSION['pseudo'] = $r->pseudo;
    $_SESSION['id'] = $r->id;
    $_SESSION['auth'] = base64_encode($pseudo . ':' . $mdp);
    header('Location: ' . $url_to_redirect . '/accueil.php');
} else {
    header('Location: ' . $url_to_redirect . '/inscription.php');
}

            ?>
