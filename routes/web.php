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
Route::get('/frontState',     [FrontendController::class, 'frontState'    ])->name('frontend.frontState');
Route::get('/frontCity',      [FrontendController::class, 'frontCity'    ])->name('frontend.frontCity');

/* products */
Route::any('/getProducts/{id}',      [FrontendController::class, 'getProducts']);



Route::get('/',             [FrontendController::class, 'index'   ])->name('frontend.index');

Route::get('categories',     [FrontendController::class, 'categories'    ])->name('frontend.categories');
Route::get('/categories/{category}',   [FrontendController::class, 'categoryDetails'  ]);
Route::get('/productDetails',   [FrontendController::class, 'productDetails'])->name('frontend.productDetails');

Route::post('send-contact-message',     [FrontendController::class, 'sendContactMessage'    ])->name('frontend.send-contact-message');
Route::get('/contact-us',    [FrontendController::class, 'contactUs'])->name('frontend.contact-us');
Route::get('/about-us',    [FrontendController::class, 'aboutUs'])->name('frontend.about-us');
Route::get('/booking',    [FrontendController::class, 'booking'])->name('frontend.booking');
Route::post('booking-booking',     [FrontendController::class, 'bookingBooking'    ])->name('frontend.booking-booking');
Route::get('/profile',    [FrontendController::class, 'profile'])->name('frontend.profile');



## Profile ##
Route::get('/profile',    [FrontendController::class, 'profile'])->name('frontend.profile');
Route::get('/editProfile',    [FrontendController::class, 'editProfile'])->name('frontend.editProfile');
Route::POST('updateProfile',    [FrontendController::class, 'updateProfile'])->name('frontend.updateProfile');
Route::get('/editLocation',    [FrontendController::class, 'editLocation'])->name('frontend.editLocation');
Route::POST('updateLocation',    [FrontendController::class, 'updateLocation'])->name('frontend.updateLocation');

