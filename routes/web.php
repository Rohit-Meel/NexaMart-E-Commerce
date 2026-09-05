<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\OfferController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\CustomerAccountController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Models\Admin;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index']) ->name('products');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');  
Route::get('/about', [AboutController::class, 'index']) ->name('about');    
Route::get('/contact', [ContactController::class, 'index']) ->name('contact');  
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');  
// Route::get('/cart', [CartController::class, 'index'])->name('cart');    
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');     
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']) ->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']) ->name('password.email');
// Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');    
Route::get('/brands', [BrandController::class, 'index'])->name('brands'); 
Route::get('/shops', [ShopController::class, 'index'])->name('shops'); 
Route::get('/shop/{shop_slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/offers', [OfferController::class, 'index'])->name('offers'); 
Route::post('/newsletter/subscribe',[NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Cart

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::middleware('auth:customer')->group(function () {
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/buy-now/{productId}', [CartController::class, 'buyNow'])->name('buy.now');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']) ->name('cart.remove');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place-order',[CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::post('/checkout/prepare', [CheckoutController::class, 'prepare'])->name('checkout.prepare');
    Route::get( '/my-account',[CustomerAccountController::class, 'index'])->name('customer.account');
    Route::get('/my-account/orders',[OrderController::class, 'index'])->name('orders');
    // Route::get('/', [CustomerAccountController::class, 'index'])->name('my-account');
    Route::get('/orders', [OrderController::class, 'index'])->name('my-account.orders');
});


Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin']) ->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']) ->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus']) ->name('categories.toggle-status');
        Route::resource('subcategories', AdminSubCategoryController::class)->except(['show']) ->parameters(['subcategories' => 'subCategory', ]);
        Route::patch('subcategories/{subCategory}/toggle-status', [AdminSubCategoryController::class,  'toggleStatus'])->name('subcategories.toggle-status');
        Route::resource('brands', AdminBrandController::class)->except(['show']);
        Route::patch( 'brands/{brand}/toggle-status',[AdminBrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        Route::resource('vendors', AdminVendorController::class)->except(['show'])->parameters(['vendors' => 'vendor',]);
        Route::patch('vendors/{vendor}/toggle-status',[AdminVendorController::class, 'toggleStatus'])->name('vendors.toggle-status');
        Route::resource('products', AdminProductController::class)->except(['show'])->parameters(['products' => 'product',]);
        Route::patch('products/{product}/toggle-status',[AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::patch('products/{product}/toggle-featured',[AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
        Route::patch('orders/{order}/status',[AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::resource('customers',AdminCustomerController::class)->except(['show']);
        Route::get('customers/{customer}',[AdminCustomerController::class, 'show'])->name('customers.show');
        Route::patch('customers/{customer}/toggle-status',[AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::resource('coupons', AdminCouponController::class)->except(['show']);
        Route::patch('coupons/{coupon}/toggle-status',[AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        Route::resource('banners', AdminBannerController::class)->except(['show']);
        Route::patch('banners/{banner}/toggle-status',[AdminBannerController::class, 'toggleStatus'])->name('banners.toggle-status');
        Route::resource('reviews', AdminReviewController::class) ->except(['show']);
        Route::patch('reviews/{review}/toggle-status',[AdminReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');
        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::patch('contacts/{contact}/toggle-status', [AdminContactController::class, 'toggleStatus'])->name('contacts.toggle-status');
        Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get( 'settings',[AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('settings/{setting}',[AdminSettingController::class, 'update'])->name('settings.update');
        
        Route::post('/logout', [AdminAuthController::class, 'logout']) ->name('logout');
    });
});