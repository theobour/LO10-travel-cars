<?php

function getToken(){
    
    $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://stage.abgapiservices.com/oauth/token/v1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Client_id: 8e16ee49';
$headers[] = 'Client_secret: ddeadd4f39083c85ed94afbdeb1c08af';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else
{
    $json = json_decode($result);
    $authToken = $json->access_token;
    print_r($json->access_token);
    
    return $authToken;

}
curl_close ($ch);
    
}

$oAuthToken = getToken();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://stage.abgapiservices.com/cars/locations/v1?brand=Avis%2CBudget%2CPayless&keyword=Denver');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Client_id: 8e16ee49';
$headers[] = 'Authorization: Bearer '  . $oAuthToken ;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else
{
    $json = json_decode($result);
    print_r($json);

}
curl_close ($ch);

?>

