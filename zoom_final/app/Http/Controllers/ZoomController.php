<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ZoomJWT;
use GuzzleHttp\Client as GuzzleClient;

class ZoomController extends Controller
{
    public function index()
    {
        $token = ZoomJWT::generateToken();

        $client = new GuzzleClient([
            'base_uri' => 'https://api.zoom.us',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        $response = $client->get('/v2/users');

        $users = json_decode($response->getBody(), true);

        return view('users', compact('users'));
    }
    public function create(Request $request)
    {
        $token = ZoomJWT::generateToken();

        $client = new GuzzleClient([
            'base_uri' => 'https://api.zoom.us',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        $response = $client->post('/v2/users/' . $request->user_id . '/meetings', [
            'json' => [
                'topic' => $request->topic,
                'type' => $request->type,
                'start_time' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'timezone' => $request->timezone,
                'agenda' => $request->agenda,
                'settings' => [
                    'host_video' => $request->settings['host_video'] === 'true' ? true : false,
                    // Add more meeting settings as needed
                ],
            ],
        ]);

        $meeting = json_decode($response->getBody(), true);

        return view('show_meeting', compact('meeting'));
    }

}
