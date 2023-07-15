<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MunicipalityProjectsCategory;


class MunicipalityProjectsCategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = MunicipalityProjectsCategory::all(['id','name']);

        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }

}
