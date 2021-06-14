<?php

class Trafic {

    private static $instance;

    private $date;
    private $xml;
    private $csv;

    public static function getInstance() {
        if (Trafic::$instance == null) return new Trafic();
        else return Trafic::$instance;
    }

    private function __construct() {
        $this->date = $this->getData("https://diffusion-numerique.info-routiere.gouv.fr/publication/grt/ACTION-B/TraficDir/date.txt");
        $this->xml = $this->getdata("https://diffusion-numerique.info-routiere.gouv.fr/publication/grt/ACTION-B/TraficDir/qtvDir.xml");
        $this->csv = $this->getData("https://diffusion-numerique.info-routiere.gouv.fr/publication/grt/ACTION-B/TraficDir/refDir.csv");

        Trafic::$instance = $this;
    }

    private function getData($url) {
        $curl = curl_init();

        // UNIQUEMENT POUR LE PROJET
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ZGlmZnVzaW9uLXB1Yjppa2k3YWhWNw=='
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function idFromAxe($axe) {
        if (is_null($axe)) {
            return array();
        }
        $id = array();
        $csv_array = $this->convertCsv();
        foreach ($csv_array as $data) {
            if ($data["axe"] == $axe) {
                array_push($id, $data["code_pme"]);
            }
        }
        return $id;
    }

    public function data($id) {
        $xml = new SimpleXMLElement($this->xml());
        $flow = null;
        $speed = null;
        foreach($xml->payloadPublication->siteMeasurements as $measure) {
            if ($measure->measurementSiteReference->attributes()['id'] == $id) {
                $flow = $measure->measuredValue[0]->measuredValue->basicData->vehicleFlow->vehicleFlowRate;
                $speed = $measure->measuredValue[1]->measuredValue->basicData->averageVehicleSpeed->speed;
                break;
            }
        }

        return is_null($flow) && is_null($speed) ? null : ["flow" => $flow, "speed" => $speed];
    }

    public function convertCsv() {
        $array = str_getcsv($this->csv(),";");
        for($i = 18; $i < count($array); $i += 19) {
            $pos = strpos($array[$i],"\n");

            $a = substr($array[$i],0 , $pos);
            $b = str_replace("\n","",substr($array[$i], $pos));

            $array[$i] = $a;
            array_splice($array, $i + 1, 0, $b);
        }

        $retour = [];
        $i = 19;
        while ($i < count($array) - 19) {
            array_push($retour, array());
            for ($j = 0; $j < 19; $j++) {
                $retour[($i / 19) - 1] += ["$array[$j]" => $array[$i + $j]];
            }
            $i += 19;
        }
        return $retour;
    }

    public function date() {
        return $this->date;
    }

    public function xml() {
        return $this->xml;
    }

    public function csv() {
        return $this->csv;
    }
}
