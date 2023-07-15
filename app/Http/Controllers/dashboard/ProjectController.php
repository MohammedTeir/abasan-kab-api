<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Image;
use App\Models\MunicipalityProject;
use App\Models\MunicipalityProjectsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = MunicipalityProject::all();

        return response()->view('cms.projects.projectlist',['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new news.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectCategories = MunicipalityProjectsCategory::all();
        return response()->view('cms.projects.create',['projectCategories'=>$projectCategories]);
    }


        public function edit(MunicipalityProject $project)
    {

        // Modify the $news object to include the transformed tags
        $projectCategories = MunicipalityProjectsCategory::all();

        return response()->view('cms.projects.edit', ['project' => $project,'projectCategories'=>$projectCategories]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddProjectRequest $request)
    {


        $project = MunicipalityProject::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
        ]);

        $project->save();


        if ($request->hasFile('project_images')) {

            $projectImages = $request->file('project_images');
            $currentYear = date('Y');
            $currentMonth = date('m');

            foreach ($projectImages as $projectImage) {
                $ex = $projectImage->getClientOriginalExtension();
                $name = 'project' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/media/projects/{$currentYear}-{$currentMonth}/";

                $image = new Image();
                $image->url = $path.$name;
                $project->images()->save($image);

                $projectImage->storeAs($path,$name,'s3');
            }
        }

        $project->save();



        return response()->json([
            'message' => 'تم اٍضافة المشروع بنجاح.',
        ], Response::HTTP_CREATED);
    }


    public function update(UpdateProjectRequest $request,MunicipalityProject $project)
    {

    $project->title = $request->input('title', $project->title);
    $project->content = $request->input('content', $project->content);
    $project->category_id = $request->input('category_id', $project->category_id);

    // Update any other fields as needed

    $project->save();

    // Handle project images update if necessary
    if ($request->hasFile('project_images')) {
        // Delete existing images from S3
        foreach ($project->images as $image) {
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

        $projectImages = $request->file('project_images');
        $currentYear = date('Y');
        $currentMonth = date('m');

        foreach ($projectImages as $projectImage) {
            $ex = $projectImage->getClientOriginalExtension();
            $name = 'project' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/media/projects/{$currentYear}-{$currentMonth}/";

            $image = new Image();
            $image->url = $path . $name;
            $project->images()->save($image);

            $projectImage->storeAs($path, $name, 's3');
        }
    }

    return response()->json([
        'message' => 'تم تحديث المشروع بنجاح.',
    ], Response::HTTP_OK);
}


    public function destroy(MunicipalityProject $project)
    {
        // Delete images from S3
        foreach ($project->images as $image) {
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

        $project->delete();

        return response()->json([
            'message' => 'تم حذف المشروع بنجاح.',
        ], Response::HTTP_OK);
    }




}
