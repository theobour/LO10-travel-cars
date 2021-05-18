<?php
include './api_call.php';

if ($_GET['example'] == 1) {
    $response = getAirport();
    echo 'Country : ' . $response->icao . '<br>';
    echo 'Lat : ' . $response->location->lat;
}
if ($_GET['example'] == 2) {
    $response = getVehicule();
    echo 'Type : ' . $response[0]->type;
}
if ($_GET['example'] == 3) {
    $response = createExample(array(
        'aeroport' => 'Roissyy',
    ));
    if ($response) {
        echo 'Example crée';
    } else {
        echo 'Example pas crée';
    }
}
if ($_GET['example'] == 4) {
    $response = updateExample(0,array(
        'couleur' => 'rouge',
    ));
    if ($response) {
        echo 'Example update';
    } else {
        echo 'Example pas update';
    }
}
