<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdApiController extends Controller
{
    /**
     * Display a listing of the ads.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ads = Ad::with('image')->get();

        $adsWithImageUrl = $ads->map(function ($ad) {
            $ad->image_url = $ad->image ? Storage::disk('s3')->url($ad->image->url) : null;
            unset($ad->image);
            return $ad;
        });

        return response()->json([
            'message' => 'Successfully retrieved ads.',
            'data' => $adsWithImageUrl,
        ], Response::HTTP_OK);
    }


 

    /**
     * Display the specified ad.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ad $ad)
    {
        $ad->load('image');
        $ad->image_url = $ad->image ? Storage::disk('s3')->url($ad->image->url) : null;
        unset($ad->image);

        return response()->json([
            'message' => 'Successfully retrieved ad.',
            'data' => $ad,
        ], Response::HTTP_OK);
    }


}
