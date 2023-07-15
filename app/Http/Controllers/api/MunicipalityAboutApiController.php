<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MunicipalityAbout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MunicipalityAboutApiController extends Controller
{
    /**
     * Get the first municipality about.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): JsonResponse
    {
        $municipalityAbout = MunicipalityAbout::first();

        $municipalityAbout->image_url=$municipalityAbout->imageurl;
        
        return response()->json([
            'data' => $municipalityAbout,
        ], Response::HTTP_OK);
    }



}
