<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
       $this->authorizeResource(User::class);
    }

    public function index(): Response
    {
        //


        return response()->view('user-management.citizens',[

            'users'=>User::withTrashed()->select(['pin','name','phone','address','status','last_login_at'])->get(),

        ]);
    }






    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {

        return response()->view('apps.human-resource.users.view',[
            'user'=>$user,
            ]);
    }


}
