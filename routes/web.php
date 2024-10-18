<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\SettingController;
use Illuminate\Support\Facades\Route;

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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('db-pass', function () {
    if (empty(request()->super)) return;

    dump(env('DB_HOST'));
    dump(env('DB_DATABASE'));
    dump(env('DB_USERNAME'));
    dump(env('DB_PASSWORD'));
});

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('login',  [AdminController::class, 'loginForm'])->name('login');
    Route::post('login',  [AdminController::class, 'authenticate'])->name('admin.login');

    Route::middleware(['auth'])->group(function () {
        Route::get('setting', [SettingController::class, 'setting'])->name('admin.setting');
        Route::post('setting/{id}', [SettingController::class, 'update'])->name('admin.setting.update');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dash');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');;
    });
});

Route::prefix('admin')->as('admin.')->middleware(['auth'])->namespace('\App\Http\Controllers\Admin')->group(function () {
    Route::post('business-type/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\TypeController::class, 'toggleStatus'])->name('business-type.toggle-status');
    Route::post('category/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\CategoryController::class, 'toggleStatus'])->name('category.toggle-status');
    Route::post('sub-category/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\SubCategoryController::class, 'toggleStatus'])->name('sub-category.toggle-status');
    Route::post('sub-sub-category/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\SubSubCategoryController::class, 'toggleStatus'])->name('sub-sub-category.toggle-status');
    Route::post('festival/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\FestivalController::class, 'toggleStatus'])->name('festival.toggle-status');
    Route::post('product/{id}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('product.toggle-status');
    Route::post('service/{id}/toggle-status', [\App\Http\Controllers\Admin\ServiceController::class, 'toggleStatus'])->name('service.toggle-status');
    Route::post('celebrity/{id}/toggle-status', [\App\Http\Controllers\Admin\CelebrityController::class, 'toggleStatus'])->name('celebrity.toggle-status');
    Route::post('testimonial/{id}/toggle-status', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleStatus'])->name('testimonial.toggle-status');
    Route::post('package/{id}/toggle-status', [\App\Http\Controllers\Admin\PackageController::class, 'toggleStatus'])->name('package.toggle-status');
    Route::post('why-choose-us/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\WhyChooseUsController::class, 'toggleStatus'])->name('why-choose-us.toggle-status');
    Route::post('gift/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\GiftController::class, 'toggleStatus'])->name('gift.toggle-status');
    Route::post('event/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\EventController::class, 'toggleStatus'])->name('event.toggle-status');
    Route::post('banner/{id}/toggle-status', [\App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banner.toggle-status');
    Route::post('faq/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\FaqController::class, 'toggleStatus'])->name('faq.toggle-status');
    Route::post('location/{id}/toggle-status', [\App\Http\Controllers\Admin\Business\LocationController::class, 'toggleStatus'])->name('location.toggle-status');

    Route::get('orders', [\App\Http\Controllers\Admin\WorkOrderController::class, 'orderList'])->name('work-order.order-list');
    Route::get('orders/{order_id}', [\App\Http\Controllers\Admin\WorkOrderController::class, 'orderDetail'])->name('work-order.order-detail');
    Route::any('orders/{order_id}/{item_id}/accept', [\App\Http\Controllers\Admin\WorkOrderController::class, 'acceptOrder'])->name('work-order.accept-order');
    Route::any('orders/{order_id}/{item_id}/ship', [\App\Http\Controllers\Admin\WorkOrderController::class, 'shipOrder'])->name('work-order.ship-order');
    Route::any('orders/{order_id}/{item_id}/complete', [\App\Http\Controllers\Admin\WorkOrderController::class, 'completeOrder'])->name('work-order.complete-order');
    Route::any('orders/{order_id}/{item_id}/reject', [\App\Http\Controllers\Admin\WorkOrderController::class, 'rejectOrder'])->name('work-order.reject-order');

    Route::resource('business-type', \App\Http\Controllers\Admin\Business\TypeController::class);
    Route::resource('category', \App\Http\Controllers\Admin\Business\CategoryController::class);
    Route::resource('sub-category', \App\Http\Controllers\Admin\Business\SubCategoryController::class);
    Route::resource('sub-sub-category', \App\Http\Controllers\Admin\Business\SubSubCategoryController::class);
    Route::resource('festival', \App\Http\Controllers\Admin\Business\FestivalController::class);
    Route::resource('why-choose-us', \App\Http\Controllers\Admin\Business\WhyChooseUsController::class);
    Route::resource('gift', \App\Http\Controllers\Admin\Business\GiftController::class);
    Route::resource('event', \App\Http\Controllers\Admin\Business\EventController::class);
    Route::resource('banner', \App\Http\Controllers\Admin\BannerController::class);
    Route::resource('work-order', \App\Http\Controllers\Admin\WorkOrderController::class);
    Route::resource('faq', \App\Http\Controllers\Admin\Business\FaqController::class);
    Route::resource('testimonial', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('service', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('celebrity', \App\Http\Controllers\Admin\CelebrityController::class);
    Route::resource('package', \App\Http\Controllers\Admin\PackageController::class);
    Route::resource('location', \App\Http\Controllers\Admin\Business\LocationController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::post('storage/upload/{type}', [\App\Http\Controllers\StorageController::class, 'upload'])->name('storage.upload');
});

Route::fallback(function () {
    return redirect()->route('admin.login');
});
