<?php

namespace App\Services;

use GuzzleHttp\Client;

class ZoomService
{
    protected $accountId;
    protected $clientId;
    protected $clientSecret;
    protected $httpClient;

    public function __construct()
    {
        $this->accountId = env('ZOOM_ACCOUNT_ID');
        $this->clientId = env('ZOOM_CLIENT_ID');
        $this->clientSecret = env('ZOOM_CLIENT_SECRET');

        $this->httpClient = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
        ]);
    }

    public function getAccessToken()
    {
        $response = $this->httpClient->post('https://zoom.us/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);

        return $responseData['access_token'] ?? null;
    }

    public function createMeeting(array $data)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->httpClient->post('users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'topic' => $data['topic'],
                'type' => 2, // Scheduled Meeting
                'start_time' => $data['start_time'],
                'duration' => $data['duration'],
                // Add more parameters as needed
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
