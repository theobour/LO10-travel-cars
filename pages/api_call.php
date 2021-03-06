<?php
include './service_api.php';
$url = "http://localhost:8888/project/LO10-backend/api";
$aero_api_key = "cf959a75a1mshc009859d88b3b2bp115f37jsnf4e5f8304eea";
$aero_url = "https://aerodatabox.p.rapidapi.com";


function getAirport()
{
    GLOBAL $aero_url;
    GLOBAL $aero_api_key;
    list($response, $status_code, $ch) = initGet($aero_url . '/airports/iata/LHR', array('x-rapidapi-key : ' . $aero_api_key));
    $response = json_decode($response);
    if ($status_code === 200) {
        var_dump($response);
    } else {
        echo 'Erreur dans le GET';
    }
    curl_close($ch);
    return $response;
}
function getAeroport() {
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/aeroport.php', false, true);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return'Erreur dans le GET';
    }
}
function login($pseudo, $password) {
    GLOBAL $url;
    //The JSON data.
    $jsonData = array(
        "pseudo" => $pseudo,
        "password" => $password
    );
    list($response, $status_code, $ch) = initPost($url . '/auth.php', $jsonData, false);
    curl_close($ch);
    if ($status_code === 201) {
        return json_decode($response);
    } else {
        return false;
    }
}

function getLocation($aerport_id, $date_debut,$date_fin) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/location.php?aeroport_id=' . $aerport_id . '&date_debut=' . $date_debut . '&date_fin=' . $date_fin, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getOneVoiture($voiture_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/voiture.php?id=' . $voiture_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function deleteVoiture($voiture_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initDelete($url . '/voiture.php?id=' . $voiture_id, true);
    curl_close($ch);

    if ($status_code === 200) {
        return true;
    } else {
        return false;
    }
}
function getVoitureFromUtilisateur($utilisateur_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/voiture.php?utilisateur_id=' . $utilisateur_id, false, true);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getOneParking($parking_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/parking.php?id=' . $parking_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getOneUser($user_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/auth.php?id=' . $user_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getUsers() {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/auth.php', false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function updateUserProfile($id, $jsonData)
{
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPut($url . '/auth.php?id=' . $id, $jsonData, true);
    curl_close($ch);
    if ($status_code === 200) {
        return true;
    } else {
        return false;
    }

}

function createReservation($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/reservation.php', $jsonData, true);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}
function createLocation($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/location.php', $jsonData, false);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}
function getReservationFromLocataire($locataire_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/reservation.php?locataire_id=' . $locataire_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getLocationFromUtilisateur($utilisateur_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/location.php?utilisateur_id=' . $utilisateur_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getParkingOfOneAeroport($aeroport_id) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/parking.php?aeroport_id=' . $aeroport_id, false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}
function getParkings() {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initGet($url . '/parking.php', false, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}

function createAeroport($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/aeroport.php', $jsonData, true);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}
function createParking($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/parking.php', $jsonData, true);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}

function createUser($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/signin.php', $jsonData, false);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}
function createVoiture($jsonData) {
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/voiture.php', $jsonData, true);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}


?>