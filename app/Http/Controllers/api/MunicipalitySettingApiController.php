<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MunicipalitySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MunicipalitySettingApiController extends Controller
{




/**
 * Display the specified resource.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function show(): JsonResponse
    {
        $municipalitySetting = MunicipalitySetting::first();

        if ($municipalitySetting) {
            return response()->json([
                'status' => 'success',
                'message' => 'Municipality setting retrieved successfully.',
                'data' => $municipalitySetting,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Municipality setting not found.',
        ], Response::HTTP_NOT_FOUND);
    }




    /**
     * Delete the cover images of the municipality setting.
     */
    /**
    */








    public function getCoverImages(): JsonResponse
    {
        $municipalitySetting = MunicipalitySetting::first();

        if (!$municipalitySetting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Municipality setting not found.',
            ], Response::HTTP_NOT_FOUND);
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Cover images retrieved successfully.',
            'images' =>  $municipalitySetting->ImagesUrl,
        ], Response::HTTP_OK);
    }


}
