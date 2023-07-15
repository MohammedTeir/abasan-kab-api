<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Media;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryApiController extends Controller
{

            public function getAllAlbums()
            {
                $albums = Album::with('images')->get();

                $albums->transform(function ($album) {
                    $album->images_url = $album->images->pluck('url')->map(function ($url) {
                        return Storage::disk('s3')->url($url);
                    });;

                    unset($album->images);


                    return $album;
                });

                return response()->json([
                    'data' => $albums,
                    'message' => 'Albums retrieved successfully',
                ], 200);
            }

            public function getAlbum(Album $album)
            {
                $album->load('images');
                $album->images_url = $album->images->pluck('url')->map(function ($url) {
                    return Storage::disk('s3')->url($url);
                });;

                unset($album->images);

                return response()->json([
                    'data' => $album,
                    'message' => 'Album retrieved successfully',
                ], 200);
            }





            public function getAllVideos()
            {
                $videos = Video::with('video')->get();

                $videos->transform(function ($e) {
                    $e->video_url = $e->video->url;
                    unset($e->video);
                    return $e;
                });

                return response()->json([
                    'data' => $videos,
                    'message' => 'All videos retrieved successfully',
                ], 200);
            }

}
