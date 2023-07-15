<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddViedoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Media;
use App\Models\Video;

class VideoController extends Controller
{
    /**
     * Display a listing of the videos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();

        return response()->view('cms.media.videos.videolist',compact('videos'));
    }


    public function store(AddViedoRequest $request)
    {


        // Create the video
        $video = Video::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Create a media instance
        $media = new Media();
        $media->url = $request->input('embed_code');
        $video->video()->save($media);

        return response()->json([
            'message' => 'تمت اٍضافة الفيديو بنجاح',
        ], 201);
    }

    /**
 * Update the specified video in storage.
 *
 * @param  \App\Http\Requests\UpdateVideoRequest  $request
 * @param  \App\Models\Video  $video
 * @return \Illuminate\Http\JsonResponse
 */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        // Update the video details
        $video->title = $request->input('title',$video->title);
        $video->description = $request->input('description',$video->description);
        $video->save();

        // Update the video media
        $media = $video->video;
        $media->url = $request->input('embed_code',$video->video->url);
        $media->save();

        return response()->json([
            'message' => 'تم تحديث الفيديو بنجاح',
        ]);
    }

    /**
     * Remove the specified video from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Video $video)
    {
        // Delete the associated media file
        $media = $video->video;
        if ($media) {

            $media->delete();
        }

        $video->delete();

        return response()->json([
            'message' => 'تم حذف الفيديو بنجاح',
        ]);
    }


}
