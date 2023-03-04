<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    function weather(){
        try {
            $users = User::all();
            $weatherData = [];
            foreach ($users as $user) {
                $latitude = $user->latitude;
                $longitude = $user->longitude;
                $cachedData = Cache::get('weather-' . $latitude . '-' . $longitude);
                $weatherData[] = [
                    'user' => $user->toArray(),
                    'weather' => $cachedData['data'],
                ];

            }

            $formattedData = [];
            foreach ($weatherData as $data) {
                $formattedData []= [
                    'id' => $data['user']['id'],
                    'name' => $data['user']['name'],
                    'email' => $data['user']['email'],
                    'latitude' => $data['user']['latitude'],
                    'longitude' => $data['user']['longitude'],
                    'description' => $data['weather']['weather'][0]['description'],
                    'location' => $data['weather']['name'],
                    'temperature' => $data['weather']['main']['temp'],
                    'user_weather'=>$data['weather']
                ];
            }
            return [
                'status'=>'Success',
                'message'=>'Users Fetched Successfully',
                'data'=>$formattedData
            ];
        }catch (\Exception $e){
            return [
              'status'=>'fail',
              'message'=>$e->getMessage()
            ];
        }

    }
}
