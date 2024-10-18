<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CelebrityController;
use App\Http\Controllers\Api\V1\FestivalController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\WhyChooseUsController;
use App\Http\Controllers\Api\V1\WorkOrderController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    
    // Route::middleware('auth:sanctum')->group(function () {
    
        Route::get('home', [HomeController::class, 'index']);
        Route::post('cart/item-detail', [CartController::class, 'index']);
        Route::post('order', [OrderController::class, 'create']);
        Route::post('order/list', [OrderController::class, 'list']);

        Route::get('settings', [HomeController::class, 'config']);
        Route::get('testimonials', [TestimonialController::class, 'index']);
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('business-services', [CategoryController::class, 'services']);
        Route::get('why-choose-us', [WhyChooseUsController::class, 'index']);
        Route::get('banners', [BannerController::class, 'index']);
        Route::get('faqs', [FaqController::class, 'index']);
        Route::get('locations', [LocationController::class, 'index']);

        Route::get('festivals', [FestivalController::class, 'index']);
        Route::get('festivals/{slug}', [FestivalController::class, 'detail']);
        
        Route::get('events', [EventController::class, 'index']);
        Route::get('events/{slug}', [EventController::class, 'detail']);

        Route::get('celebrities', [CelebrityController::class, 'index']);
        Route::get('celebrities/{slug}', [CelebrityController::class, 'detail']);

        Route::get('packages', [PackageController::class, 'index']);
        Route::get('packages/{slug}', [PackageController::class, 'detail']);
        
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{slug}', [ProductController::class, 'detail']);
        
        Route::get('services', [ServiceController::class, 'index']);
        Route::get('services/{slug}', [ServiceController::class, 'detail']);

        Route::post('work-order', [WorkOrderController::class, 'create']);
    // });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // echo $request->user()->tokenCan('service:read');
//     // return $request->user();
// });
