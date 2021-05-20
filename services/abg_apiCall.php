<?php

// Functions

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
	    echo "Access token OK <hr>";
	    
	    return $authToken;

	}

	curl_close ($ch);
    
}

function getLocFromCity($oAuthToken, $city){

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://stage.abgapiservices.com/cars/locations/v1?brand=Avis%2CBudget%2CPayless&keyword='.$city);
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
	    $json = json_decode($result, true);
	    //var_dump($json);

	}

	$numberOfVehicules = sizeof($json['locations']);
	$initTable = 1;

	$tableLocCity[0] = $city;

	for ($i=0 ; $i<$numberOfVehicules ; $i++) {

		if ($json['locations'][$i]['address']['city'] == $city) {

				$tableLocCity[$initTable][0] = $json['locations'][$i]['brand'];
				$tableLocCity[$initTable][1] = $json['locations'][$i]['code'];
				$tableLocCity[$initTable][2] = $json['locations'][$i]['name'];
				$tableLocCity[$initTable][3] = $json['locations'][$i]['hours'];
				$tableLocCity[$initTable][4] = $json['locations'][$i]['address']['address_line_1'];
				$tableLocCity[$initTable][5] = $json['locations'][$i]['address']['postal_code'];
				$tableLocCity[$initTable][6] = $json['locations'][$i]['address']['country_code'];

				$initTable = $initTable +1;

		}
	}

	curl_close ($ch);
	return $tableLocCity;
	
}


function printLocFromCity($tableLocCity, $displayAllLoc) {

	$numberLocFromCity = sizeof($tableLocCity);
	$counter = 0;

	echo "VILLE DE RECHERCHE: " .$tableLocCity[0]. "<br/><br/>";

	for ($i=1 ; $i<$numberLocFromCity ; $i++) {

		$counter = $counter + 1;

		if ($displayAllLoc == false) {

			if ($counter < 5) {
						echo "Marque locataire : " .$tableLocCity[$i][0]. "</br>";
						echo "Code du véhicule : " .$tableLocCity[$i][1]. "</br>";
						echo "Secteur du parking : " .$tableLocCity[$i][2]. "</br>";
						echo "Disponibilités : " .$tableLocCity[$i][3]. "</br>";
						echo "Adresse de stationnement : " .$tableLocCity[$i][4]. "</br>";
						echo "Code postal : " .$tableLocCity[$i][5]. "</br>";
						echo "Adresse de stationnement : " .$tableLocCity[$i][6]. "</br></br>";
					}
		} else {

			echo "Marque locataire : " .$tableLocCity[$i][0]. "</br>";
			echo "Code du véhicule : " .$tableLocCity[$i][1]. "</br>";
			echo "Secteur du parking : " .$tableLocCity[$i][2]. "</br>";
			echo "Disponibilités : " .$tableLocCity[$i][3]. "</br>";
			echo "Adresse de stationnement : " .$tableLocCity[$i][4]. "</br>";
			echo "Code postal : " .$tableLocCity[$i][5]. "</br>";
			echo "Adresse de stationnement : " .$tableLocCity[$i][6]. "</br></br>";
		}

					
					
	}
			  
	 
	if (($counter >= 5) && ($displayAllLoc == false)) {
			echo "5 véhicule(s) affiché(s) sur les " .$counter. " trouvés.";
	} else {
			echo $counter. " véhicules trouvés";
	}

}

// Test appel des fonctions

$oAuthToken = getToken();
$city = "Paris";
$displayAllLoc = false;

printLocFromCity(getLocFromCity($oAuthToken, $city), $displayAllLoc);

?>

