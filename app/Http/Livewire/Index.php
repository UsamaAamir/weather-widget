<?php

namespace App\Http\Livewire;

use App\Services\WeatherWidgetService;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

use Stevebauman\Location\Facades\Location;

class Index extends Component
{
    public string $weatherApiHit = "";
    public string $baseUrl = "api.openweathermap.org/data/2.5/weather";
    public string $endpoint = "&appid=";
    public $search = [
        'lat' => null,
        'lng' => null
    ];
    public $weatherDetails = null;
    protected $listeners = [
        'set-place'      => 'setPlace',
       
    ];

    public function mount()
    {
        $apiKey = env('OPEN_WEATHER_API', null);
        $this->endpoint .= $apiKey . '&units=metric';
        $this->getWeatherDetails();
    }
    public function render()
    {
        return view('livewire.index');
    }

    public function getWeatherDetails()
    {
        try {
        // calling the weather API with longitute and latitude of the selected location
        $service = new WeatherWidgetService();
        $this->weatherDetails = $service->getWeatherDetails($this->search["lat"],$this->search['lng']);
        } catch (\Throwable $th) {
            $this->emit('error-message');
        }
    }
    public function setPlace($place)
    {
        $this->search = $place ? 
        $place["geometry"]["location"] :
        [
            'lat' => null,
            'lng' => null
        ]; 
        $this->getWeatherDetails();
    }
    
}
