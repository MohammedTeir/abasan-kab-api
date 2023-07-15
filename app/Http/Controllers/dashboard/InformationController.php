<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCoverImagesRequest;
use App\Http\Requests\AddMayorSpeechRequest;
use App\Http\Requests\AddMunicipalityAboutRequest;
use App\Http\Requests\AddSettingRequest;
use App\Models\Image;
use App\Models\MayorSpeech;
use App\Models\MunicipalityAbout;
use App\Models\MunicipalitySetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InformationController extends Controller
{


    /**
     * Display a listing of the settings.
     *
     * This function retrieves all settings from the database and renders them in the index view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $about = MunicipalityAbout::first();
       $settings =MunicipalitySetting::first();
       $mayorSpeech =MayorSpeech::first();

        return response()->view('cms.informations',compact('about','settings','mayorSpeech'));
    }


     /**
     * Store a newly created mayor speech in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function AddMayorSpeech(AddMayorSpeechRequest $request)
    {
        $mayorSpeech = MayorSpeech::first();

        if (!$mayorSpeech) {
            $mayorSpeech = new MayorSpeech();
        }

        $mayorSpeech->title = $request->input('title');
        $mayorSpeech->content = $request->input('content');
        $mayorSpeech->save();
        if ($request->hasFile('image')) {
            $mayorImage = $request->file('image');
            $extension = $mayorImage->getClientOriginalExtension();
            $name = 'mayor.' . $extension;
            $path = "/development/media/municipality-informations/";

            $image = new Image();
            $image->url = $path . $name;

            // Remove existing image if it exists
            if ($mayorSpeech->image) {
                $mayorSpeech->image->delete();
            }

            $mayorSpeech->image()->save($image);
            $mayorImage->storeAs($path, $name, 's3');
        }

        $mayorSpeech->save();

        return response()->json([
            'message' => 'تم اٍضافة وتحديث كلمة رئيس البلدية.',
        ], Response::HTTP_CREATED);
    }



        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function AddSetting(AddSettingRequest $request)
        {
            // Check if MunicipalitySetting already exists
            $municipalitySetting = MunicipalitySetting::first();

            if (!$municipalitySetting) {
                $municipalitySetting = new MunicipalitySetting();
            }

            $municipalitySetting->telephone_number = $request->input('telephone_number');
            $municipalitySetting->mobile_number = $request->input('mobile_number');
            $municipalitySetting->email = $request->input('email');
            $municipalitySetting->address = $request->input('address');
            $municipalitySetting->facebook = $request->input('facebook');
            $municipalitySetting->instagram = $request->input('instagram');
            $municipalitySetting->youtube = $request->input('youtube');

            // Handle cover image upload
            if ($request->hasFile('cover_images')) {
                $coverImages = $request->file('cover_images');

                // Remove existing cover images if they exist
                foreach ($municipalitySetting->images as $image) {
                    $image->delete();
                }

                foreach ($coverImages as $coverImage) {
                    $ex = $coverImage->getClientOriginalExtension();
                    $name = 'cover-image' . time() * rand(1, 10000000) . '.' . $ex;
                    $path = "/development/media/municipality-informations/";

                    $image = new Image();
                    $image->url = $path . $name;
                    $municipalitySetting->images()->save($image); // associate the image with the municipality setting

                    $coverImage->storeAs($path, $name, 's3');
                }
            }

            $municipalitySetting->save();

            return response()->json([
                'status' => 'success',
                'message' => 'تم اٍضافة وتحديث المعلومات العامة للبلدية.',
            ], Response::HTTP_CREATED);
        }



        /**
         * Add cover images to the municipality setting.
         */
        public function addCoverImages(AddCoverImagesRequest $request)
        {
            $municipalitySetting = MunicipalitySetting::first();

            if (!$municipalitySetting) {
                return response()->json([
                    'message' => 'يجب اضافة الاعدادات العامة قبل اضافة صور الرئيسية.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Handle cover image upload
        if ($request->hasFile('cover_images')) {

            $coverImages = $request->file('cover_images');

            foreach ($coverImages as $coverImage) {

                    $ex = $coverImage->getClientOriginalExtension();
                    $name = 'cover-image' . time() * rand(1, 10000000) . '.' . $ex;
                    $path = "/development/media/municipality-informations/";

                    $image = new Image();
                    $image->url = $path. $name;
                    $municipalitySetting->images()->save($image); // associate the image with the admin

                    $coverImage->storeAs($path,$name,'s3');
            }
        }

            return response()->json([
                'status' => 'success',
                'message' => 'تم اِضافة صور الرئيسية بنجاح.',
            ], Response::HTTP_OK);
        }

        /**
         * Create or update the municipality about with content and image.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function AddMunicipalityAbout(AddMunicipalityAboutRequest $request)
        {
            $municipalityAbout = MunicipalityAbout::first();

            if (!$municipalityAbout) {
                $municipalityAbout = new MunicipalityAbout();
            }

            $municipalityAbout->content = $request->input('content');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $name = 'municipality-about-image.' . $extension;
                $path = "/development/media/municipality-informations/";

                // Remove existing image if it exists
                if ($municipalityAbout->image) {
                    $municipalityAbout->image->delete();
                }

                // Store the image file
                $image->storeAs($path, $name, 's3');

                // Associate the image URL with the municipality about
                $image = new Image();
                $image->url = $path . $name;
                $municipalityAbout->image()->save($image);
            }

            $municipalityAbout->save();

            return response()->json([
                'message' => 'تم اٍضافة وتحديث حول البلدية.',
            ], Response::HTTP_OK);
        }

}
