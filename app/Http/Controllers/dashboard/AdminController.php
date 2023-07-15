<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;
use App\Models\Admin;
use App\Models\Image;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
        $this->authorizeResource(Admin::class);
     }

    public function index(): Response
    {
        return response()->view('user-management.adminlist',[

            'admins'=>Admin::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
     {

        return response()->view('user-management.newadmin',['roles'=>Role::select(['id','name'])->get()]);


     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAdminRequest $request): JsonResponse
    {
        //

            $admin = new admin();
            $admin->name=$request->get('full_name');
            $admin->email=$request->get('email');
            $admin->status= 'active';
            $admin->password=Hash::make($request->get('password'));
            $admin->role_id= $request->get('role_id');

            $admin->save();

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');

                $ex = $avatar->getClientOriginalExtension();
                $name = 'avatar' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/development/media/avatars/";

                $image = new Image();
                $image->url = $path . $name;
                $admin->image()->save($image);

                $avatar->storeAs($path, $name, 's3');
            }

            if ($admin->save()) {
                return response()->json(['message' => 'تمت إضافة المشرف بنجاح.'], Response::HTTP_CREATED);
            } else {
                return response()->json(['message' => 'غير قادر على إضافة المشرف. يرجى المحاولة مرة أخرى لاحقًا.'], Response::HTTP_FORBIDDEN);
            }

            }


/**
 * Remove the specified resource from storage.
 */
public function destroy(Admin $admin): JsonResponse
{
    if ($admin->forceDelete()) {
        return response()->json(['message' => 'تم حذف حساب المشرف بنجاح.'], Response::HTTP_OK);
    } else {
        return response()->json(['message' => 'غير قادر على حذف حساب المشرف. يرجى المحاولة مرة أخرى لاحقًا.'], Response::HTTP_FORBIDDEN);
    }
}




    public function restore(Admin $admin): JsonResponse
    {

            $admin->status = 'active';
            $admin->save();
            return response()->json(['message' => 'تم تفعيل حساب المشرف بنجاح.'], Response::HTTP_OK);

    }

     /**
     * Restrict the specified admin account.
     */
    public function restrictAccount(Admin $admin): JsonResponse
    {
        $admin->status = 'restricted';
        $admin->save();

        if (Auth::guard('admin')->check() && Auth::guard('admin')->id() == $admin->id) {
            Auth::guard('admin')->logout();
        }

        return response()->json(['message' => 'تم تقييد حساب المشرف بنجاح.'], Response::HTTP_OK);
    }

}
