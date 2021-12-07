<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class WeatherWidgetService
{
    public $baseUrl="api.openweathermap.org/data/2.5/weather";
    public function getWeatherDetails($lat = null ,$lon = null)
    {
        $data=[];
        $endpoint = "&appid=".env('OPEN_WEATHER_API', null); 
        $locData = $this->getLocationPoints($lat , $lon);
       if(isset($locData["lat"]) && isset($locData["lon"]))
       {   
            $apiUrl = $this->baseUrl."?lat=".$locData["lat"].'&lon='.$locData["lon"].$endpoint.'&units=metric';
            $response = Http::get($apiUrl);
            $data= json_decode($response->body(), true);
       }
       return $data;
    }

    private function getLocationPoints($lat, $lon)
    {
        $locData=[
            "lat" => $lat,
            "lon" =>  $lon,
        ]; 
        if(is_null($lat) || is_null($lon))
        {
            $ip = request()->ip(); 
            $currentLocData = Location::get($ip);
            // try to get location from request IP
            if($currentLocData)
            {
                $locData=[
                    "lat" => $currentLocData->latitude,
                    "lon" =>  $currentLocData->longitude
                ]; 
                return $locData;
            }
            // if localhost get location from external source
            $currentLocData = @unserialize (file_get_contents('http://ip-api.com/php/'));
            if($currentLocData && $currentLocData["status"] == "success")
            {
                $locData=[
                    "lat" => $currentLocData["lat"],
                    "lon" =>  $currentLocData["lon"]
                ]; 
            }
        }
        return $locData;
    }
   
}
