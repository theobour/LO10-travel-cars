<?php
include './api_call.php';

if ($_GET['example'] == 1) {
    $response = getAirport();
    echo 'Country : ' . $response->icao . '<br>';
    echo 'Lat : ' . $response->location->lat;
}
if ($_GET['example'] == 2) {
    $response = getExample();
    echo 'Type : ' . $response[0]->type;
}
if ($_GET['example'] == 3) {
    $response = createExample(array(
        'aeroport' => 'paris',
    ));
    if ($response) {
        echo 'Example crée';
    } else {
        echo 'Example pas crée';
    }
}
if ($_GET['example'] == 4) {
    $response = updateExample(0,array(
        'couleur' => 'rou',
    ));
    if ($response) {
        echo 'Example update';
    } else {
        echo 'Example pas update';
    }
}
