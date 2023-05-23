<?php

namespace App\Services;

use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\GenericProvider;


class ZoomService
{
    protected $apiKey;
    protected $apiSecret;
    protected $httpClient;
    protected $oauthProvider;

    public function __construct()
    {
        $this->accountId = env('ZOOM_ACCOUNT_ID');
        $this->clientId = env('ZOOM_CLIENT_ID');
        $this->clientSecret = env('ZOOM_CLIENT_SECRET');

        $this->httpClient = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
        ]);


        $this->oauthProvider = new GenericProvider([
            'clientId' => $this->apiKey,
            'clientSecret' => $this->apiSecret,
            'urlAuthorize' => 'https://zoom.us/oauth/token',
            'urlAccessToken' => 'https://zoom.us/oauth/token',
            'urlResourceOwnerDetails' => '',
        ]);

    }

    // public function getAccessToken()
    // {
    //     $accessToken = $this->oauthProvider->getAccessToken('client_credentials');

    //     return $accessToken->getToken();
    // }
    public function getAccessToken()
    {
        $httpClient = new \GuzzleHttp\Client();

        $response = $httpClient->post('https://zoom.us/oauth/token', [
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
