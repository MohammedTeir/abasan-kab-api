<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddVacancyRequest;
use App\Http\Requests\UpdateVacancyRequest;
use App\Models\Image;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
{
    /**
     * Display a listing of the vacancies.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $vacancies = Vacancy::all();



        return response()->view('cms.vacancies.vacancylist',['vacancies'=>$vacancies]);
    }

    /**
     * Show the form for creating a new vacancy.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.vacancies.create');
    }

    /**
     * Show the form for editing the specified vacancy.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacancy $vacancy)
    {
        return response()->view('cms.vacancies.edit', compact('vacancy'));
    }


    /**
     * Store a newly created vacancy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddVacancyRequest $request)
    {

        $vacancy = Vacancy::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $vacancy->save();

        if ($request->hasFile('image')) {

            $vacancyImage = $request->file('image');
            $currentYear = date('Y');
            $currentMonth = date('m');


                $ex = $vacancyImage->getClientOriginalExtension();
                $name = 'vacancy' . time() * rand(1, 10000000) . '.' . $ex;
                $path = "/development/media/vacancies/{$currentYear}-{$currentMonth}/";

                $image = new Image();
                $image->url = $path.$name;
                $vacancy->image()->save($image);

                $vacancyImage->storeAs($path,$name,'s3');

        }
        $vacancy->save();


        return response()->json([
            'message' => 'تم اٍضافة وظيفة بنجاح.',
        ], Response::HTTP_CREATED);
    }


    /**
     * Update the specified vacancy in storage.
     *
     * @param  UpdateVacancyRequest  $request
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateVacancyRequest $request, Vacancy $vacancy)
    {
        $vacancy->title = $request->input('title',$vacancy->title);
        $vacancy->content = $request->input('content',$vacancy->content);

        if ($request->hasFile('image')) {
            // Delete previous image if it exists
            if ($vacancy->image) {
                Storage::disk('s3')->delete($vacancy->image->url);
                $vacancy->image->delete();
            }

            $vacancyImage = $request->file('image');
            $currentYear = date('Y');
            $currentMonth = date('m');

            $ex = $vacancyImage->getClientOriginalExtension();
            $name = 'vacancy' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/development/media/vacancies/{$currentYear}-{$currentMonth}/";

            $image = new Image();
            $image->url = $path . $name;
            $vacancy->image()->save($image);

            $vacancyImage->storeAs($path, $name, 's3');
        }

        $vacancy->save();

        return response()->json([
            'message' => 'تم تحديث الوظيفة بنجاح.',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified vacancy from storage.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Vacancy $vacancy)
    {
        // Delete the vacancy image if it exists
        if ($vacancy->image) {
            Storage::disk('s3')->delete($vacancy->image->url);
            $vacancy->image->delete();
        }

        $vacancy->delete();

        return response()->json([
            'message' => 'تم حذف الوظيفة بنجاح.',
        ], Response::HTTP_OK);
    }


}
