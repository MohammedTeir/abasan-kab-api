<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    private $accessToken='';

    // public function testLogin()
    // {

    //     $client = new Client();
    //     $url = env('APP_URL').'/api/auth/login';

      

    //     // Act: Make a request to the login endpoint
    //     try {
    //         $response = $client->post($url, [
    //             'json' => [
    //                 'pin' => '405857004', // Replace with a valid user PIN
    //                 'password' => '368305', // Replace with a valid password
    //             ],
    //         ]);

    //         $statusCode = $response->getStatusCode();
    //         $responseData = json_decode($response->getBody(), true);

    //         // Assert: Check the response for expected outcomes
    //         $this->assertEquals(200, $statusCode); // Assuming a successful login returns a 200 status code
    //         $this->assertEquals(' تم تسجيل الدخول بنجاح. مرحبا بك !', $responseData['message']); // Replace with the expected message

    //     } catch (GuzzleException $e) {
    //         // Handle any exceptions from Guzzle (e.g., connection errors)
    //         $this->fail("Guzzle request failed: " . $e->getMessage());
    //     }
    // }

    // public function testLogin()
    // {
    //     $client = new Client();
    //     $validPin = '405857004'; // Replace with a valid PIN from your database
    //     $validPassword = '622360'; // Replace with a valid password

    //     // Test with valid PIN and password
    //     $urlValid = env('APP_URL') . '/api/auth/login';
    //     $responseValid = $client->post($urlValid, [
    //         'json' => [
    //             'pin' => $validPin,
    //             'password' => $validPassword,
    //         ],
    //     ]);

    //     $statusCodeValid = $responseValid->getStatusCode();
    //     $responseDataValid = json_decode($responseValid->getBody(), true);

    //     $this->assertEquals(200, $statusCodeValid);
    //     $this->assertEquals(" تم تسجيل الدخول بنجاح. مرحبا بك ! {$responseDataValid['data']['name']}", $responseDataValid['message']);
    //     $this->assertEquals(200, $responseDataValid['status']);

    //     // Store the access token
    //     $this->accessToken = $responseDataValid['data']['token'];
    // }
    
  
}
