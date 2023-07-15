<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;

class DocumentCategoryApiController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = DocumentCategory::all();

        return response()->json([
            'data' => $categories,
            'message' => 'Categories retrieved successfully',
        ], 200);
    }

    
}
