<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
       $this->authorizeResource(Role::class);
    }

    public function index(): Response
    {

        return response()->view('user-management.roles',
        [
            'roles'=>Role::select(['id','name','description'])->withCount('users')->get()
        ]);
    }


    public function store(AddRoleRequest $request): JsonResponse
    {
        //

        $role = new Role();
        $role->name = $request->input('role_name');
        $role->description = $request->input('description');

        if ($role->save()) {
            return response()->json(['message' => 'تمت إضافة الدور بنجاح.'], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'غير قادر على إضافة الدور. يرجى المحاولة مرة أخرى لاحقًا.'], Response::HTTP_FORBIDDEN);
        }
    }


    public function show(Role $role): JsonResponse
    {
        return response()->json(['role' => $role], Response::HTTP_OK);
    }

    public function update(UpdateRoleRequest $request,Role $role): JsonResponse
    {
        $role->name = $request->input('role_name');
        $role->description = $request->input('description');

        if ($role->save()) {
            return response()->json(['message' => 'تم تحديث الدور بنجاح.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'غير قادر على تحديث الدور. يرجى المحاولة مرة أخرى لاحقًا.'], Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy(Role $role): JsonResponse
    {

        if ($role->delete()) {
            return response()->json(['message' => 'تم حذف الدور بنجاح.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'غير قادر على حذف الدور. يرجى المحاولة مرة أخرى لاحقًا.'], Response::HTTP_FORBIDDEN);
        }
    }

    public function revokeRole(Admin $admin, Role $role): JsonResponse
    {
        // Retrieve the user and role

        // Detach the role from the user
        $admin->role()->detach($role->id);

        return response()->json(['message' => 'تم إلغاء الدور بنجاح.'], Response::HTTP_OK);
    }





}
