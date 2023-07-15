<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $services = Service::with('category')->get();

        return response()->json([
            'data' => $services,
        ], Response::HTTP_OK);
    }

   


    public function getServicesByCategory(ServiceCategory $category)
    {

        // Retrieve all services belonging to the category
        $services = $category->services()->get();

        // Transform the image URL to use an S3 URL

        return response()->json([
            'message' => 'Services retrieved successfully.',
            'data' => $services,
        ],RESPONSE::HTTP_ACCEPTED);
    }

}

