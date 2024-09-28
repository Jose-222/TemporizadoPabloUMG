<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather extends CI_Controller {

    public function get_temperature() {
        $city = 'Guatemala'; 
        $apiKey = '147e9f007e7e858e36eff7be94bb4425'; 
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$apiKey}";

        // Realizar la llamada a la API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decodifica JSON
        $data = json_decode($response, true);

        // Revisar si la respuesta es correcta
        if ($data && $data['cod'] == 200) {
            $temperature = $data['main']['temp']; // Obtener la temperatura
            echo json_encode(['temperature' => $temperature]);
        } else {
            echo json_encode(['error' => 'No se pudo obtener la temperatura']);
        }
    }
}