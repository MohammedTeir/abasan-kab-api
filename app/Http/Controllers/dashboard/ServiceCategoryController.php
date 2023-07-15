<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ServiceCategory::all();

        return response()->view('services.categorylist',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddServiceCategoryRequest $request)
    {


         ServiceCategory::create([
            'name' => $request->input('name'),
        ]);


        return response()->json([
            'message' => 'تم اضافة تصنيف الخدمة بنجاح.',
        ], Response::HTTP_CREATED);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCategory  $service_category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $service_category)
    {



        $service_category->update([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'تم تحديث فئة الخدمة بنجاح.',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCategory  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServiceCategory $service_category)
    {
        $service_category->delete();

        return response()->json([
            'message' => 'تم حذف فئة الخدمة بنجاح.',
        ], Response::HTTP_OK);
    }

}
