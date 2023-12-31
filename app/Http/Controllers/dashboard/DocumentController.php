<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();
        $categories = DocumentCategory::all();



        return response()->view('cms.documents.documentlist',['documents'=>$documents,'categories'=>$categories]);
    }

   /**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public function store(AddDocumentRequest $request)
{
    try {
        $category = DocumentCategory::findOrFail($request->input('document_category_id'));

        // Retrieve the uploaded document
        $documentToStore = $request->file('document');

        // Generate a unique filename
        $name = $request->input('name') . '.' . $documentToStore->getClientOriginalExtension();

        // Define the storage path
        $currentYear = date('Y');
        $currentMonth = date('m');
        $path = "/media/documents/{$category->name}/{$currentYear}-{$currentMonth}/";

        // Store the document in S3 storage
        $documentToStore->storeAs($path, $name, 's3');

        // Create a new document record
        $document = Document::create([
            'name' => $request->input('name'),
            'document_path' => $path . $name,
            'document_category_id' => $request->input('document_category_id'),
        ]);

        return response()->json([
            'message' => 'تم اٍضافة المستند بنجاح',
            'document' => $document,
        ], 201);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        return response()->json([
            'message' => 'حدث خطأ أثناء تخزين المستند.',
        ], 500);
    }
}





   /**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(UpdateDocumentRequest $request, Document $document)
{
    try {
        // Update the document details
        if ($request->filled('name')) {
            $document->name = $request->input('name');
        }

        if ($request->filled('document_category_id')) {
            $category = DocumentCategory::findOrFail($request->input('document_category_id'));
            $document->document_category_id = $request->input('document_category_id');
        }

        // Check if a new document file is uploaded
        if ($request->hasFile('document')) {
            $documentToStore = $request->file('document');
            $currentYear = date('Y');
            $currentMonth = date('m');

            $ex = $documentToStore->getClientOriginalExtension();
            $name = $document->name . '.' . $ex;
            $path = "/media/documents/{$category->name}/{$currentYear}-{$currentMonth}/";

            // Delete the previous document file if it exists
            Storage::disk('s3')->delete($document->document_path);

            // Upload the new document file
            $documentToStore->storeAs($path, $name, 's3');

            // Update the document path
            $document->document_path = $path . $name;
        }

        // Save the changes to the document
        $document->save();

        return response()->json([
            'message' => 'تم تحديث المستند بنجاح',
            'document' => $document,
        ], 200);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        return response()->json([
            'message' => 'حدث خطأ أثناء تحديث المستند.',
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Document $document)
    {

        // Delete the document file from storage
        Storage::disk('s3')->delete($document->document_path);

        // Delete the document record from the database
        $document->delete();

        return response()->json([
            'message' => 'تم حذف المستند بنجاح',
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
}
