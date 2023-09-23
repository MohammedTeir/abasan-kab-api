<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivationTest extends TestCase
{
    public function testValidatePin()
    {
        $client = new Client();
        $validPin = '405857004';
        $invalidPin = '123456789'; // Replace with an invalid PIN
    
        // Test with a valid PIN for an active user
        $urlActiveUser = env('APP_URL') . "/api/users/{$validPin}/validate";
        $responseActiveUser = $client->get($urlActiveUser);
    
        $statusCodeActiveUser = $responseActiveUser->getStatusCode();
        $responseDataActiveUser = json_decode($responseActiveUser->getBody(), true);
    
        $this->assertEquals(200, $statusCodeActiveUser);
        $this->assertEquals('حساب المستخدم مفعل بالفعل', $responseDataActiveUser['message']);
        $this->assertEquals(400, $responseDataActiveUser['status']);
    
        // Test with a valid PIN for an in-active user
        $urlInactiveUser = env('APP_URL') . "/api/users/{$validPin}/validate";
        $responseInactiveUser = $client->get($urlInactiveUser);
    
        $statusCodeInactiveUser = $responseInactiveUser->getStatusCode();
        $responseDataInactiveUser = json_decode($responseInactiveUser->getBody(), true);
    
        $this->assertEquals(200, $statusCodeInactiveUser);
        $this->assertEquals('لم يتم تنشيط حساب المستخدم. يرجى استكمال عملية التنشيط.', $responseDataInactiveUser['message']);
        $this->assertEquals(200, $responseDataInactiveUser['status']);
    
        // Test with an invalid PIN
        $urlInvalidPin = env('APP_URL') . "/api/users/{$invalidPin}/validate";
        $responseInvalidPin = $client->get($urlInvalidPin);
    
        $statusCodeInvalidPin = $responseInvalidPin->getStatusCode();
        $responseDataInvalidPin = json_decode($responseInvalidPin->getBody(), true);
    
        $this->assertEquals(200, $statusCodeInvalidPin);
        $this->assertEquals(' رقم الهوية غير صحيح  يرجى التأكد من رقم الهوية .', $responseDataInvalidPin['message']);
        $this->assertEquals(400, $responseDataInvalidPin['status']);
    }
    
    // public function testSendActivationCode()
    // {
    //     $client = new Client();
    //     $validPin = '405857004'; // Replace with a valid PIN from your database
    //     $validPhone = '0592524815'; // Replace with a valid phone number associated with the PIN
    //     $invalidPin = '123456789'; // Replace with an invalid PIN

    //     // Test with a valid PIN and phone number
    //     $urlValid = env('APP_URL') . '/api/activation-code';
    //     $responseValid = $client->post($urlValid, [
    //         'json' => [
    //             'pin' => $validPin,
    //             'phone' => $validPhone,
    //         ],
    //     ]);

    //     $statusCodeValid = $responseValid->getStatusCode();
    //     $responseDataValid = json_decode($responseValid->getBody(), true);

    //     $this->assertEquals(200, $statusCodeValid);
    //     $this->assertEquals('تم إرسال رمز التفعيل بنجاح.', $responseDataValid['message']);
    //     $this->assertEquals(200, $responseDataValid['status']);

    //     // Test with an invalid PIN
    //     $urlInvalid = env('APP_URL') . '/api/activation-code';
    //     $responseInvalid = $client->post($urlInvalid, [
    //         'json' => [
    //             'pin' => $invalidPin,
    //             'phone' => $validPhone,
    //         ],
    //     ]);

    //     $statusCodeInvalid = $responseInvalid->getStatusCode();
    //     $responseDataInvalid = json_decode($responseInvalid->getBody(), true);

    //     $this->assertEquals(200, $statusCodeInvalid);
    //     $this->assertEquals('رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.', $responseDataInvalid['message']);
    //     $this->assertEquals(400, $responseDataInvalid['status']);
    

    // }

    // public function testVerifyActivationCode()
    // {
    //     $client = new Client();
    //     $validPin = '405857004'; // Replace with a valid PIN from your database
    //     $validActivationCode = '622360'; // Replace with a valid activation code
    //     $invalidPin = '123456789'; // Replace with an invalid PIN
    //     $invalidActivationCode = '987654'; // Replace with an invalid activation code

    //     // Test with a valid PIN and activation code
    //     $urlValid = env('APP_URL') . '/api/verify-activation-code';
    //     $responseValid = $client->post($urlValid, [
    //         'json' => [
    //             'pin' => $validPin,
    //             'activation_code' => $validActivationCode,
    //         ],
    //     ]);

    //     $statusCodeValid = $responseValid->getStatusCode();
    //     $responseDataValid = json_decode($responseValid->getBody(), true);

    //     $this->assertEquals(200, $statusCodeValid);
    //     $this->assertEquals('تم التحقق من رمز التفعيل بنجاح. يمكنك تسجيل الدخول الآن باستخدام رقم الهوية الخاصة بك و الرمز المرسل .', $responseDataValid['message']);
    //     $this->assertEquals(200, $responseDataValid['status']);

    //     // Test with an invalid PIN
    //     $urlInvalidPin = env('APP_URL') . '/api/verify-activation-code';
    //     $responseInvalidPin = $client->post($urlInvalidPin, [
    //         'json' => [
    //             'pin' => $invalidPin,
    //             'activation_code' => $validActivationCode,
    //         ],
    //     ]);

    //     $statusCodeInvalidPin = $responseInvalidPin->getStatusCode();
    //     $responseDataInvalidPin = json_decode($responseInvalidPin->getBody(), true);

    //     $this->assertEquals(200, $statusCodeInvalidPin);
    //     $this->assertEquals('رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.', $responseDataInvalidPin['message']);
    //     $this->assertEquals(400, $responseDataInvalidPin['status']);

    //     // Test with an invalid activation code
    //     $urlInvalidCode = env('APP_URL') . '/api/verify-activation-code';
    //     $responseInvalidCode = $client->post($urlInvalidCode, [
    //         'json' => [
    //             'pin' => $validPin,
    //             'activation_code' => $invalidActivationCode,
    //         ],
    //     ]);

    //     $statusCodeInvalidCode = $responseInvalidCode->getStatusCode();
    //     $responseDataInvalidCode = json_decode($responseInvalidCode->getBody(), true);

    //     $this->assertEquals(200, $statusCodeInvalidCode);
    //     $this->assertEquals('رمز التفعيل غير صحيح.', $responseDataInvalidCode['message']);
    //     $this->assertEquals(400, $responseDataInvalidCode['status']);
    // }

}
