<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsApiController extends Controller
{
    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $news = News::published()->with('images')->latest()->limit(10)->get();

        $newsWithImages = $news->map(function ($item) {
            $item->image_url = $item->images->first() ? Storage::disk('s3')->url($item->images->first()->url) : null;
            unset($item->images);
            return $item;
        });

        return response()->json([
            'message' => 'Successfully retrieved news.',
            'data' => $newsWithImages,
        ], 200);

    }


/**
 * Show the specified news.
 *
 * @param  \App\Models\News  $news
 * @return \Illuminate\Http\JsonResponse
 */
public function show(News $news)
{
    $tags = $news->tags; // Assuming tags are stored as a JSON array in the database

    $relatedNews = News::published()
        ->where(function ($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhereJsonContains('tags', $tag);
            }
        })
        ->where('id', '!=', $news->id)
        ->with('images')
        ->get();

   // Transform the image URLs in the related news
    $relatedNews->each(function ($related) {
        $related->image_url = Storage::disk('s3')->url($related->images->first()->url);
        unset($related->images);
    });

    // Transform the image URL in the main news
    $news->image_url = Storage::disk('s3')->url($news->images->first()->url);
    unset($news->images);

    return response()->json([
        'message' => 'Successfully retrieved news.',
        'data' => [
            'news' => $news,
            'related_news' => $relatedNews,
        ],
    ], 200);
}














}
