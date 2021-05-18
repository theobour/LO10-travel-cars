<?php
include './service_api.php';
$url = "http://localhost:8890/project/LO10-backend/api";
$aero_api_key = "cf959a75a1mshc009859d88b3b2bp115f37jsnf4e5f8304eea";
$aero_url = "https://aerodatabox.p.rapidapi.com";

function getExample()
{
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/example.php', false);
    if ($status_code === 200) {
        var_dump(json_decode($response));
    } else {
        echo 'Erreur dans le GET';
    }
    curl_close($ch);
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
    echo 'Country : ' . $response->icao . '<br>';
    echo 'Lat : ' . $response->location->lat;
    curl_close($ch);
}

function createExample()
{
    GLOBAL $url;
    //The JSON data.
    $jsonData = array(
        'aeroport' => 'MyUsername',
    );
    list($response, $status_code, $ch) = initPost($url . '/example.php', $jsonData);
    if ($status_code === 201) {
        var_dump($response);
    } else {
        echo 'Erreur dans le POST';
    }
    curl_close($ch);
}
function updateExample($id)
{
    GLOBAL $url;
    //The JSON data.
    $jsonData = array(
        'couleur' => 'rouge',
    );
    list($response, $status_code, $ch) = initPut($url . '/example.php?id=' . $id, $jsonData);
    var_dump(curl_getinfo($ch));
    if ($status_code === 200) {
        var_dump($response);
    } else {
        echo 'Erreur dans le PUT';
    }
    curl_close($ch);
}

getAirport();
?>