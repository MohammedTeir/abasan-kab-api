<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Show the form for display a listing of the ads.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::all();


        return response()->view('cms.ads.adlist',['ads'=>$ads]);
    }


    /**
     * Show the form for creating a new ad.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.ads.create');
    }

    /**
     * Show the form for editing the specified ad.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        return  response()->view('cms.ads.edit', ['ad' => $ad]);
    }

    /**
     * Store a newly created ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddAdRequest $request)
    {

        // Create the ad
        $ad = new Ad([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        $ad->save();

        // Upload and associate the image
        if ($request->hasFile('image')) {

            $adImage = $request->file('image');
            $currentYear = date('Y');
            $currentMonth = date('m');


                $ex = $adImage->getClientOriginalExtension();
                $name = 'ad' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/ads/{$currentYear}-{$currentMonth}/";

                $image = new Image();
                $image->url = $path.$name;
                $ad->image()->save($image);

                $adImage->storeAs($path,$name,'s3');

        }

        return response()->json([
            'message' => 'تم اٍضافة الاٍعلان بنجاح.',
        ], Response::HTTP_CREATED);
    }


    /**
     * Update the specified ad in storage.
     *
     * @param  \App\Http\Requests\UpdateAdRequest  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $ad->title = $request->input('title',$ad->title);
        $ad->content = $request->input('content',$ad->content);



        // Upload and associate the new image
        if ($request->hasFile('image')) {

             // Delete the previous image from S3
            $previousImage = $ad->image;
            if ($previousImage) {
                Storage::disk('s3')->delete($previousImage->url);
                $previousImage->delete();
            }

            $adImage = $request->file('image');
            $currentYear = date('Y');
            $currentMonth = date('m');

            $ex = $adImage->getClientOriginalExtension();
            $name = 'ad' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/media/ads/{$currentYear}-{$currentMonth}/";

            $image = new Image();
            $image->url = $path . $name;
            $ad->image()->save($image);

            $adImage->storeAs($path, $name, 's3');
        }

        $ad->save();

        return response()->json([
            'message' => 'تم تحديث الاٍعلان بنجاح.',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified ad from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ad $ad)
    {
        // Delete the associated image
        $image = $ad->image;
        if ($image) {
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

        // Delete the ad
        $ad->delete();

        return response()->json([
            'message' => 'تم حذف الاٍعلان بنجاح.',
        ], Response::HTTP_OK);
    }


}
