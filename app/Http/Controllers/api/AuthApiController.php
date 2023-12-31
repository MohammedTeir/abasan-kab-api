<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Storage;
class AuthApiController extends Controller
{

    public function updateProfileImage(Request $request)

    {

            $user = $request->user('api');


            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');

                // Delete the previous avatar if it exists
                if ($user->image) {
                    Storage::disk('s3')->delete($user->image->url);
                    $user->image->delete();
                }

                $ex = $avatar->getClientOriginalExtension();
                $name = 'avatar' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/citizens/avatars/";

                $image = new Image();
                $image->url = $path . $name;
                $user->image()->save($image);

                $avatar->storeAs($path, $name, 's3');
            }

            $user->save();


            // Return a response or redirect as needed
            return response()->json(['message' => 'تم تحديث الصورة الشخصية بنجاح','status'=>200], Response::HTTP_OK);
    }


    public function resetPassword(Request $request)
    {

        // Find the user by PIN
        $user = $request->user('api');

        if (!$user) {
            // User with the provided PIN does not exist
            return response()->json(['message' => 'رقم الهوية غير صحيح. يرجى إدخال رقم هوية صحيح','status'=>400], 200);
        }

        // Generate a random activation code
        $activationCode = mt_rand(100000, 999999);

        // Store the activation code in the user's record
        $user->password = Hash::make($activationCode);
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
                                ['to' => '97'.$user->phone]
                            ],
                            'text' => 'رمز الدخول الجديد الخاص بك هو  : ' . $activationCode ,
                        ]
                    ]
                ],
            ]
        );


        if ($response->getStatusCode() == 200) {
                    return response()->json(['message' => 'تم إرسال رمز التفعيل بنجاح','status'=>200], 200);
                } else {
                    return response()->json(['message' => 'فشل في إرسال رمز التفعيل','status'=>400], 200);
                }


    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|exists:users,pin',
            'password' => 'required|min:5',
        ], [
            'pin.required' => ' رقم الهوية مطلوب.',
            'pin.exists' => 'رقم الهوية غير موجود.',
            'password.required' => ' كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل 5 أحرف.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'status'=>400], Response::HTTP_OK);
        }

        $user = User::where('pin', $request->input('pin'))->first();

        if ($user->status === 'in-active') {
            return response()->json([
                'message' => 'حسابك غير مفعل. يرجى تفعيله قبل تسجيل الدخول',
                'status'=>400
            ], Response::HTTP_OK);
        }

        try {
            $response = Http::asForm()->post(env('APP_URL')  . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => env('USER_SECRET'),
                'username' => $request->input('pin'),
                'password' => $request->input('password'),
                'scope' => '*'
            ]);

            $decoded_response = json_decode($response);

            $user->setAttribute('token', $decoded_response->access_token);

            User::where('pin',$request->input('pin'))->update(['last_login_at'=>Carbon::now()]);

            return response()->json([
                'message' => ' تم تسجيل الدخول بنجاح. مرحبا بك ! '.$user->name,
                'data' => $user,
                'status'=>200
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة',
                'status'=>400
            ], Response::HTTP_OK);
        }
    }



    public function logout(Request $request)
    {
    try {
        $user = $request->user('api');
        if ($user) {
            $user->token()->revoke();
            return response()->json([
                'message' => 'تم تسجيل الخروج بنجاح. وداعًا!',
                'status'=>200
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'المستخدم غير موجود أو تم الخروج بالفعل',
                'status'=>400
            ], Response::HTTP_OK);
        }
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'حدث خطأ أثناء تسجيل الخروج. يرجى المحاولة مرة أخرى',
            'status'=>400
        ], Response::HTTP_OK);
    }

    }


    public function profile(Request $request)
{
    $user = $request->user('api');




    return response()->json([
        'data' => [
            'pin' => $user->pin,
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $user->address,
            'last_login_at' => $user->last_login_at,
            'image_url' => $user->imageurl,
        ],
    ], Response::HTTP_OK);
}






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeServiceRequest(Request $request)
    {
        $user = $request->user('api');

        $validator = Validator::make($request->all(), [
            'service_category_id' => 'required|exists:service_categories,id',
            'service_id' => 'required|exists:services,id',
            'attached_files' => 'required|array|min:1', // Ensures the attached_files is an array and has at least one item
            'attached_files.*' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'service_category_id.required' => 'يجب تحديد تصنيف الخدمة.',
            'service_category_id.exists' => 'تصنيف الخدمة المحدد غير صالح.',
            'service_id.required' => 'يجب تحديد الخدمة.',
            'service_id.exists' => 'الخدمة المحددة غير صالحة.',
            'attached_files.required' => 'المرفقات مطلوبة. يرجى تحديد ملفات للمرفقات.',
            'attached_files.array' => 'المرفقات يجب أن تكون قائمة من الملفات.',
            'attached_files.min' => 'المرفقات مطلوبة. يرجى تحديد ملفات للمرفقات.',
            'attached_files.*.required' => ' المرفقات مطلوبة. يرجى تحديد ملفات للمرفقات.',
            'attached_files.*.file' => 'يجب أن تكون المرفقات ملفات.',
            'attached_files.*.mimes' => 'صيغة الملفات المسموح بها هي: jpeg, png, jpg, gif, pdf فقط.',
            'attached_files.*.max' => 'يجب أن يكون حجم الملفات أقل من 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400
            ], Response::HTTP_OK);
        }

        $serviceCategory = ServiceCategory::findOrFail($request->input('service_category_id'));
        $service = Service::findOrFail($request->input('service_id'));

        if ($service->service_category_id !== $serviceCategory->id) {
            return response()->json([
                'message' => 'الخدمة لا تنتمي إلى ' . $serviceCategory->name,
                'status' => 400
            ], Response::HTTP_OK);
        }

        $serviceRequest = ServiceRequest::create([
            'service_category_id' => $serviceCategory->id,
            'service_id' => $service->id,
            'beneficiary_pin' => $user->pin,
        ]);

        // Create a notification for the user
        $notification = Notification::create([
            'user_pin' => $user->pin,
            'message' => ' قام بطلب خدمة ' . $service->service_name,
        ]);

        $notification->save();
        $serviceRequest->save();

        if ($request->hasFile('attached_files')) {
            $serviceRequestFiles = $request->file('attached_files');
            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($serviceRequestFiles as $attached_file) {
                $ex = $attached_file->getClientOriginalExtension();
                $name = 'attachedFile-' . time() * rand(1, 10000) . '.' . $ex;
                $path = "/media/services/{$serviceCategory->name}/{$service->service_name}/الطلبات/{$currentYear}-{$currentMonth}/{$user->pin}/";

                $image = new Image();
                $image->url = $path . $name;
                $serviceRequest->images()->save($image);

                $attached_file->storeAs($path, $name, 's3');
            }
        }

        return response()->json([
            'message' => 'تم إنشاء طلب الخدمة بنجاح',
            'data' => $serviceRequest,
            'status' => 200
        ], Response::HTTP_OK);
    }


    public function deleteRequest(ServiceRequest $serviceRequest, Request $request)
    {
        $user = $request->user('api');

        // Check if the authenticated user is the owner of the service request
        if ($serviceRequest->beneficiary_pin !== $user->pin) {
            return response()->json([
                'message' => 'غير مسموح لك بحذف هذا الطلب',
                'status'=>400
            ], Response::HTTP_OK);
        }

        foreach ($serviceRequest->images as $image) {
            $imagePath = $image->url;

            // Delete the image file from S3
            if (Storage::disk('s3')->exists($imagePath)) {
                Storage::disk('s3')->delete($imagePath);
            }

            // Remove the image relation
            $image->delete();
        }

        // Delete the service request
        $serviceRequest->delete();

        return response()->json([
            'message' => 'تم حذف طلب الخدمة بنجاح',
            'status'=>200
        ], Response::HTTP_OK);
    }

    public function getServiceRequests(Request $request)
    {
        // Get the authenticated user
        $user = $request->user('api');

        // Retrieve all service requests for the user
        $serviceRequests = $user->serviceRequests()->with('serviceCategory', 'service')->get();

        // Define the mapping array for status translation


        // Transform the response data to include the service category name and service name
        $transformedData = $serviceRequests->map(function ($request) {

            $statusMapping = [
                'Accepted' => 'مقبول',
                'In Progress' => 'جاري الفحص',
                'Rejected' => 'مرفوض',
            ];

            return [
                'id' => $request->id,
                'service_category_id' => $request->serviceCategory->name,
                'service_id' => $request->service->service_name,
                'status' =>  $statusMapping[$request->status],
                'requested_date' => $request->created_at,
            ];
        });

        return response()->json([
            'message' => 'تم استرداد طلبات الخدمة بنجاح',
            'data' => $transformedData,
        ], Response::HTTP_OK);
    }


    public function makeComplaint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'complaint_title' => 'required|string|max:255',
            'complaint_content' => 'required|string',
        ], [
            'department_id.required' => 'يرجى اٍختيار الدائرة المراد ارسال لها الشكوى',
            'department_id.exists' => 'الدائرة التي تم اختيارها غير موجود , يرجى اختيار مرة اخرى',
            'complaint_title.required' => ' عنوان الشكوى مطلوب. يرجى إدخال عنوان للشكوى.',
            'complaint_title.string' => ' عنوان الشكوى يجب أن يكون نصًا.',
            'complaint_title.max' => ' عنوان الشكوى يجب أن لا يتجاوز 255 حرفًا.',
            'complaint_content.required' => ' محتوى الشكوى مطلوب. يرجى إدخال محتوى للشكوى.',
            'complaint_content.string' => ' محتوى الشكوى يجب أن يكون نصًا.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>400
            ], Response::HTTP_OK);
        }

        $user=$request->user('api');

        $complaint = Complaint::create([
            'department_id' => $request->input('department_id'),
            'complainant_pin' => $user->pin, // Use the user's pin as complainant_pin
            'complaint_title' => $request->input('complaint_title'),
            'complaint_content' => $request->input('complaint_content'),
        ]);

        return response()->json([
            'message' => 'تم تقديم الشكوى بنجاح',
            'data' => $complaint,
            'status'=>200
        ], Response::HTTP_OK);
    }

    public function myComplaints(Request $request)
    {
        $user=$request->user('api');  // Retrieve the authenticated user

        $complaints = $user->complaints()->get();


        $transformedData = $complaints->map(function ($complaint) {

            $statusMapping = [
                'open' => 'مفتوحة',
                'in progress' => 'قيد التنفيذ',
                'closed' => 'مغلقة',
            ];

            return [
                'title' => $complaint->complaint_title,
                'status' =>  $statusMapping[$complaint->status],
                'complaint_date' => $complaint->created_at,
            ];
        });

        return response()->json([
            'message' => 'تم استرداد الشكاوى بنجاح',
            'data' => $transformedData,
        ], Response::HTTP_OK);
    }

    public function addAddress(Request $request)
    {
        $user = $request->user('api');

        $user->address = $request->input('address');
        $user->save();

        return response()->json([
            'message' => 'تم اضافةالعنوان بنجاح',
            'status'=>200
        ], Response::HTTP_OK);
    }

}
