<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the albums.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::all();

        return response()->view('cms.media.albums.albumsList',compact('albums'));
    }

    /**
     * Show the form for creating a new album.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  return  view for the create form
        return response()->view('cms.media.albums.create');
    }

    /**
     * Show the form for editing the specified album.
     *
     * @param  Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {

        // You can return the album data or render a view for the edit form
        return response()->view('cms.media.albums.edit',compact('album'));
    }

    /**
     * Store a newly created album in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddAlbumRequest $request)
    {

        $album = Album::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('images')) {
            $albumImages = $request->file('images');

            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($albumImages as $albumImage) {
                $ex = $albumImage->getClientOriginalExtension();
                $name = 'image' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/albums/{$currentYear}-{$currentMonth}/{$request->input('title')}/";

                $media = new Media();
                $media->url = $path.$name;
                $album->images()->save($media);

                $albumImage->storeAs($path,$name,'s3');
            }
        }
        $album->save();

        return response()->json([
            'message' => 'تم اٍضافة ألبوم بنجاح',
        ], 201);
    }

    /**
     * Update the specified album in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Album  $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAlbumRequest $request,Album $album)
    {



        // Update album details
        $album->title = $request->input('title',$album->title);
        $album->description = $request->input('description',$album->description);
        $album->save();

        // Store new images to S3
        if ($request->hasFile('images')) {

            // Delete previous images from S3
        foreach ($album->images as $image) {
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

            $albumImages = $request->file('images');

            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($albumImages as $albumImage) {
                $ex = $albumImage->getClientOriginalExtension();
                $name = 'image' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/albums/{$currentYear}-{$currentMonth}/{$request->input('title')}/";

                $media = new Media();
                $media->url = $path.$name;
                $album->images()->save($media);

                $albumImage->storeAs($path, $name, 's3');
            }
        }

        return response()->json([
            'message' => 'تم تحديث ألبوم بنجاح',
        ]);
    }

    /**
     * Remove the specified album from storage.
     *
     * @param  Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Album $album)
    {

        // Delete images from S3
        foreach ($album->images as $image) {
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

        $album->delete();

        return response()->json([
            'message' => 'تم حذف ألبوم بنجاح',
        ]);
    }



}
