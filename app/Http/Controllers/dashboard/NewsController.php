<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Image;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


class NewsController extends Controller
{
   /**
     * Display a listing of the news.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();


        return response()->view('cms.news.newslist',['news'=>$news]);

    }

    /**
     * Display a filter listing of the news.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterNews(Request $requset)
    {

        $is_featured = $requset->input('is_featured');
        $is_published = $requset->input('is_published');

        $news = News::where('is_featured',$is_featured)->orWhere('is_published',$is_published)->get();


        return response()->view('cms.news.newslist',['news'=>$news]);

    }

    /**
     * Show the form for creating a new news.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.news.create');
    }




    public function edit(News $news)
{
    $transformedTags = implode(', ', $news->tags);

    // Modify the $news object to include the transformed tags
    $news->tags = $transformedTags;

    return response()->view('cms.news.edit', ['news' => $news]);
}


    /**
     * Store a newly created news in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddNewsRequest $request)
    {



        $tags = $request->input('tags');
        $tagArray = [];

        if ($tags) {
            $tagArray = explode(',', $tags);
            $tagArray = array_map('trim', $tagArray);
        }

        $news = new News([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'is_featured' => $request->input('is_featured'),
            'is_published' => $request->input('is_published'),
            'tags' => $tagArray,
        ]);

        $news->save();



        if ($request->hasFile('news_images')) {
            $newsImages = $request->file('news_images');
            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($newsImages as $newsImage) {
                $ex = $newsImage->getClientOriginalExtension();
                $name = 'news' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/news/{$currentYear}-{$currentMonth}/";

                $image = new Image();
                $image->url = $path.$name;
                $news->images()->save($image);

                $newsImage->storeAs($path,$name,'s3');
            }
        }

        $news->save();

        return response()->json([
            'message' => 'تم اٍضافة الخبر بنجاح.',
        ], Response::HTTP_CREATED);


    }



     /**
     * Update the specified news in storage.
     *
     * @param  UpdateNewsRequest  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(UpdateNewsRequest $request, News $news)
    {

        $tags = $request->input('tags');
        $tagArray = [];

        if ($tags) {
            $tagArray = explode(',', $tags);
            $tagArray = array_map('trim', $tagArray);
        }

        if ($request->filled('title')) {
            $news->title = $request->input('title');
        }

        if ($request->filled('content')) {
            $news->content = $request->input('content');
        }

        if ($request->filled('is_featured')) {
            $news->is_featured = $request->input('is_featured');
        }

        if ($request->filled('is_published')) {
            $news->is_published = $request->input('is_published');
        }

        if ($request->filled('tags')) {
            $news->tags = $tagArray;
        }



        if ($request->hasFile('news_images')) {

            // Delete previous images
            $previousImages = $news->images;
            foreach ($previousImages as $image) {
                Storage::disk('s3')->delete($image->url);
                $image->delete();
            }

            $newsImages = $request->file('news_images');
            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($newsImages as $newsImage) {
                $ex = $newsImage->getClientOriginalExtension();
                $name = 'news' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/news/{$currentYear}-{$currentMonth}/";

                $image = new Image();
                $image->url = $path.$name;
                $news->images()->save($image);

                $newsImage->storeAs($path, $name, 's3');
            }
        }

        $news->save();

        return response()->json([
            'message' => 'تم تحديث الخبر بنجاح.',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified news from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(News $news)
{
    // Delete images from S3
    foreach ($news->images as $image) {
        Storage::disk('s3')->delete($image->url);
        $image->delete();
    }

    $news->delete();

    return response()->json([
        'message' => 'تم حذف الخبر بنجاح.',
    ], Response::HTTP_OK);
}


}
