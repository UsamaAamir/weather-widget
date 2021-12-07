<div>

    <body oncontextmenu='return false' class='snippet-body'>
        <div class="container-fluid px-1 px-sm-3 py-5 mx-auto">
            <div class="row d-flex justify-content-center">
                <div class="row card0">
                    <div class="card1 col-lg-8 col-md-7"> <small>Weather Widget</small>
                        <div class="text-center"> <img class="image mt-5" src="{{ asset('/img/baloon.png') }}"> </div>
                        <div class="row px-3 mt-3 mb-3">
                            <h1 class="large-font mr-3">{{ isset($weatherDetails['main']['temp']) ? $weatherDetails['main']['temp'] :0
                                }}<span>&#8451;</span> </h1>
                            <div class="d-flex flex-column mr-3">
                                <h2 class="mt-3 mb-0">{{ isset($weatherDetails["name"]) ? $weatherDetails["name"] : "Search Some thing" }}
                                </h2> 
                            </div>
                            <div class="d-flex flex-column text-center">
                                <img src="http://openweathermap.org/img/w/{{isset($weatherDetails[" weather"][0]) ?
                                    $weatherDetails["weather"][0]['icon'].'.png' : '50n.png' }}" class="mt-1">
                                <small>{{ isset($weatherDetails["weather"][0]) ?$weatherDetails["weather"][0]["main"] : "" }}</small>
                            </div>
                        </div>
                    </div>
                    <div id="map" class="card2 col-lg-4 col-md-5">
                        <div class="row w-full">
                            <input type="text" id="location" name="location" 
                                placeholder="Another location" class="mb-5">
                        </div>
                        <div class="mr-5">

                            <i wire:loading wire:target="setPlace"
                                class="fa fa-spinner fa-spin  text-base"></i>

                            <p>Weather Details</p>
                            <div class="row px-3">
                                <p class="light-text">Feels Like</p>
                                <p class="ml-auto">{{ isset($weatherDetails['main']['feels_like']) ? $weatherDetails['main']['feels_like'] :
                                    "0" }}
                                    <span>&#8451;</span>
                                </p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Temp Min</p>
                                <p class="ml-auto">{{ isset($weatherDetails['main']['temp_min']) ? $weatherDetails['main']['temp_min'] : "0"
                                    }}
                                    <span>&#8451;</span>
                                </p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Temp Max</p>
                                <p class="ml-auto">{{ isset($weatherDetails['main']['temp_max']) ? $weatherDetails['main']['temp_max'] : "0"
                                    }}
                                    <span>&#8451;</span>
                                </p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Pressure</p>
                                <p class="ml-auto">{{ isset($weatherDetails['main']['pressure']) ? $weatherDetails['main']['pressure'] : "0"
                                    }} hPa
                                </p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Cloudy</p>
                                <p class="ml-auto">{{ isset($weatherDetails['clouds']['all']) ? $weatherDetails['clouds']['all'] : "0" }} %
                                </p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Humidity</p>
                                <p class="ml-auto">{{ isset($weatherDetails["main"]["humidity"]) ? $weatherDetails["main"]["humidity"] : 0
                                    }} %</p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Wind</p>
                                <p class="ml-auto">{{ isset($weatherDetails['wind']['speed']) ? $weatherDetails['wind']['speed'] : "0"
                                    }} m/s</p>
                            </div>
                            <div class="row px-3">
                                <p class="light-text">Wind Direction</p>
                                <p class="ml-auto">{{ isset($weatherDetails['wind']['deg']) ? $weatherDetails['wind']['deg'] : "0"
                                    }}&#176; </p>
                            </div>
                            <div class="row px-3">
                                {{-- <p class="light-text">Rain</p>
                                <p class="ml-auto">0mm</p> --}}
                            </div>
                            <div class="line mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@push('javascript')
<script>
    function initializeMap() {
    // intialize input to be used as google autocomplete
      var input = document.getElementById('location');
      var autocomplete = new google.maps.places.Autocomplete(input,{types: ['(cities)']});
      //listen for change in selected city
      google.maps.event.addListener(autocomplete, 'place_changed', function(){
         var place = autocomplete.getPlace();
         // emit a backend event to get weather data for the newly selected city
        livewire.emit('set-place', place)
      })
    }
</script>

@endpush