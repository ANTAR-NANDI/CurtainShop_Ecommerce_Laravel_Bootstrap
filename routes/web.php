<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\LookupBannerController;
use App\Http\Controllers\Backend\AdvertisementBannerController;
use App\Http\Controllers\Backend\MessageController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PostCategoryController;
use App\Http\Controllers\Backend\PostCommentController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\PostTagController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\RegistrationController;
use App\Http\Controllers\User\HomeController;
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

// -------------------------------------------------------------------------------
// Global Section for All Kind of Users
//Home Section
Route::get('/', [FrontendController::class, 'index'])->name('/');
//Shop Section
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-sub-cat');
Route::get('/product-brand/{slug}', [FrontendController::class, 'productBrand'])->name('product-brand');
Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');
Route::get('/add-to-cart/{slug}', [FrontendController::class, 'addToCart'])->name('add-to-cart')->middleware('user');
Route::get('/wishlist/{slug}', [FrontendController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
//Blog Section
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');
Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
//Contact Section
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
//About Us Section
Route::get('/about', [FrontendController::class, 'about'])->name('about');
//Registration Section
Route::get('/signup', [RegistrationController::class, 'index'])->name('signup');
Route::post('signup', [RegistrationController::class, 'signupSubmit'])->name('signup.submit');
//Login Section
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// ---------------------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------------------
// User section start
Route::group(
    ['prefix' => '/user'],
    function () {
        //User Dashboard 
        Route::get('/', [HomeController::class, 'index'])->name('user');
        // Profile
        Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
        //  Order
        Route::get('/order', [HomeController::class, 'orderIndex'])->name('user.order.index');
        Route::get('/order/show/{id}', [HomeController::class, 'orderShow'])->name('user.order.show');
        Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('user.order.delete');
        // Product Review
        Route::get('/user-review', [HomeController::class, 'productReviewIndex'])->name('user.productreview.index');
        Route::delete('/user-review/delete/{id}', [HomeController::class, 'productReviewDelete'])->name('user.productreview.delete');
        Route::get('/user-review/edit/{id}', [HomeController::class, 'productReviewEdit'])->name('user.productreview.edit');
        Route::patch('/user-review/update/{id}', [HomeController::class, 'productReviewUpdate'])->name('user.productreview.update');
        // Post comment
        Route::get('user-post/comment', [HomeController::class, 'userComment'])->name('user.post-comment.index');
        Route::delete('user-post/comment/delete/{id}', [HomeController::class, 'userCommentDelete'])->name('user.post-comment.delete');
        Route::get('user-post/comment/edit/{id}', [HomeController::class, 'userCommentEdit'])->name('user.post-comment.edit');
        Route::patch('user-post/comment/udpate/{id}', [HomeController::class, 'userCommentUpdate'])->name('user.post-comment.update');
        // Password Change
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
    }
);
// --------------------------------------------------------------------------------------------
Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');

///////////////////////////////////////////////////////////////////////////
////////////////////////////////////////




























































//Admin Section Routes Finalized
Route::group(['middleware' => 'admin'], function () {
    Route::group(
        ['prefix' => '/admin'],
        function () {
            Route::get('settings', [AdminController::class, 'settings'])->name('settings');
            Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');



























            Route::get('/', [AdminController::class, 'index'])->name('admin');
            // Settings
            
            // user route
            Route::resource('users', UsersController::class);
            // Coupon
            Route::resource('/coupon', CouponController::class);
            // Profile
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
            Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
            // Banner
            Route::resource('banner', BannerController::class);
            // Banner
            Route::resource('lookup-banner', LookupBannerController::class);
            // Banner
            Route::resource('advertisement-banner', AdvertisementBannerController::class);
            // Category
            Route::resource('/category', CategoryController::class);
            // Product
            Route::resource('/product', ProductController::class);
            // Brand
            Route::resource('brand', BrandController::class);
            // Shipping
            Route::resource('/shipping', ShippingController::class);
            // Order in Admin Panel
            Route::resource('/order', OrderController::class);
            Route::get('order/pdf/{id}', [OrderController::class, 'pdf'])->name('order.pdf');
            // Post
            Route::resource('/post', PostController::class);
            // POST category
            Route::resource('/post-category', PostCategoryController::class);
            // Post tag

            Route::resource('/post-tag', PostTagController::class);
            // ProductReview
            Route::resource('/review', ProductReviewController::class);
            Route::resource('/comment', PostCommentController::class);
            // Password Change
            Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
            Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('achange.password');
            // Message
            Route::resource('/message',  MessageController::class);
            Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');
            // Notification
            Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
            Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
            Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
        }
    );
});