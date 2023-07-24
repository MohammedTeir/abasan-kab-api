<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Response;
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
                return response()->json(['message' => 'حساب المستخدم مفعل بالفعل' , 'status'=>400], 200);
            } elseif ($user->status === 'in-active') {
                // User account is in-active
                return response()->json(['message' =>'لم يتم تنشيط حساب المستخدم. يرجى استكمال عملية التنشيط.' , 'status'=>200 ], 200);
            }

        } else {
            // PIN does not exist
            return response()->json(['message' => ' رقم الهوية غير صحيح  يرجى التأكد من رقم الهوية .', 'status'=>400], 200);
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

        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|exists:users,pin',
            'phone' => 'required|string',
        ], [
            'pin.required' => ' رقم الهوية مطلوب.',
            'pin.exists' => 'رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.',
            'phone.required' => ' رقم الهاتف مطلوب.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status'=>400], Response::HTTP_OK);
        }

        $pin = $request->input('pin');
        $phone = $request->input('phone');

        // Find the user by PIN
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رقم الهوية غير صحيح. يرجى إدخال رمز هوية صحيح.', 'status'=>400], 200);
        }

        // Check if the user's phone number is not equal to the input phone number
        if ($user->phone !== $phone) {
            return response()->json(['message' => 'رقم الهاتف غير متطابق.' , 'status'=>400 ], 200);
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
            return response()->json(['message' => 'تم إرسال رمز التفعيل بنجاح.', 'status'=>200], 200);
        } else {
            return response()->json(['message' => 'فشل في إرسال رمز التفعيل.', 'status'=>400], 200);
        }

    }


    public function verifyActivationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|exists:users,pin',
            'activation_code' => 'required|string|min:6',
        ], [
            'pin.required' => ' رقم الهوية مطلوب.',
            'pin.exists' => 'رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.',
            'activation_code.required' => ' رمز التفعيل مطلوب.',
            'activation_code.min' => 'يجب أن يحتوي رمز التفعيل على الأقل 6 أحرف.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status'=>400], Response::HTTP_OK);
        }

        $pin = $request->input('pin');
        $activationCode = $request->input('activation_code');

        // Find the user by PIN
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح.','status'=>400], 200);
        }


        // Check if the activation code matches
        if ($user->activation_code === $activationCode) {
            // Clear the activation code after successful verification
            $user->password = Hash::make($activationCode);
            $user->status = "active";
            $user->activation_code = null;
            $user->save();

            return response()->json(['message' => 'تم التحقق من رمز التفعيل بنجاح. يمكنك تسجيل الدخول الآن باستخدام رقم الهوية الخاصة بك و الرمز المرسل .','status'=>200], 200);
        } else {
        return response()->json(['message' => 'رمز التفعيل غير صحيح.','status'=>400], 200);
    }
    }

}
