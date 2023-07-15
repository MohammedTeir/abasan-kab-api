<?php

use App\Http\Controllers\dashboard\AdController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\AlbumController;
use App\Http\Controllers\dashboard\ComplaintController;
use App\Http\Controllers\dashboard\CouncilMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardAuthController;
use App\Http\Controllers\dashboard\DepartmentController;
use App\Http\Controllers\dashboard\DocumentCategoryController;
use App\Http\Controllers\dashboard\DocumentController;
use App\Http\Controllers\dashboard\InformationController;
use App\Http\Controllers\dashboard\NewsController;
use App\Http\Controllers\dashboard\ProjectController;
use App\Http\Controllers\dashboard\ProjectsCategoryController;
use App\Http\Controllers\dashboard\RoleController;
use App\Http\Controllers\dashboard\ServiceCategoryController;
use App\Http\Controllers\dashboard\ServiceController;
use App\Http\Controllers\dashboard\ServiceRequestController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\VacancyController;
use App\Http\Controllers\dashboard\VideoController;
use App\Http\Controllers\NotificationController;
use App\Models\Document;
use App\Models\MunicipalityProject;
use App\Models\News;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vacancy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('local');

Route::middleware('guest:admin')->prefix('dashboard')->group(function () {

    Route::get('/login', [DashboardAuthController::class, 'showLogin'])->name('dashboard.showLogin');
    Route::post('/login', [DashboardAuthController::class, 'login'])->name('dashboard.login');

    Route::get('/forgetpassword', [DashboardAuthController::class, 'forgot'])->name('forgot');
    Route::post('/reset', [DashboardAuthController::class, 'resetPassword']);
});

Route::middleware('auth:admin')->prefix('dashboard')->group(function () {

    Route::view('/', 'index',[
        // 'totalUsers' => User::count(),
        // 'totalNews' => News::count(),
        // 'totalProjects' => MunicipalityProject::count(),
        // 'totalVacanicies' => Vacancy::count(),
        // 'recentDocuments' => Document::latest()->take(5)->get(),
        // 'latestProjects' => MunicipalityProject::latest()->take(5)->get(),

    ])->name('dashboard.home');
    Route::get('/logout', [DashboardAuthController::class, 'logout'])->name('dashboard.logout');
    Route::get('/my-profile', [DashboardAuthController::class, 'myProfile'])->name('dashboard.profile');
    Route::match(['put', 'patch'],'/update', [DashboardAuthController::class, 'updateProfile'])->name('dashboard.update');
    Route::post('/update-image', [DashboardAuthController::class, 'updateProfileImage'])->name('dashboard.updateImage');
    Route::get('/users', [UserController::class, 'index'])->name('dashboard.usersList');
    Route::resource('/admins',AdminController::class)->except(['edit','show','update']);
    Route::match(['put', 'patch'],'/admins/{admin}/restore/',[AdminController::class,'restore'])->name('admins.restore');
    Route::match(['put', 'patch'],'/admins/{admin}/restrict/',[AdminController::class,'restrictAccount'])->name('admins.restrict');

    Route::resource('/document-categories', DocumentCategoryController::class)->except(['create','edit','show']);
    Route::resource('/project-categories', ProjectsCategoryController::class)->except(['create','edit','show']);
    Route::resource('/service-categories', ServiceCategoryController::class)->except(['create','edit','show']);

    Route::resource('/documents', DocumentController::class)->except(['create','edit','show','update']);
    Route::post('/documents/{document}', [DocumentController::class, 'update']);
    Route::get('/documents/getByCategory/{category}', [DocumentController::class, 'getByCategory']);

    Route::resource('/news', NewsController::class)->except(['show','update']);
    Route::get('/news/filter', [NewsController::class, 'filterNews'])->name('news.filter');
    Route::post('/news/{news}', [NewsController::class, 'update']);

    Route::resource('/projects', ProjectController::class)->except(['show','update']);
    Route::post('/projects/{project}', [ProjectController::class, 'update']);

    Route::resource('/ads', AdController::class)->except(['show','update']);
    Route::post('/ads/{ad}', [AdController::class, 'update']);

    Route::resource('/vacancies', VacancyController::class)->except(['show','update']);
    Route::post('/vacancies/{vacancy}', [VacancyController::class, 'update']);

    Route::resource('/albums', AlbumController::class)->except(['show','update']);
    Route::post('/albums/{album}', [AlbumController::class, 'update']);

    Route::resource('/videos', VideoController::class)->except(['show','update','create','edit']);
    Route::post('/videos/{video}', [VideoController::class, 'update']);

    Route::resource('/services', ServiceController::class)->except(['show','create','edit']);


    Route::get('/service-requests/in-progress', [ServiceRequestController::class, 'getInProgress'])->name('service-requests.in-progress');
    Route::get('/service-requests/accepted', [ServiceRequestController::class, 'getAccepted'])->name('service-requests.accepted');
    Route::get('/service-requests/rejected', [ServiceRequestController::class, 'getRejected'])->name('service-requests.rejected');
    Route::get('/service-requests/{serviceRequest}/download-archive', [ServiceRequestController::class, 'downloadArchive'])->name('service-requests.download-archive');
    Route::put('/service-requests/accept/{serviceRequest}', [ServiceRequestController::class, 'accept'])->name('service-requests.accept');
    Route::put('/service-requests/reject/{serviceRequest}', [ServiceRequestController::class, 'reject'])->name('service-requests.reject');


    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAllNotifications'])->name('notifications.clear-all');
    Route::put('/notifications/mark-as-read/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');


    Route::get('/informations', [InformationController::class, 'index'])->name('informations.index');
    Route::post('/informations/mayor-speech', [InformationController::class, 'AddMayorSpeech'])->name('informations.add-mayor-speech');
    Route::post('/informations/setting', [InformationController::class, 'AddSetting'])->name('informations.add-setting');
    Route::post('/informations/cover-images', [InformationController::class, 'addCoverImages'])->name('informations.add-cover-images');
    Route::post('/informations/about', [InformationController::class, 'AddMunicipalityAbout'])->name('informations.add-municipality-about');


    Route::resource('/departments', DepartmentController::class)->except(['create','edit','show']);


    Route::prefix('/complaints')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/closed', [ComplaintController::class, 'getClosedComplaints'])->name('complaints.closed');
        Route::get('/in-progress', [ComplaintController::class, 'getInProgressComplaints'])->name('complaints.in-progress');
        Route::get('/open', [ComplaintController::class, 'getOpenComplaints'])->name('complaints.open');
        Route::put('/{complaint}/mark-closed', [ComplaintController::class, 'markComplaintAsClosed'])->name('complaints.mark-closed');
        Route::put('/{complaint}/mark-in-progress', [ComplaintController::class, 'markComplaintAsInProgress'])->name('complaints.mark-in-progress');
    });

    Route::prefix('/members')->group(function () {
        Route::get('/', [CouncilMemberController::class, 'index'])->name('members.index');
        Route::post('/', [CouncilMemberController::class, 'addMember'])->name('members.add');
        Route::post('/{member}', [CouncilMemberController::class, 'update'])->name('members.update');
        Route::delete('/{member}', [CouncilMemberController::class, 'destroy'])->name('members.destroy');
    });

    Route::get('/complaints/{complaint}/download-pdf', [ComplaintController::class, 'downloadComplaintAsPdf'])->name('complaints.download-pdf');

    Route::resource('roles', RoleController::class)->except(['create','edit']);
    Route::delete('roles/revoke/{role}/{admin}', [RoleController::class,'revokeRole'])->name('roles.revoke');


});




