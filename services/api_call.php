<?php
include './service_api.php';
$url = "http://localhost:8890/project/LO10-backend/api";

function getExample()
{
    GLOBAL $url;
    list($response, $status_code, $ch) = initGet($url . '/example.php');
    if ($status_code === 200) {
        var_dump(json_decode($response));
    } else {
        echo 'Erreur dans le GET';
    }
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

getExample();
updateExample(0);
?>