<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\MunicipalityProject;
use App\Models\MunicipalityProjectsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MunicipalityProjectsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = MunicipalityProject::with('category')->get();

        return response()->json([
            'status' => 'success',
            'data' => $projects,
        ]);
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\MunicipalityProject  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MunicipalityProject $project)
    {
        $project->load(['category', 'images']);

        $project->category_name = $project->category->name;
        unset($project->category);

        $project->images->transform(function ($image) {
            $image->url = Storage::disk('s3')->url($image->url);
            return $image->url; // Modify this line to return only the URL
        });

            // Retrieve the latest 10 related project

        $projects = MunicipalityProject::where('category_id', $project->category_id)
        ->with(['images'])
        ->where('id', '!=', $project->id)
        ->latest()
        ->take(10)
        ->get(['id','title', 'created_at']);

        $projects->transform(function ($project) {
            $firstImage = $project->images->first();
            $project->image = $firstImage ? Storage::disk('s3')->url($firstImage->url) : null;
            unset($project->images);
            return $project;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Project retrieved successfully.',
            'data' => [
            "project"=>$project,
            "related_projects"=>$projects
            ],

        ], Response::HTTP_OK);
    }

    public function getCompletedProjects()
    {

        // Find the category by name
        $category = MunicipalityProjectsCategory::where('name','مشاريع تم تنفيذها')->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $projects = MunicipalityProject::where('category_id', $category->id)
            ->with(['images'])
            ->get();

        if ($projects->isEmpty()) {
                return response()->json([
                    'message' => 'No projects found.',
                    'data' => [],
                ], Response::HTTP_OK);
            }

        $projects->transform(function ($project) {
            $project->category_title = $project->category->name;
            unset($project->category);

            $firstImage = $project->images->first();
            $project->image = $firstImage ? Storage::disk('s3')->url($firstImage->url) : null;
            unset($project->images);

            return $project;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Projects retrieved successfully.',
            'data' => $projects,
        ], Response::HTTP_OK);
    }

    public function getInProgressProjects()
    {

        // Find the category by name
        $category = MunicipalityProjectsCategory::where('name','مشاريع حالية')->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $projects = MunicipalityProject::where('category_id', $category->id)
            ->with(['images'])
            ->get();

            if ($projects->isEmpty()) {
                return response()->json([
                    'message' => 'No projects found.',
                    'data' => [],
                ], Response::HTTP_OK);
            }

        $projects->transform(function ($project) {
            $project->category_title = $project->category->name;
            unset($project->category);

            $firstImage = $project->images->first();
            $project->image = $firstImage ? Storage::disk('s3')->url($firstImage->url) : null;
            unset($project->images);

            return $project;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Projects retrieved successfully.',
            'data' => $projects,
        ], Response::HTTP_OK);
    }


    public function getFutureProjects()
    {

        // Find the category by name
        $category = MunicipalityProjectsCategory::where('name','مشاريع مستقبلية')->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $projects = MunicipalityProject::where('category_id', $category->id)
            ->with(['images'])
            ->get();

            if ($projects->isEmpty()) {
                return response()->json([
                    'message' => 'No projects found.',
                    'data' => [],
                ], Response::HTTP_OK);
            }

        $projects->transform(function ($project) {
            $project->category_title = $project->category->name;
            unset($project->category);

            $firstImage = $project->images->first();
            $project->image = $firstImage ? Storage::disk('s3')->url($firstImage->url) : null;
            unset($project->images);

            return $project;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Projects retrieved successfully.',
            'data' => $projects,
        ], Response::HTTP_OK);
    }


    public function getFundingProjects()
    {

        // Find the category by name
        $category = MunicipalityProjectsCategory::where('name','مشاريع تحتاج تمويل')->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $projects = MunicipalityProject::where('category_id', $category->id)
            ->with(['images'])
            ->get();

            if ($projects->isEmpty()) {
                return response()->json([
                    'message' => 'No projects found.',
                    'data' => [],
                ], Response::HTTP_OK);
            }

        $projects->transform(function ($project) {
            $project->category_title = $project->category->name;
            unset($project->category);

            $firstImage = $project->images->first();
            $project->image = $firstImage ? Storage::disk('s3')->url($firstImage->url) : null;
            unset($project->images);

            return $project;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Projects retrieved successfully.',
            'data' => $projects,
        ], Response::HTTP_OK);
    }




}
