<?php

// ------- Init des variables csv -------- //

function init_localisation(){
	$parking_file = file('https://static.data.gouv.fr/resources/base-nationale-des-lieux-de-stationnement/20210502-172910/bnls-2-.csv');
	foreach($parking_file as $line) //On sépare chaque ligne du tableau
		$csv[]=explode(';',$line);
	$removed = array_shift($csv);
	return $csv;
}

		
		
// -------- fonction de parsage ------- //

function get_localisation(){
	
	$csv_parking = init_localisation();
	$localisationParking = array();
	$i = 1;
	foreach($csv_parking as $line){
		if($i < 700){
			$i++;
			array_push($localisationParking,[
			"nom" => $line[1],
			"adresse" => $line[3],
			"url" => $line[4],
			"nbPlace" => $line[7],
			"Long" => $line[18], 
			"Lat" => $line[19],
			"Prix1H" => $line[21],
			"Prix2H" => $line[22],
			"Prix3H" => $line[23],
			"Prix4H" => $line[24],
			"Prix24H" => $line[25],
			
			]);
		}
	}
		
	return $localisationParking;
}


// ------- test des fonctions ------- //
//$result = get_localisation();

//var_dump($result);

?>
