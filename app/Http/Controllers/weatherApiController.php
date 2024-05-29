<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class weatherApiController extends Controller
{
    public function getWeatherData(Request $request)
    {
        $weatherDataPath = base_path('Cache/weatherApi/weather.json');
        if (file_exists($weatherDataPath)) {
            return Inertia::render('weather', ['weatherData' => json_decode(file_get_contents($weatherDataPath))]);
        }
        $apiKey = getenv('OPEN_WEATHER_API_KEY');
        $response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=58.2&lon=22.5&appid={$apiKey}&units=metric");
        file_put_contents($weatherDataPath, $response);
        return Inertia::render('weather', ['weatherData' => json_decode(file_get_contents($weatherDataPath))]);
    }
}
