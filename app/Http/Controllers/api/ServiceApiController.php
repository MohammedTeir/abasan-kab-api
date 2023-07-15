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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_category_id' => 'required|exists:service_categories,id',
            'service_name' => 'required|string|max:255|unique:services',
            'price' => 'required|string',
            'required_time' => 'required|string',
            'required_documents' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $category = ServiceCategory::find($request->input('service_category_id'));
        if (!$category) {
            return response()->json([
                'message' => 'Service category not found.',
            ], Response::HTTP_NOT_FOUND);
        }




        $service = Service::create([
            'service_category_id' => $request->input('service_category_id'),
            'service_name' => $request->input('service_name'),
            'price' => $request->input('price'),
            'required_time' => $request->input('required_time'),
            'required_documents' =>  $request->input('required_documents'),
        ]);


        $service->save();

        return response()->json([
            'message' => 'Service created successfully.',
            'data' => $service,
        ], Response::HTTP_CREATED);
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

