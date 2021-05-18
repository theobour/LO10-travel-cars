<?php
include './service_api.php';
$url = "http://localhost:8890/project/LO10-backend/api";
$aero_api_key = "cf959a75a1mshc009859d88b3b2bp115f37jsnf4e5f8304eea";
$aero_url = "https://aerodatabox.p.rapidapi.com";

function getExample()
{
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/example.php', false);
    $response = json_decode($response);
    if ($status_code === 200) {
        var_dump($response);
    } else {
        echo 'Erreur dans le GET';
    }
    curl_close($ch);
    return $response;
}

function getVehicule()
{
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/example.php', false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return'Erreur dans le GET';
    }
}

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

function createExample($jsonData)
{
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPost($url . '/example.php', $jsonData);
    curl_close($ch);
    if ($status_code === 201) {
        return true;
    } else {
        return false;
    }
}
function updateExample($id, $jsonData)
{
    GLOBAL $url;
    //The JSON data.
    list($response, $status_code, $ch) = initPut($url . '/example.php?id=' . $id, $jsonData);

    curl_close($ch);
    if ($status_code === 200) {
        return true;
    } else {
        return false;
    }

}
function getAeroport() {
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/aeroport.php', false);
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
    list($response, $status_code, $ch) = initPost($url . '/auth.php', $jsonData);
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
    list($response, $status_code, $ch) = initGet($url . '/location.php?aeroport_id=' . $aerport_id . '&date_debut=' . $date_debut . '&date_fin=' . $date_fin, false);
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
    list($response, $status_code, $ch) = initGet($url . '/voiture.php?id=' . $voiture_id, false);
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
    list($response, $status_code, $ch) = initDelete($url . '/voiture.php?id=' . $voiture_id);
    var_dump(curl_getinfo($ch));
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
    list($response, $status_code, $ch) = initGet($url . '/voiture.php?utilisateur_id=' . $utilisateur_id, false);
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
    list($response, $status_code, $ch) = initGet($url . '/parking.php?id=' . $parking_id, false);
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
    list($response, $status_code, $ch) = initGet($url . '/auth.php?id=' . $user_id, false);
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
    list($response, $status_code, $ch) = initPut($url . '/auth.php?id=' . $id, $jsonData);
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
    list($response, $status_code, $ch) = initPost($url . '/reservation.php', $jsonData);
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
    list($response, $status_code, $ch) = initPost($url . '/location.php', $jsonData);
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
    list($response, $status_code, $ch) = initGet($url . '/reservation.php?locataire_id=' . $locataire_id, false);
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
    list($response, $status_code, $ch) = initGet($url . '/location.php?utilisateur_id=' . $utilisateur_id, false);
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
    list($response, $status_code, $ch) = initGet($url . '/parking.php?aeroport_id=' . $aeroport_id, false);
    curl_close($ch);
    if ($status_code === 200) {
        return json_decode($response);
    } else {
        return false;
    }
}


?>