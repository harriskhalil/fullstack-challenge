<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    function weather(){
        $users = User::all();
        $weatherData = [];

        foreach ($users as $user) {
            $latitude = $user->latitude;
            $longitude = $user->longitude;

            $cachedData = Cache::get('weather-' . $latitude . '-' . $longitude);
            if ($cachedData) {
                $cachedTimestamp = $cachedData['timestamp'];
                if (time() - $cachedTimestamp < 3600) { // check if cached data is less than 1 hour old
                    $weatherData[] = [
                        'user' => $user->toArray(),
                        'weather' => $cachedData['data'],
                    ];
                    continue;
                }
            }

            try {
                $response = Http::timeout(0.5)->get('https://api.openweathermap.org/data/2.5/weather', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => env('OPENWEATHERMAP_API_KEY'),
                    'units' => 'metric',
                ]);
            } catch (\Illuminate\Http\Client\RequestException $e) {
                abort(500, 'Failed to retrieve weather data: ' . $e->getMessage());
            }

            if ($response->failed()) {
                abort(500, 'Failed to retrieve weather data.');
            }

            $weatherData[] = [
                'user' => $user->toArray(),
                'weather' => $response->json(),
            ];
            Cache::put('weather-' . $latitude . '-' . $longitude, [
                'data' => $response->json(),
                'timestamp' => time()
            ], now()->addHour());
        }

        $formattedData = [];

        foreach ($weatherData as $data) {
            $formattedData[] = [
                'user' => $data['user'],
                'location' => $data['weather']['name'],
                'description' => $data['weather']['weather'][0]['description'],
                'temperature' => $data['weather']['main']['temp'],
            ];
        }

        return $formattedData;

    }
}
