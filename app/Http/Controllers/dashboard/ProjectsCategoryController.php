<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProjectsCategoryRequest;
use App\Models\MunicipalityProjectsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProjectsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = MunicipalityProjectsCategory::all(['id','name']);

        return response()->view('cms.projects.categorylist',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddProjectsCategoryRequest $request)
    {


         MunicipalityProjectsCategory::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'تم إنشاء التصنيف بنجاح',
        ], Response::HTTP_CREATED);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MunicipalityProjectsCategory  $project_category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, MunicipalityProjectsCategory $project_category)
    {

        $project_category->update($request->only('name'));

        return response()->json([
            'message' => 'تم تحديث التصنيف بنجاح',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MunicipalityProjectsCategory  $project_category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MunicipalityProjectsCategory $project_category)
    {
        $project_category->delete();

        return response()->json([
            'message' => 'تم حذف التصنيف بنجاح',
        ],200);
    }
}
