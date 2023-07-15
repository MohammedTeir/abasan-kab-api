<?php

use App\Http\Controllers\api\ActivationApiController;
use App\Http\Controllers\api\AdApiController;
use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\CouncilMemberApiController;
use App\Http\Controllers\api\DepartmentApiController;
use App\Http\Controllers\api\DocumentApiController;
use App\Http\Controllers\api\DocumentCategoryApiController;
use App\Http\Controllers\api\GalleryApiController;
use App\Http\Controllers\api\MayorSpeechApiController;
use App\Http\Controllers\api\MunicipalityAboutApiController;
use App\Http\Controllers\api\MunicipalityProjectsApiController;
use App\Http\Controllers\api\MunicipalityProjectsCategoryApiController;
use App\Http\Controllers\api\MunicipalitySettingApiController;
use App\Http\Controllers\api\NewsApiController;
use App\Http\Controllers\api\ServiceApiController;
use App\Http\Controllers\api\ServiceCategoryApiController;
use App\Http\Controllers\api\VacancyApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('auth/login',[AuthApiController::class,'login']);

Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/service-request/{serviceCategory}/{service}',[AuthApiController::class,'makeServiceRequest'])->middleware('has.address');
    Route::get('/service-requests', [AuthApiController::class, 'getServiceRequests']);
    Route::post('/reset-password', [AuthApiController::class, 'resetPassword']);
    Route::post('/complaint', [AuthApiController::class, 'makeComplaint'])->middleware('has.address');
    Route::get('/my-complaints', [AuthApiController::class, 'myComplaints']);
    Route::post('/address', [AuthApiController::class, 'addAddress']);
    Route::post('/update-profile-image', [AuthApiController::class, 'updateProfileImage']);

});




Route::get('testapi', function(){
    return response()->json(['message'=>'api work succcessfully']);
});



Route::prefix('municipality-settings')->group(function () {
    Route::get('/', [MunicipalitySettingApiController::class, 'show']);
    Route::post('/', [MunicipalitySettingApiController::class, 'store']);
    Route::post('/cover-images', [MunicipalitySettingApiController::class, 'addCoverImages']);
    Route::get('/cover-images', [MunicipalitySettingApiController::class, 'getCoverImages']);
});



    Route::get('/municipality-about', [MunicipalityAboutApiController::class, 'show']);


    Route::group(['prefix' => 'news'], function () {
    Route::get('/', [NewsApiController::class, 'index']);
    Route::get('/{news}', [NewsApiController::class, 'show']);
    });


    Route::group(['prefix' => 'ads'], function () {
        Route::get('/', [AdApiController::class, 'index']);
        Route::post('/', [AdApiController::class, 'store']);
        Route::get('/{ad}', [AdApiController::class, 'show']);
        });

    Route::prefix('vacancies')->group(function () {
            Route::get('/', [VacancyApiController::class, 'index']);
            Route::get('/{vacancy}', [VacancyApiController::class, 'show']);
            Route::post('/', [VacancyApiController::class, 'store']);

        });

    Route::group(['prefix' => 'mayor-speech'], function () {
        Route::post('/', [MayorSpeechApiController::class, 'store']);
        Route::get('/', [MayorSpeechApiController::class, 'show']);
});

Route::get('/council-members', [CouncilMemberApiController::class, 'index'])->name('api.council-members.index');


 // Routes for Municipality Projects Categories
 Route::prefix('project-categories')->group(function () {
    Route::get('/', [MunicipalityProjectsCategoryApiController::class, 'index']);
    Route::post('/', [MunicipalityProjectsCategoryApiController::class, 'store']);
    Route::put('/{category}', [MunicipalityProjectsCategoryApiController::class, 'update']);
    Route::delete('/{category}', [MunicipalityProjectsCategoryApiController::class, 'destroy']);
});

// Routes for Municipality Projects
Route::prefix('projects')->group(function () {
    Route::get('/', [MunicipalityProjectsApiController::class, 'index']);
    Route::post('/', [MunicipalityProjectsApiController::class, 'store']);
    Route::get('/completed-projects', [MunicipalityProjectsApiController::class, 'getCompletedProjects']);
    Route::get('/in-progress-projects', [MunicipalityProjectsApiController::class, 'getInProgressProjects']);
    Route::get('/future-projects', [MunicipalityProjectsApiController::class, 'getFutureProjects']);
    Route::get('/funding-projects', [MunicipalityProjectsApiController::class, 'getFundingProjects']);
    Route::get('/{project}', [MunicipalityProjectsApiController::class, 'show']);
});


Route::get('/users/{pin}/validate', [ActivationApiController::class,'validatePin']);
Route::get('/users/{pin}/{phone}/check', [ActivationApiController::class,'checkPhoneNumberOwnership']);
Route::post('/activation-code', [ActivationApiController::class, 'sendActivationCode']);
Route::post('/verify-activation-code', [ActivationApiController::class, 'verifyActivationCode']);


Route::prefix('service-categories')->group(function () {
    Route::get('/', [ServiceCategoryApiController::class, 'index']);
    Route::post('/', [ServiceCategoryApiController::class, 'store']);
    Route::put('/{category}', [ServiceCategoryApiController::class, 'update']);
    Route::delete('/{category}', [ServiceCategoryApiController::class, 'destroy']);
});

// Service Routes
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceApiController::class, 'index']);
    Route::post('/', [ServiceApiController::class, 'store']);
    Route::get('/category/{category}', [ServiceApiController::class, 'getServicesByCategory']);
});


Route::group(['prefix' => 'departments'], function () {
    Route::get('/', [DepartmentApiController::class, 'index']);
    Route::post('/', [DepartmentApiController::class, 'store']);
    Route::put('/{department}', [DepartmentApiController::class, 'update']);
    Route::delete('/{department}', [DepartmentApiController::class, 'destroy']);
});

Route::prefix('document-categories')->group(function () {
    Route::get('/', [DocumentCategoryApiController::class, 'index']);
    Route::post('/', [DocumentCategoryApiController::class, 'store']);
    Route::put('/{id}', [DocumentCategoryApiController::class, 'update']);
    Route::delete('/{id}', [DocumentCategoryApiController::class, 'destroy']);
});


Route::prefix('documents')->group(function () {
    Route::get('/', [DocumentApiController::class, 'index']);
    Route::get('/getByCategory/{category}', [DocumentApiController::class, 'getByCategory']);
    Route::post('/', [DocumentApiController::class, 'store']);
    Route::get('/publication-documents', [DocumentApiController::class, 'getPublicationDocuments']);
    Route::get('/regulations-and-laws-documents', [DocumentApiController::class, 'getRegulationsAndLawsDocuments']);
    Route::get('/urban-planning-documents', [DocumentApiController::class, 'getUrbanPlanningDocuments']);
    Route::get('/internal-and-external-oversight-documents', [DocumentApiController::class, 'getInternalAndExternalOversightDocuments']);
    Route::get('/public-services-directory-document', [DocumentApiController::class, 'getPublicServicesDirectoryDocument']);
    Route::get('/orgchart-document', [DocumentApiController::class, 'getOrgchartDocument']);
});


Route::prefix('albums')->group(function () {
    Route::post('/', [GalleryApiController::class, 'addAlbum']);
    Route::get('/', [GalleryApiController::class, 'getAllAlbums']);
    Route::get('/{album}', [GalleryApiController::class, 'getAlbum']);
});

Route::prefix('videos')->group(function () {
    Route::post('/', [GalleryApiController::class, 'addVideo']);
    Route::get('/', [GalleryApiController::class, 'getAllVideos']);
});
