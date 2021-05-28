<?php

function initGet($url, $header, $auth)
{
    // configuration des options
    $ch = curl_init();
    if ($header !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    if ($auth !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, "Authorization : Basic " . $_SESSION["auth"]);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [$response, $status_code, $ch];
}

function initPost($url, $jsonData, $auth)
{
    $ch = curl_init($url);
//Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);
//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if ($auth !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, "Authorization : Basic " . $_SESSION["auth"]);
    }
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Execute the request
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [$response, $status_code, $ch];
}

function initPut($url, $jsonData, $auth)
{
    $ch = curl_init($url);
//Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);
//Tell cURL that we want to send a PUT request.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if ($auth !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, "Authorization : Basic " . $_SESSION["auth"]);
    }
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Execute the request
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [$response, $status_code, $ch];
}

function initDelete($url, $auth)
{
    $ch = curl_init($url);
//Encode the array into JSON.
//Tell cURL that we want to send a DELETE request.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    if ($auth !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, "Authorization : Basic " . $_SESSION["auth"]);
    }
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Execute the request
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [$response, $status_code, $ch];
}
