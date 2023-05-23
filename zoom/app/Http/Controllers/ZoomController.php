<?php
namespace App\Http\Controllers;

use App\Services\ZoomService;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\ZoomMeetingTrait;
use GuzzleHttp\Client;
use Zoom\Auth\OAuth;
use MacsiDigital\Zoom\Facades\ZoomOAuth;




use Log;

class ZoomController extends Controller
{
    use ZoomMeetingTrait;

    // public function __construct(GuzzleClient $client)
    // {
    //     $this->client = $client;
    // }
    public function __construct()
    {
        $this->client = new Client();
        // $this->oauth = new OAuth();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
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

        $this->oauth->setAuthorizationHeader();

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
