<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VacancyApiController extends Controller
{
    /**
     * Display a listing of the vacancies.
     *
     * @return \Illuminate\Http\JsonResponse
     */

        public function index()
        {
            $vacancies = Vacancy::all();

            $vacancies->each(function ($vacancy) {
                $vacancyImage = null;
                if ($vacancy->image) {
                    $vacancyImage = Storage::disk('s3')->url($vacancy->image->url);
                }

                $vacancy->unsetRelations();
                $vacancyData = $vacancy->toArray();
                $vacancyData['image_url'] = $vacancyImage;

                $vacancy->setRawAttributes($vacancyData, true);
            });

            return response()->json([
                'message' => 'Successfully retrieved vacancies.',
                'data' => $vacancies,
            ], Response::HTTP_OK);
        }


  



    /**
     * Display the specified vacancy.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Vacancy $vacancy)
    {
        $vacancyImage = null;
        if ($vacancy->image) {
            $vacancyImage = Storage::disk('s3')->url($vacancy->image->url);
        }

        $vacancy->unsetRelations();
        $vacancyData = $vacancy->toArray();
        $vacancyData['image_url'] = $vacancyImage;

        $vacancy->setRawAttributes($vacancyData, true);



    // Retrieve the latest 10 vacancies excluding the current vacancy
    $latestVacancies = Vacancy::where('id', '!=', $vacancy->id)
        ->with('image')
        ->orderByDesc('created_at')
        ->take(10)
        ->get();

        $vacanciesData = [];
        foreach ($latestVacancies as $latestVacancy) {
            $latestVacancyImage = null;
            if ($latestVacancy->image) {
                $latestVacancyImage = Storage::disk('s3')->url($latestVacancy->image->url);
            }

            $latestVacancy->unsetRelations();
            $latestVacancyData = $latestVacancy->toArray();
            $latestVacancyData['image_url'] = $latestVacancyImage;

            $vacanciesData[] = $latestVacancyData;
        }
        return response()->json([
            'message' => 'Successfully retrieved vacancy.',
            'data' => [
                'vacancy' => $vacancy,
                'others_vacancies' => $vacanciesData,
            ],
        ], Response::HTTP_OK);
    }

}
