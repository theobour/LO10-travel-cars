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
    var_dump(curl_getinfo($ch));
    curl_close($ch);
    if ($status_code === 200) {
        return true;
    } else {
        return false;
    }

}

?>