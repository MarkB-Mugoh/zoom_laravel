<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Zoom\OAuth\OAuth;

trait ZoomMeetingTrait
{
    public $client;
    public $oauth;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->oauth = new OAuth();

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->generateZoomToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    private function generateZoomToken()
    {
        $clientId = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');

        $this->oauth->setClientId($clientId);
        $this->oauth->setClientSecret($clientSecret);

        $response = $this->oauth->clientCredentials();
        $accessToken = $response['access_token'];

        return $accessToken;
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomMeetingTrait->toZoomTimeFormat: ' . $e->getMessage());

            return '';
        }
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required',
            'start_time' => 'required|date',
            'duration' => 'required|integer',
            'agenda' => 'nullable',
            'host_video' => 'required|boolean',
            'participant_video' => 'required|boolean',
        ]);

        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body' => json_encode([
                'topic' => $data['topic'],
                'type' => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration' => $data['duration'],
                'agenda' => (!empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone' => 'Asia/Kolkata',
                'settings' => [
                    'host_video' => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => $data['participant_video'] == "1" ? true : false,
                    'waiting_room' => true,
                ],
            ]),
        ];

        $response = $this->client->post($url . $path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data' => json_decode($response->getBody(), true),
        ];
    }

    public function update($id, $data)
    {
        $path = 'meetings/' . $id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body' => json_encode([
                'topic' => $data['topic'],
                'type' => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration' => $data['duration'],
                'agenda' => (!empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone' => 'Asia/Kolkata',
                'settings' => [
                    'host_video' => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => $data['participant_video'] == "1" ? true : false,
                ],
            ]),
        ];

        // Rest of the code...
    }

    public function scheduleMeeting(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'topic' => 'required|string',
            'start_time' => 'required|date',
            'duration' => 'required|integer',
            'agenda' => 'nullable|string',
            'host_video' => 'required|string',
            'participant_video' => 'required|string',
        ]);

        $data = [
            'topic' => $validatedData['topic'],
            'start_time' => $validatedData['start_time'],
            'duration' => $validatedData['duration'],
            'agenda' => $validatedData['agenda'],
        ];

        $response = $this->client->post('https://api.zoom.us/v2/users/me/meetings', [
            'headers' => $this->headers,
            'body' => json_encode($data),
        ]);

        return [
            'success' => $response->getStatusCode() === 201,
            'data' => json_decode($response->getBody(), true),
        ];
    }
}
