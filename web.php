<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Models\Courses\Course;
use App\Models\Courses\CourseCategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');


// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('customer.restaurants');
    Route::get('/restaurants/search', [RestaurantController::class, 'search'])->name('customer.search');
    Route::get('/nearby', [RestaurantController::class, 'nearby'])->name('customer.nearby');
    Route::get('/json/nearby', [RestaurantController::class, 'nearbyJson'])->name('customer.nearby-json');
    Route::get('/view-menu/{restaurant}', [MenuController::class, 'viewMenu'])->name('customer.menu');
    Route::get('/menu-view/', [MenuController::class, 'menuView'])->name('menu.view');
    Route::post('/order', [OrderController::class, 'placeOrder'])->name('customer.order');
    Route::get('/orders', [OrderController::class, 'listOrders'])->name('customer.orders');
    Route::post('/orders/change-order-status', [OrderController::class, 'orderChangeStatus'])->name('customer.change-order-status');
    Route::get('/delivery/{id}/confirm-delivery', [AgentController::class, 'confirmDelivery'])->name('customer.confirm-delivery');
});
// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/destroy-item/{id}', [CartController::class, 'destroyItem'])->name('cart.destroy-item');
    Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add-item');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty-cart');
});


// Restaurant Owner Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/update-profile', function () {
        return view('owner.update-profile');
    })->name('signup-profile');
    Route::post('update-profile', [RestaurantController::class, 'updateProfile'])->name('restaurant.update-profile');
    Route::get('/dashboard', [RestaurantController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/reorders', [OrderController::class, 'listRestaurantOrders'])->name('owner.orders');
    Route::get('/reorders-view/{id}', [OrderController::class, 'restaurantOrder'])->name('owner.view-order');
    Route::post('/reorders-confirm', [OrderController::class, 'restaurantOrderConfirm'])->name('owner.confirm-order');
    Route::post('/reorders-change-status', [OrderController::class, 'restaurantOrderChangeStatus'])->name('owner.change-order-status');
    Route::get('/reports', [RestaurantController::class, 'generateReport'])->name('owner.reports');

    Route::resource('agent',AgentController::class);
    Route::resource('menus',MenuController::class,['except' => ['update','show','destroy']]);

    Route::controller(MenuController::class)->group(function (){
        Route::get('menus/{id}','destroy')->name('menus.destroy');

    });
    Route::controller(AgentController::class)->group(function (){
        Route::get('ajax/op','operations')->name('agent.operations');
        Route::post('agent/set-order','setOrder')->name('agent.assign-order');
    });
});

// Delivery Agent Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/delivery/orders', [AgentController::class, 'tasks'])->name('agent.orders');
    Route::post('/delivery/update', [AgentController::class, 'updateDeliveryStatus'])->name('agent.change-order-status');
});

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('notification',NotificationController::class,['only' => 'show']);
});

// Common Routes

// Catch-All Route
//Route::fallback(function () {
//    return view('errors.404');
//});


require __DIR__ . '/auth.php';
