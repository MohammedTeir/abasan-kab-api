<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileImageRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Admin;
use App\Models\Image;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DashboardAuthController extends Controller
{

    /**
     * Form for reset the password for the admin and send it via email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgot()
    {

        return response()->view('auth.forgotPassword');

    }


   /**
     * Reset the password for the admin and send it via email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $email = $request->input('email');

        // Check if the email exists
        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return response()->json([
                'message' => 'هذا البريد الإلكتروني غير موجود.',
            ], 404);
        }

        // Generate a random password
        $password = Str::random(10);

        // Hash the new password
        $hashedPassword = Hash::make($password);

        // Update the admin's password
        $admin->password = $hashedPassword;
        $admin->save();

        // Send the new password via email using Mailgun
        $client = new Client();

        $response = $client->post('https://api.mailgun.net/v3/' . env('MAILGUN_DOMAIN') . '/messages', [
            'auth' => ['api', env('MAILGUN_SECRET')],
            'form_params' => [
                'from' => 'Abasan Municipality <mailgun@' . env('MAILGUN_DOMAIN') . '>',
                'to' => $admin->email,
                'subject' => 'إعادة تعيين كلمة المرور',
                'text' => 'كلمة المرور الجديدة: ' . $password
            ],
        ]);



        if ($response->getStatusCode() !== 200) {
            // Failed to send email
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال كلمة المرور الجديدة.',
            ], 500);
        }


        return response()->json([
            'message' => 'تم إرسال كلمة المرور الجديدة إلى البريد الإلكتروني الخاص بك.',
        ], 200);
    }


    public function login(LoginRequest $request):JsonResponse
    {


        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];


            if (Auth::guard('admin')->attempt($credentials)) {
                Admin::where('email', $request->get('email'))->update(['last_login_at' => Carbon::now()]);
                return response()->json(['message' => 'تم تسجيل الدخول بنجاح.!'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'], Response::HTTP_BAD_REQUEST);
            }
        }



        /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return response()->view('auth.signin');
    }

    public function myProfile()
    {
        return response()->view('auth.profile',['user'=>Auth::user()]);
    }


    /**
     * Update the user's profile image.
     *
     * @param  UpdateProfileImageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
        public function updateProfileImage(UpdateProfileImageRequest $request)
        {

                $user = Auth::user();


                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');

                    // Delete the previous avatar if it exists
                    if ($user->image) {
                        Storage::disk('s3')->delete($user->image->url);
                        $user->image->delete();
                    }

                    $ex = $avatar->getClientOriginalExtension();
                    $name = 'avatar' . time() * rand(1, 10000000) . '.' . $ex;
                    $path = "/media/avatars/";

                    $image = new Image();
                    $image->url = $path . $name;
                    $user->image()->save($image);

                    $avatar->storeAs($path, $name, 's3');
                }

                $user->save();


                // Return a response or redirect as needed
                return response()->json(['message' => 'تم تحديث الصورة الشخصية بنجاح'], Response::HTTP_OK);
        }







        public function updateProfile(UpdateProfileRequest $request)
        {

            $user = Auth::user();



            if ($request->has('name')) {
                $user->name = $request->input('name');
            }
            if ($request->has('email')) {
                $user->email = $request->input('email');
            }
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            return response()->json([
                'message' => 'تم تحديث البيانات بنجاح. '
            ], 200);
        }




    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/dashboard');
    }

}
