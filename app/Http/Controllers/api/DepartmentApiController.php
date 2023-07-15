<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
class DepartmentApiController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json([
            'message' => 'Departments retrieved successfully.',
            'data' => $departments,
        ], Response::HTTP_OK);
    }


}
