<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDocumentsCategoryRequest;
use App\Http\Requests\UpdateDocumentsCategoryRequest;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DocumentCategory::all();

        return response()->view('cms.documents.categorylist',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddDocumentsCategoryRequest $request)
    {

       DocumentCategory::create($request->only('name'));

        return response()->json([
            'message' => 'تم إنشاء التصنيف بنجاح',
        ], 201);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DocumentCategory  $document_category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDocumentsCategoryRequest $request,DocumentCategory $document_category)
    {


        $document_category->update($request->only('name'));

        return response()->json([
            'message' => 'تم تحديث التصنيف بنجاح',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DocumentCategory  $document_category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DocumentCategory $document_category)
    {
        $document_category->delete();

        return response()->json([
            'message' => 'تم حذف التصنيف بنجاح',
        ], 200);
    }

}
