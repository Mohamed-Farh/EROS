<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdvController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BuildingCategoryController;
use App\Http\Controllers\Backend\BuildingProductController;
use App\Http\Controllers\Backend\CarCategoryController;
use App\Http\Controllers\Backend\CarProductController;
use App\Http\Controllers\Backend\CarTypeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\EmailController;
use App\Http\Controllers\Backend\JobCategoryController;
use App\Http\Controllers\Backend\JobController;
use App\Http\Controllers\Backend\MedicalDoctorController;
use App\Http\Controllers\Backend\MedicalMedicineController;
use App\Http\Controllers\Backend\MedicalNurseController;
use App\Http\Controllers\Backend\PhoneController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SocialMediaController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UserController;
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

Route::group(['prefix' => 'admin', 'as'=>'admin.' ], function(){

    Route::group(['middleware' => 'guest' ], function(){

        Route::get('/login',               [BackendController::class, 'login'    ])->name('login');
        Route::get('/forget_password',     [BackendController::class, 'forget_password'])->name('forget_password');
    });


        //==========================================================================================================
        Route::group(['middleware' => ['roles', 'role:superAdmin|admin|user'] ], function(){

            Route::get('/',               [BackendController::class, 'index'    ])->name('index_route');
            Route::get('/index',          [BackendController::class, 'index'    ])->name('index');
            /*  Country - State - City */
            Route::get('/getState',     [BackendController::class, 'get_state'    ])->name('backend.get_state');
            Route::get('/getCity',      [BackendController::class, 'get_city'    ])->name('backend.get_city');

            /*-------------------------------- */
            /*  Buildings   */
            Route::resource('buildings',BuildingCategoryController::class);
            Route::post('/buildings/removeImage', [BuildingCategoryController::class, 'removeImage'])->name('buildings.removeImage');
            Route::post('/buildingsDestroyAll', [BuildingCategoryController::class,'buildingsDestroyAll'])->name('buildings.buildingsDestroyAll');
            Route::get('buildingCategoriesUpdateStatus', [BuildingCategoryController::class,'updateStatus'])->name('buildings.buildingCategoriesUpdateStatus');
            /*  Building Products   */
            Route::resource('buildingProducts',BuildingProductController::class);
            Route::post('/buildingProducts/removeImage', [BuildingProductController::class, 'removeImage'])->name('buildingProducts.removeImage');
            Route::post('/buildingProducts/destroyAll', [BuildingProductController::class,'massDestroy'])->name('buildingProducts.massDestroy');
            Route::get('buildingProductsUpdateStatus', [BuildingProductController::class,'updateStatus'])->name('buildingProducts.updateStatus');
            /*  Country - State - City */
            Route::get('/buildingProductsGetState',     [BuildingProductController::class, 'get_state'    ])->name('buildingProducts.get_state');
            Route::get('/buildingProductsGetCity',      [BuildingProductController::class, 'get_city'    ])->name('buildingProducts.get_city');


            /*-------------------------------- */
            /*  Car Categories  */
            Route::resource('carCategories',CarCategoryController::class);
            Route::post('/carCategories/removeImage', [CarCategoryController::class, 'removeImage'])->name('carCategories.removeImage');
            Route::post('/carCategories/destroyAll', [CarCategoryController::class,'massDestroy'])->name('carCategories.massDestroy');
            Route::get('carCategoriesUpdateStatus', [CarCategoryController::class,'updateStatus'])->name('carCategories.updateStatus');
            /*  Car Types  */
            Route::resource('carTypes',CarTypeController::class);
            Route::post('/carTypes/removeImage', [CarTypeController::class, 'removeImage'])->name('carTypes.removeImage');
            Route::post('/carTypes/destroyAll', [CarTypeController::class,'massDestroy'])->name('carTypes.massDestroy');
            Route::get('carTypesUpdateStatus', [CarTypeController::class,'updateStatus'])->name('carTypes.updateStatus');
            /*  Car Products   */
            Route::resource('carProducts',CarProductController::class);
            Route::post('/carProducts/removeImage', [CarProductController::class, 'removeImage'])->name('carProducts.removeImage');
            Route::post('/carProducts/destroyAll', [CarProductController::class,'massDestroy'])->name('carProducts.massDestroy');
            Route::get('carProductsUpdateStatus', [CarProductController::class,'updateStatus'])->name('carProducts.updateStatus');
            /*  Country - State - City */
            Route::get('/carProductsGetState',     [CarProductController::class, 'get_state'    ])->name('carProducts.get_state');
            Route::get('/carProductsGetCity',      [CarProductController::class, 'get_city'    ])->name('carProducts.get_city');

            /*-------------------------------- */
            /*  Medicals Doctors */
            Route::resource('medicalDoctors',MedicalDoctorController::class);
            Route::post('/medicalDoctors/destroyAll', [MedicalDoctorController::class,'massDestroy'])->name('medicalDoctors.massDestroy');
            Route::get('medicalDoctorsUpdateStatus', [MedicalDoctorController::class,'updateStatus'])->name('medicalDoctors.updateStatus');
            /*  Medicals Nurses */
            Route::resource('medicalNurses',MedicalNurseController::class);
            Route::post('/medicalNurses/destroyAll', [MedicalNurseController::class,'massDestroy'])->name('medicalNurses.massDestroy');
            Route::get('medicalNursesUpdateStatus', [MedicalNurseController::class,'updateStatus'])->name('medicalNurses.updateStatus');
            /*  Medicals Medicines */
            Route::resource('medicalMedicines',MedicalMedicineController::class);
            Route::post('/medicalMedicines/destroyAll', [MedicalMedicineController::class,'massDestroy'])->name('medicalMedicines.massDestroy');
            Route::get('medicalMedicinesUpdateStatus', [MedicalNurseController::class,'updateStatus'])->name('medicalMedicines.updateStatus');


            /*-------------------------------- */
            /*  Job Category */
            Route::resource('jobCategories',JobCategoryController::class);
            Route::post('/jobCategories/destroyAll', [JobCategoryController::class,'massDestroy'])->name('jobCategories.massDestroy');
            Route::get('jobCategoriesUpdateStatus', [JobCategoryController::class,'updateStatus'])->name('jobCategories.updateStatus');
            /*  Job Category */
            Route::resource('jobs',JobController::class);
            Route::post('/jobs/destroyAll', [JobController::class,'massDestroy'])->name('jobs.massDestroy');
            Route::get('jobsUpdateStatus', [JobController::class,'updateStatus'])->name('jobs.updateStatus');




            /*-------------------------------- */
            /*  Category   */
            Route::resource('categories',CategoryController::class);
            Route::post('/categories/removeImage', [CategoryController::class, 'removeImage'])->name('categories.removeImage');
            Route::post('categories/destroyAll', [CategoryController::class,'massDestroy'])->name('categories.massDestroy');
            Route::get('changeStatus', [CategoryController::class,'changeStatus'])->name('categories.changeStatus');

            /*  Tags   */
            Route::resource('tags',TagController::class);
            Route::post('tags-destroyAll', [TagController::class,'massDestroy'])->name('tags.massDestroy');
            Route::get('tags-changeStatus', [TagController::class,'changeStatus'])->name('tags.changeStatus');

            /*  Products   */
            Route::resource('products',ProductController::class);
            Route::post('products-removeImage', [ProductController::class, 'removeImage'])->name('products.removeImage');
            Route::post('products-destroyAll', [ProductController::class,'massDestroy'])->name('products.massDestroy');
            Route::get('products-changeStatus', [ProductController::class,'changeStatus'])->name('products.changeStatus');

            /*-------------------------------- */
            /*  Admins   */
            Route::resource('admins'    ,AdminController::class);
            Route::post('admins-removeImage', [AdminController::class,'removeImage'])->name('admins.removeImage');
            Route::get('admins-changeStatus', [AdminController::class,'changeStatus'])->name('admins.changeStatus');
            Route::post('admins-destroyAll', [AdminController::class,'massDestroy'])->name('admins.massDestroy');
            /*  Users   */
            Route::resource('users'    ,UserController::class);
            Route::post('users-removeImage', [UserController::class,'removeImage'])->name('users.removeImage');
            Route::get('users-changeStatus', [UserController::class,'changeStatus'])->name('users.changeStatus');
            Route::post('users-destroyAll', [UserController::class,'massDestroy'])->name('users.massDestroy');


            /*-------------------------------- */
            /*  advs   */
            Route::resource('advs'    ,AdvController::class);
            Route::post('advs-removeImage', [AdvController::class,'removeImage'])->name('advs.removeImage');
            Route::get('advs-changeStatus', [AdvController::class,'changeStatus'])->name('advs.changeStatus');
            Route::post('advsDestroyAll', [AdvController::class,'advsDestroyAll'])->name('advs.advsDestroyAll');


            /*-------------------------------- */
            /*  Customers   */
            Route::resource('customers'    ,CustomerController::class);
            Route::get('/getCustomerSearch',  [CustomerController::class, 'getCustomerSearch'    ])->name('customers.getCustomerSearch');
            Route::post('customers-removeImage', [CustomerController::class,'removeImage'])->name('customers.removeImage');
            Route::get('customers-changeStatus', [CustomerController::class,'changeStatus'])->name('customers.changeStatus');
            Route::post('customersDestroyAll', [CustomerController::class,'massDestroy'])->name('customers.customersDestroyAll');



            /*  countries   */
            Route::resource('countries'    ,CountryController::class);
            Route::get('countries-changeStatus', [CountryController::class,'changeStatus'])->name('countries.changeStatus');
            Route::post('countries-destroyAll', [CountryController::class,'massDestroy'])->name('countries.massDestroy');
            /*  countries   */
            Route::resource('states'    ,StateController::class);
            Route::get('states-changeStatus', [StateController::class,'changeStatus'])->name('states.changeStatus');
            Route::post('states-destroyAll', [StateController::class,'massDestroy'])->name('states.massDestroy');
            /*  countries   */
            Route::resource('cities'    ,CityController::class);
            Route::get('cities-changeStatus', [CityController::class,'changeStatus'])->name('cities.changeStatus');
            Route::post('cities-destroyAll', [CityController::class,'massDestroy'])->name('cities.massDestroy');


            /*  socials   */
            Route::resource('socials'    ,SocialMediaController::class);
            Route::get('socials-changeStatus', [SocialMediaController::class,'changeStatus'])->name('socials.changeStatus');
            Route::post('socials-destroyAll', [SocialMediaController::class,'massDestroy'])->name('socials.massDestroy');
            /*  phones   */
            Route::resource('phones'    ,PhoneController::class);
            Route::get('phones-changeStatus', [PhoneController::class,'changeStatus'])->name('phones.changeStatus');
            Route::post('phones-destroyAll', [PhoneController::class,'massDestroy'])->name('phones.massDestroy');
            /*  emails   */
            Route::resource('emails'    ,EmailController::class);
            Route::get('emails-changeStatus', [EmailController::class,'changeStatus'])->name('emails.changeStatus');
            Route::post('emails-destroyAll', [EmailController::class,'massDestroy'])->name('emails.massDestroy');


            /*  about   */
            Route::resource('abouts'    ,AboutController::class);
            Route::post('ckeditor/upload', [AboutController::class, 'upload'])->name('ckeditor.upload');

        });

});
