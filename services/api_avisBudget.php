<?php

// Functions

// ---------------- GET ACCESS TOKEN ------------------------

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

	    return $authToken;

	}

	curl_close ($ch);

}

// ---------------- GET LOCATIONS FROM CITY ------------------------

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

// ---------------- GET LOCATIONS FROM DATES ------------------------

function getLocFromInfos($oAuthToken, $arrayInputs){

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://stage.abgapiservices.com:443/cars/catalog/v1/vehicles?brand=Avis&pickup_date=' .$arrayInputs[0]. '&pickup_location=' .$arrayInputs[1]. '&dropoff_date=' .$arrayInputs[2]. '&dropoff_location=' .$arrayInputs[3]. '&country_code=' .$arrayInputs[4]);

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

	$numberOfLoc = sizeof($json['vehicles']);
	$initTable = 0;

	for ($i=0 ; $i<$numberOfLoc ; $i++) {

				$tableLoc[$initTable][0] = $json['vehicles'][$i]['category']['name'];
				$tableLoc[$initTable][1] = $json['vehicles'][$i]['category']['model'];
				$tableLoc[$initTable][2] = $json['vehicles'][$i]['category']['vehicle_class_name'];
				$tableLoc[$initTable][3] = $json['vehicles'][$i]['capacity']['seats'];
				$tableLoc[$initTable][4] = $json['vehicles'][$i]['rate_totals']['pay_later']['vehicle_total'];
				$tableLoc[$initTable][5] = $json['vehicles'][$i]['rate_totals']['pay_later']['reservation_total'];

				$initTable = $initTable + 1;

	}

	curl_close ($ch);

	return $tableLoc;

}

// ---------------- PRINT LOCATIONS FROM DATES ------------------------

function printLocFromInfos($tableLoc) {

	$numberLoc = sizeof($tableLoc);

	for ($i=0 ; $i<$numberLoc ; $i++) {

						echo "Type du véhicule : " .$tableLoc[$i][0]. "</br>";
						echo "Modèle du véhicule : " .$tableLoc[$i][1]. "</br>";
						echo "Classe : " .$tableLoc[$i][2]. "</br>";
						echo "Nombre de places : " .$tableLoc[$i][3]. "</br>";
						echo "Prix de la réservation HT (hors frais de services) : " .$tableLoc[$i][4]. "</br>";
						echo "Prix de la réservation TTC : " .$tableLoc[$i][5]. "</br><br/>";

	}

}

// ---------------- PRINT LOCATIONS FROM CITY ------------------------

function printLocFromCity($tableLocCity, $displayAllLoc) {

	$numberLocFromCity = sizeof($tableLocCity);
	$counter = 0;

  echo "<div id=\"resultat_reservation\"> <h2>Les véhicules disponibles sur AVIS :</h2>";

	for ($i=1 ; $i<$numberLocFromCity ; $i++) {

		$counter = $counter + 1;

		if ($displayAllLoc == false) {

			if ($counter < 6) {
            echo("<div id=liste_reservation>");
						echo "<strong>Marque locataire : </strong>" .$tableLocCity[$i][0]. "</br>";
						echo "<strong>Code du véhicule : </strong>" .$tableLocCity[$i][1]. "</br>";
						echo "<strong>Secteur du parking : </strong>" .$tableLocCity[$i][2]. "</br>";
						echo "<strong>Disponibilités : </strong>" .$tableLocCity[$i][3]. "</br>";
						echo "<strong>Adresse de stationnement : </strong>" .$tableLocCity[$i][4]. "</br>";
            echo("</div>");
					}
		} 

	}


	if (($counter < 6) && ($displayAllLoc == false)) {
			echo "5 véhicule(s) affiché(s) sur les " .$counter. " trouvés.";
      echo("</div>");
	} else {
			echo $counter. " véhicules trouvés";
      echo("</div>");
	}

}

// ---------------- DEF DES VARIABLES ------------------------

$arrayInputs = array("2021-05-30T00%3A00%3A00", "EWR", "2021-12-31T00%3A00%3A00", "EWR", "US");

?>
