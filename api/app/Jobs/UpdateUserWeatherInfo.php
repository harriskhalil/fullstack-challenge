<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateUserWeatherInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $users = User::all();
            $weatherData = [];
            foreach ($users as $user) {
                $latitude = $user->latitude;
                $longitude = $user->longitude;
                $cachedData = Cache::get('weather-' . $latitude . '-' . $longitude);
                if ($cachedData) {
                    $cachedTimestamp = $cachedData['timestamp'];
                    if (time() - $cachedTimestamp < 3600) {
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
                    Log::info($e->getMessage());
                    abort(500, 'Failed to retrieve weather data: ' . $e->getMessage());
                }

                if ($response->failed()) {
                    Log::info('Failed to retrieve weather data.');
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
            Log::info($weatherData);
        }catch (\Exception $e){
            Log::info($e->getMessage());
        }
    }
}
