<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\MayorSpeech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MayorSpeechApiController extends Controller
{





    /**
     * Display the specified mayor speech.
     *
     * @param  \App\Models\MayorSpeech  $mayorSpeech
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
{
    $mayorSpeech = MayorSpeech::with('image')->first();

    $mayorImage = null;
    if ($mayorSpeech->image) {
        $mayorImage = Storage::disk('s3')->url($mayorSpeech->image->url);
    }

    $mayorSpeech->unsetRelations();
    $mayorSpeechData = $mayorSpeech->toArray();
    $mayorSpeechData['mayor_image'] = $mayorImage;

    return response()->json([
        'message' => 'Successfully retrieved mayor speech.',
        'data' => $mayorSpeechData,
    ], Response::HTTP_OK);
}


}
