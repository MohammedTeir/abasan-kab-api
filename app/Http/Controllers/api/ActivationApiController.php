<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ActivationApiController extends Controller
{

    public function validatePin($pin)
    {


        // Check if the PIN exists in the database
        $user = User::where('pin', $pin)->first();

        if ($user) {
            // Check the user's status
            if ($user->status === 'active') {
                // User account is already active
                return response()->json(['message' => 'حساب المستخدم مفعل بالفعل'], 400);
            } elseif ($user->status === 'in-active') {
                // User account is in-active
                return response()->json(['message' =>'لم يتم تنشيط حساب المستخدم. يرجى استكمال عملية التنشيط.'], 200);
            }

        } else {
            // PIN does not exist
            return response()->json(['message' => 'رمز الأمان غير صحيح. يرجى إدخال رمز أمان صحيح.'], 400);
        }
    }


    public function checkPhoneNumberOwnership($pin, $phone)
    {
        // Find the user by PIN
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رمز الأمان غير صحيح. يرجى إدخال رمز أمان صحيح.'], 400);
        }

        // Check if the user's phone number matches the provided phone number
        if ($user->phone === $phone) {
            return response()->json(['message' => 'رقم الهاتف ينتمي إلى المستخدم.'], 200);
        } else {
            return response()->json(['message' => 'رقم الهاتف لا ينتمي إلى المستخدم.'], 400);
        }
    }


    public function sendActivationCode(Request $request)
    {


        $pin = $request->input('pin');
        $phone = $request->input('phone');

        // Find the user by PIN
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رمز الأمان غير صحيح. يرجى إدخال رمز أمان صحيح.'], 400);
        }

        // Check if the user's phone number is not equal to the input phone number
        if ($user->phone !== $phone) {
            return response()->json(['message' => 'رقم الهاتف غير متطابق.'], 400);
        }

        // Generate a random activation code
        $activationCode = mt_rand(100000, 999999);

        // Store the activation code in the user's record
        $user->activation_code = $activationCode;
        $user->save();

        $client = new Client([
            'base_uri' => env('INFOBIP_URL'),
            'headers' => [
                'Authorization' => "App ".env('INFOBIP_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        $response = $client->request(
            'POST',
            'sms/2/text/advanced',
            [
                RequestOptions::JSON => [
                    'messages' => [
                        [
                            'from' => 'AbasanKab',
                            'destinations' => [
                                ['to' => '97'.$phone]
                            ],
                            'text' => 'رمز التفعيل الخاص بك هو  : ' . $activationCode ,
                        ]
                    ]
                ],
            ]
        );

        // $basic=new \Vonage\Client\Credentials\Basic(env('VONAGE_KEY'),env('VONAGE_SECRET'));
        // $client = new \Vonage\Client($basic);

        // $response = $client->sms()->send(
        //     new \Vonage\SMS\Message\SMS('97'.$phone,'Abasan Kab', 'Your activation code: '. $activationCode)
        // );

        // $message = $response->current();

        // if ($message->getStatus() == 0) {
        //     return response()->json(['message' => 'تم إرسال رمز التفعيل بنجاح.'], 200);
        //     } else {
        //             return response()->json(['message' => 'فشل في إرسال رمز التفعيل.'], 500);
        //     }

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'تم إرسال رمز التفعيل بنجاح.'], 200);
        } else {
            return response()->json(['message' => 'فشل في إرسال رمز التفعيل.'], 400);
        }

    }


    public function verifyActivationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|exists:users,pin',
            'activation_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $pin = $request->input('pin');
        $activationCode = $request->input('activation_code');

        // Find the user by PIN
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.'], 400);
        }


        // Check if the activation code matches
        if ($user->activation_code === $activationCode) {
            // Clear the activation code after successful verification
            $user->password = Hash::make($activationCode);
            $user->status = "active";
            $user->activation_code = null;
            $user->save();

            return response()->json(['message' => 'تم التحقق من رمز التفعيل بنجاح. يمكنك تسجيل الدخول الآن باستخدام رقم الهوية الخاصة بك و الرمز المرسل .'], 200);
        } else {
        return response()->json(['message' => 'رمز التفعيل غير صحيح.'], 400);
    }
    }

}
