<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DocumentApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $documents = Document::all();

        $documents->transform(function ($document) {
            $document->document_path = Storage::disk('s3')->url($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully',
        ], 200);
    }




    public function getByCategory(DocumentCategory $category)
    {
        $documents = Document::where('document_category_id', $category->id)->get();

        $documents->transform(function ($document) {
            $document->document_path = Storage::disk('s3')->url($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully based on category',
        ], 200);
    }


    public function getPublicationDocuments()
    {

       $category = DocumentCategory::where('name','إصدارات البلدية')->first();

        $documents = Document::where('document_category_id', $category->id)->get();

        $documents->transform(function ($document) {
            $document->doc_url = Storage::disk('s3')->url($document->document_path);
            unset($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully based on category',
        ], 200);
    }

    public function getRegulationsAndLawsDocuments()
    {

       $category = DocumentCategory::where('name','أنظمة وقوانين')->first();

        $documents = Document::where('document_category_id', $category->id)->get();

        $documents->transform(function ($document) {
            $document->doc_url = Storage::disk('s3')->url($document->document_path);
            unset($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully based on category',
        ], 200);
    }


    public function getUrbanPlanningDocuments()
    {

       $category = DocumentCategory::where('name','التخطيط العمراني')->first();

        $documents = Document::where('document_category_id', $category->id)->get();

        $documents->transform(function ($document) {
            $document->doc_url = Storage::disk('s3')->url($document->document_path);
            unset($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully based on category',
        ], 200);
    }


    public function getInternalAndExternalOversightDocuments()
    {
        $categoryName = 'الرقابة الداخلية و الخارجية';
        $category = DocumentCategory::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Document category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $documents = Document::where('document_category_id', $category->id)->get();

        $documents->transform(function ($document) {
            $document->doc_url = Storage::disk('s3')->url($document->document_path);
            unset($document->document_path);
            $document->category_name = DocumentCategory::find($document->document_category_id)->name;
            return $document;
        });

        return response()->json([
            'data' => $documents,
            'message' => 'Documents retrieved successfully based on category',
        ], 200);
    }

    public function getPublicServicesDirectoryDocument()
    {
        $categoryName = 'اخرى';
        $documentName = 'دليل خدمات الجمهور';

        // Find the document category by name
        $category = DocumentCategory::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Document category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Find the document by category ID and document name
        $document = Document::where('document_category_id', $category->id)
            ->where('name', $documentName)
            ->first();

        if (!$document) {
            return response()->json([
                'message' => 'Document not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $document->doc_url = Storage::disk('s3')->url($document->document_path);

        unset($document->document_path);

        $document->category_name = $category->name;

        return response()->json([
            'data' => $document,
            'message' => 'Document retrieved successfully.',
        ], Response::HTTP_OK);
    }

    public function getOrgchartDocument()
    {
        $categoryName = 'اخرى';
        $documentName = 'المخطط الهيكلي المحدث';

        // Find the document category by name
        $category = DocumentCategory::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Document category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Find the document by category ID and document name
        $document = Document::where('document_category_id', $category->id)
            ->where('name', $documentName)
            ->first();

        if (!$document) {
            return response()->json([
                'message' => 'Document not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $document->doc_url = Storage::disk('s3')->url($document->document_path);

        unset($document->document_path);


        $document->category_name = $category->name;

        return response()->json([
            'data' => $document,
            'message' => 'Document retrieved successfully.',
        ], Response::HTTP_OK);
    }


}
