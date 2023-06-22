<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ZoomMeetingTrait;
use GuzzleHttp\Client;

class ZoomController extends Controller
{
    use ZoomMeetingTrait;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}




