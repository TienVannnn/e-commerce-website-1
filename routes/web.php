<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CartAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerOverviewController;
use App\Http\Controllers\Customer\FavoriteProductController;
use App\Http\Controllers\Customer\HomeController;
use Illuminate\Support\Facades\Route;


#Admin
Route::get('admin/login', [AuthController::class, 'showLoginForm']) -> name('login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::middleware('auth:manager') -> prefix('admin') -> group(function(){
    Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');
    Route::get('/', function(){
        return view('admin.layout_admin.home');
    })-> name('admin.home');
    
    Route::resource('/category', CategoryController::class);
    Route::resource('/menus', MenuController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/tags', TagController::class);
    Route::resource('/sliders', SliderController::class);
    Route::resource('/configs', ConfigController::class);
    Route::resource('/managers', ManagerController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/orders', OrderAdminController::class) -> only('index', 'show');
});

#Customer

Route::get('/', [HomeController::class, 'home']);
Route::get('/category/{slug}', [HomeController::class, 'category']) -> name('category-c');
Route::get('/category/{slugParent}/{slugChild}', [HomeController::class, 'category_child']) -> name('category-child');
// Route::POST('/filter-products', [HomeController::class, 'filterProducts']);
Route::get('/product/{slug}', [HomeController::class, 'product']) -> name('product-c');
Route::get('/product/addToCart/{id}', [CartController::class, 'addToCart']) -> name('addToCart');
Route::get('/product/addFavoriteProduct/{id}', [FavoriteProductController::class, 'addFavoriteProduct']) -> name('addFavoriteProduct');
Route::get('/cart', [CartController::class, 'showCarts']) -> name('client.carts');
Route::post('/update-cart/{id}', [CartController::class, 'updateCart']);
Route::post('/remove-cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkoutPage']) -> name('page_checkout');
Route::post('/cart/checkout', [CartController::class, 'checkout']) -> name('checkout');
Route::get('/login', [CustomerAuthController::class, 'showFormLogin']) -> name('login.customer.form');
Route::post('/login', [CustomerAuthController::class, 'login']) -> name('login.customer');
Route::get('/register', [CustomerAuthController::class, 'showFormRegister']) -> name('register.customer.form');
Route::post('/register', [CustomerAuthController::class, 'register']) -> name('register.customer');

# Overview customer
Route::get('/customer/overview', [CustomerOverviewController::class, 'overview']) -> name('overview');
Route::get('/customer/orders', [CustomerOverviewController::class, 'orders']) -> name('overview.orders');
Route::get('/customer/orders/{id}', [CustomerOverviewController::class, 'order_detail']) -> name('overview.order.detail');
Route::get('/customer/favorites-product', [CustomerOverviewController::class, 'favorites_product']) -> name('overview.favorite');
Route::delete('/customer/delete-favorites-product/{id}', [CustomerOverviewController::class, 'delete_favorite_product']) -> name('delete-favorite-product');
Route::get('/customer/edit-account', [CustomerOverviewController::class, 'edit_account']) -> name('overview.account');
Route::get('/customer/logout', [CustomerAuthController::class, 'logout']) -> name('overview.logout');
Route::post('/customer/edit-account', [CustomerOverviewController::class, 'handleUpdateAccount']) -> name('overview.handleUpdateAccount');
Route::post('/customer/change-password', [CustomerOverviewController::class, 'changePassword']) -> name('overview.changePassword');
Route::post('/customer/delete-account', [CustomerOverviewController::class, 'handleDeleteAccount']) -> name('overview.handleDeleteAccount');

