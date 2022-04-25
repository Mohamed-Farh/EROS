<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//دا علشان يبغت ايميل تاكيد عند التسجيل
Auth::routes(['verify'=>true]);

Auth::routes();

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');
/*  Country - State - City */
Route::get('/frontGetState',     [FrontendController::class, 'frontGetState'    ])->name('frontend.frontGetState');
Route::get('/frontGetCity',      [FrontendController::class, 'frontGetCity'    ])->name('frontend.frontGetCity');




Route::get('/',             [FrontendController::class, 'index'   ])->name('frontend.index');
Route::get('/about-app',    [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/weather',      [FrontendController::class, 'weather'])->name('frontend.weather');
Route::get('/prayer',       [FrontendController::class, 'prayer'])->name('frontend.prayer');
Route::get('/money',        [FrontendController::class, 'money'])->name('frontend.money');
Route::get('/likes',        [FrontendController::class, 'likes'])->name('frontend.likes');

## buildings
Route::get('/mainBuildings',   [FrontendController::class, 'mainBuildings'])->name('frontend.mainBuildings');
Route::get('/buildings',        [FrontendController::class, 'buildings'])->name('frontend.buildings');
Route::get('/buildingDetails',  [FrontendController::class, 'buildingDetails'])->name('frontend.buildingDetails');
Route::POST('buildingSearch',   [FrontendController::class, 'buildingSearch'])->name('frontend.buildingSearch');
Route::post('buildingLikeAndDislike', [FrontendController::class,'buildingLikeAndDislike'])->name('frontend.buildingLikeAndDislike');
##cars
Route::get('/mainCars',     [FrontendController::class, 'mainCars'])->name('frontend.mainCars');
Route::get('/carTypes',     [FrontendController::class, 'carTypes'])->name('frontend.carTypes');
Route::POST('carTypeSearch',[FrontendController::class, 'carTypeSearch'])->name('frontend.carTypeSearch');
Route::get('/cars',         [FrontendController::class, 'cars'])->name('frontend.cars');
Route::get('/carDetails',   [FrontendController::class, 'carDetails'])->name('frontend.carDetails');
Route::POST('carSearch',    [FrontendController::class, 'carSearch'])->name('frontend.carSearch');
Route::post('carLikeAndDislike', [FrontendController::class,'carLikeAndDislike'])->name('frontend.carLikeAndDislike');
## medicals
Route::get('/medicalMain',  [FrontendController::class, 'medicalMain'])->name('frontend.medicalMain');
Route::get('/medicals',     [FrontendController::class, 'medicals'])->name('frontend.medicals');
Route::get('/medicalDetails',   [FrontendController::class, 'medicalDetails'])->name('frontend.medicalDetails');
Route::POST('medicalSearch',    [FrontendController::class, 'medicalSearch'])->name('frontend.medicalSearch');
Route::post('medicalLikeAndDislike', [FrontendController::class,'medicalLikeAndDislike'])->name('frontend.medicalLikeAndDislike');
## jobs
Route::get('/jobMain',  [FrontendController::class, 'jobMain'])->name('frontend.jobMain');
Route::POST('jobCategorySearch',    [FrontendController::class, 'jobCategorySearch'])->name('frontend.jobCategorySearch');
Route::get('/jobs',     [FrontendController::class, 'jobs'])->name('frontend.jobs');
Route::POST('jobSearch',    [FrontendController::class, 'jobSearch'])->name('frontend.jobSearch');
Route::get('/jobDetails',   [FrontendController::class, 'jobDetails'])->name('frontend.jobDetails');
Route::post('jobLikeAndDislike', [FrontendController::class,'jobLikeAndDislike'])->name('frontend.jobLikeAndDislike');
## products
Route::get('/productMain',  [FrontendController::class, 'productMain'])->name('frontend.productMain');
Route::get('/productSub',  [FrontendController::class, 'productSub'])->name('frontend.productSub');
Route::POST('productCategoryMainSearch',    [FrontendController::class, 'productCategoryMainSearch'])->name('frontend.productCategoryMainSearch');
Route::POST('productCategorySubSearch',    [FrontendController::class, 'productCategorySubSearch'])->name('frontend.productCategorySubSearch');
Route::get('/products',     [FrontendController::class, 'products'])->name('frontend.products');
Route::POST('productSearch',    [FrontendController::class, 'productSearch'])->name('frontend.productSearch');
Route::get('/productDetails',   [FrontendController::class, 'productDetails'])->name('frontend.productDetails');
Route::post('productLikeAndDislike', [FrontendController::class,'productLikeAndDislike'])->name('frontend.productLikeAndDislike');
####################################################################################################################
## Profile ##
Route::get('/profile',    [FrontendController::class, 'profile'])->name('frontend.profile');
Route::get('/editProfile',    [FrontendController::class, 'editProfile'])->name('frontend.editProfile');
Route::POST('updateProfile',    [FrontendController::class, 'updateProfile'])->name('frontend.updateProfile');
Route::get('/editLocation',    [FrontendController::class, 'editLocation'])->name('frontend.editLocation');
Route::POST('updateLocation',    [FrontendController::class, 'updateLocation'])->name('frontend.updateLocation');

Route::get('/advDetails',   [FrontendController::class, 'advDetails'])->name('frontend.advDetails');
Route::post('advLikeAndDislike', [FrontendController::class,'advLikeAndDislike'])->name('frontend.advLikeAndDislike');
####################################################################################################################
## Profile ُEdit Products ##
##Building##
Route::get('/profileEditBuilding',      [FrontendController::class, 'profileEditBuilding'])->name('frontend.profileEditBuilding');
Route::post('profileUpdateBuilding',    [FrontendController::class,'profileUpdateBuilding'])->name('frontend.profileUpdateBuilding');
Route::post('buildingRemoveImage',      [FrontendController::class, 'buildingRemoveImage'])->name('frontend.buildingRemoveImage');
##Car##
Route::get('/profileEditCar',       [FrontendController::class, 'profileEditCar'])->name('frontend.profileEditCar');
Route::post('profileUpdateCar',     [FrontendController::class,'profileUpdateCar'])->name('frontend.profileUpdateCar');
Route::post('carRemoveImage',       [FrontendController::class, 'carRemoveImage'])->name('frontend.carRemoveImage');
##Job##
Route::get('/profileEditJob',   [FrontendController::class, 'profileEditJob'])->name('frontend.profileEditJob');
Route::post('profileUpdateJob', [FrontendController::class,'profileUpdateJob'])->name('frontend.profileUpdateJob');
##Medical Doctor##
Route::get('/profileEditMedicalDoctor',   [FrontendController::class, 'profileEditMedicalDoctor'])->name('frontend.profileEditMedicalDoctor');
Route::post('profileUpdateMedicalDoctor', [FrontendController::class,'profileUpdateMedicalDoctor'])->name('frontend.profileUpdateMedicalDoctor');
##Medical Medicine##
Route::get('/profileEditMedicalMedicine',   [FrontendController::class, 'profileEditMedicalMedicine'])->name('frontend.profileEditMedicalMedicine');
Route::post('profileUpdateMedicalMedicine', [FrontendController::class,'profileUpdateMedicalMedicine'])->name('frontend.profileUpdateMedicalMedicine');
##Product##
Route::get('/profileEditProduct',   [FrontendController::class, 'profileEditProduct'])->name('frontend.profileEditProduct');
Route::post('profileUpdateProduct', [FrontendController::class,'profileUpdateProduct'])->name('frontend.profileUpdateProduct');
Route::post('productRemoveImage',   [FrontendController::class, 'productRemoveImage'])->name('frontend.productRemoveImage');

####################################################################################################################
## Add products ##
Route::get('/addPage',      [FrontendController::class, 'addPage'])->name('frontend.addPage');

##buildings
Route::POST('addFrontBuildings',    [FrontendController::class, 'addFrontBuildings'])->name('frontend.addFrontBuildings');
Route::POST('addFrontCars',    [FrontendController::class, 'addFrontCars'])->name('frontend.addFrontCars');
Route::POST('addFrontProducts',    [FrontendController::class, 'addFrontProducts'])->name('frontend.addFrontProducts');
Route::POST('addFrontJobs',    [FrontendController::class, 'addFrontJobs'])->name('frontend.addFrontJobs');
Route::POST('addFrontDoctors',    [FrontendController::class, 'addFrontDoctors'])->name('frontend.addFrontDoctors');
Route::POST('addFrontMedicines',    [FrontendController::class, 'addFrontMedicines'])->name('frontend.addFrontMedicines');

