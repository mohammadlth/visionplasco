<?php

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

// invoice factor
Route::any('invoice-factor', [App\Http\Controllers\PaymentController::class, 'verify'])->name('mellat.verification');

Route::get('/tt', [App\Http\Controllers\HomeController::class, 'tt'])->name('tt');
Route::get('/transfer/{RefId}', [App\Http\Controllers\HomeController::class, 'transfer'])->name('transfer');

// auth
Route::get('/auth', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('exist/check', [App\Http\Controllers\Auth\LoginController::class, 'exist'])->name('auth.exist');
Route::post('auth/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('auth.register');
Route::post('auth/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('auth.login');
Route::post('auth/forget/password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'forget_password'])->name('auth.forget.password');
Route::post('auth/forget/password/confirm', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'confirm'])->name('auth.forget.password.confirm');

// logout
Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

// home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// app
Route::get('/application', [App\Http\Controllers\HomeController::class, 'app'])->name('app');

// page
Route::get('/page/d-{id}', [App\Http\Controllers\HomeController::class, 'page'])->name('page');


// search
Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

// products
Route::any('products/zgp-{id}/{slug}', [App\Http\Controllers\CategoryController::class, 'index'])->name('product.category');
Route::get('product/zgp-{id}/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('product.show');
Route::any('products/all', [App\Http\Controllers\CategoryController::class, 'all_product'])->name('product.all');

// profile view
Route::get('p/user-{id}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

// comments
Route::post('comment/store', [App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');

// about
Route::get('about-us', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

// contact us
Route::get('contact-us', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('contact/store', [App\Http\Controllers\HomeController::class, 'contact_store'])->name('contact-store');

// privacy-and-policy
Route::get('privacy-policy', [App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy');

// city ajax
Route::post('city/list', [App\Http\Controllers\HomeController::class, 'city_list'])->name('city.list');

// articles
Route::get('articles', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

// buyer
Route::any('buy-req/zgr/{id?}', [App\Http\Controllers\BuyController::class, 'index'])->name('buy-req');

// sitemap
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');


// portal
Route::group(['prefix' => 'portal', 'middleware' => ['auth', 'activity', 'expire']], function () {

    // home
    Route::get('/', [App\Http\Controllers\Portal\PortalController::class, 'index'])->name('panel');

    // products
    Route::get('products', [App\Http\Controllers\Portal\ProductController::class, 'index'])->name('portal.products');
    Route::get('product/store', [App\Http\Controllers\Portal\ProductController::class, 'store'])->name('portal.product.store');
    Route::get('product/info/{id}', [App\Http\Controllers\Portal\ProductController::class, 'info'])->name('portal.product.info');
    Route::post('product/insert', [App\Http\Controllers\Portal\ProductController::class, 'insert'])->name('portal.product.insert');
    Route::post('product/update/{id}', [App\Http\Controllers\Portal\ProductController::class, 'update'])->name('portal.product.update');
    Route::get('product/show/{id}/{status}', [App\Http\Controllers\Portal\ProductController::class, 'change_show'])->name('portal.product.show');
    Route::get('product/delete/photo/{id}/{product_is}', [App\Http\Controllers\Portal\ProductController::class, 'delete_photo'])->name('portal.product.photo.delete');

    // search
    Route::post('search/category', [App\Http\Controllers\Portal\ProductController::class, 'category'])->name('portal.products.category');


    // profile
    Route::get('profile', [App\Http\Controllers\Portal\ProfileController::class, 'index'])->name('portal.profile');
    Route::post('profile/update/pic', [App\Http\Controllers\Portal\ProfileController::class, 'update_pic'])->name('portal.profile.update.pic');
    Route::post('profile/update/mobile', [App\Http\Controllers\Portal\ProfileController::class, 'update_mobile'])->name('portal.profile.update.mobile');
    Route::post('profile/update/mobile/check', [App\Http\Controllers\Portal\ProfileController::class, 'update_mobile_check'])->name('portal.profile.update.mobile.check');
    Route::get('profile/update/mobile/visibility/{show}', [App\Http\Controllers\Portal\ProfileController::class, 'mobile_visibility'])->name('portal.profile.update.mobile.visibility');
    Route::post('profile/update', [App\Http\Controllers\Portal\ProfileController::class, 'profile_update'])->name('portal.profile.update');
    Route::post('profile/update/info', [App\Http\Controllers\Portal\ProfileController::class, 'profile_info'])->name('portal.profile.update.info');

    Route::post('profile/insert/photo', [App\Http\Controllers\Portal\ProfileController::class, 'profile_photo'])->name('portal.profile.insert.photo');
    Route::get('profile/insert/photo/delete/{id}', [App\Http\Controllers\Portal\ProfileController::class, 'profile_photo_delete'])->name('portal.profile.photo.delete');

    Route::post('profile/insert/certificate', [App\Http\Controllers\Portal\ProfileController::class, 'profile_certificate'])->name('portal.profile.insert.certificate');
    Route::get('profile/insert/certificate/delete/{id}', [App\Http\Controllers\Portal\ProfileController::class, 'profile_certificate_delete'])->name('portal.profile.certificate.delete');


    // verification
    Route::get('verification', [App\Http\Controllers\Portal\ProfileController::class, 'verification'])->name('verification.index');
    Route::post('verification/upload', [App\Http\Controllers\Portal\ProfileController::class, 'verification_upload'])->name('verification.upload');

    //chats
    Route::get('chats', [App\Http\Controllers\Portal\ChatController::class, 'index'])->name('portal.chat');
    Route::post('chat/select/user', [App\Http\Controllers\Portal\ChatController::class, 'select'])->name('portal.chat.user');
    Route::post('chat/store', [App\Http\Controllers\Portal\ChatController::class, 'store'])->name('portal.chat.store');
    Route::post('chat/select/user/box', [App\Http\Controllers\Portal\ChatController::class, 'select_box'])->name('portal.chat.user.box');
    Route::post('chat/store/box', [App\Http\Controllers\Portal\ChatController::class, 'store_box'])->name('portal.chat.store.box');

    //phone view
    Route::post('phone/view', [App\Http\Controllers\Portal\PortalController::class, 'phone_view'])->name('phone.view');


    //plans
    Route::get('plans', [App\Http\Controllers\Portal\PlanController::class, 'index'])->name('portal.plan');

    // payment
    Route::get('plans/payment/{id}', [App\Http\Controllers\Portal\PlanController::class, 'payment'])->name('portal.payment');


    // request
    Route::get('request/store', [App\Http\Controllers\Portal\RequestController::class, 'store'])->name('portal.request.store');
    Route::post('request/insert', [App\Http\Controllers\Portal\RequestController::class, 'insert'])->name('portal.request.insert');
    Route::post('request/update/{id}', [App\Http\Controllers\Portal\RequestController::class, 'update'])->name('portal.request.update');
    Route::get('request/delete/{id}', [App\Http\Controllers\Portal\RequestController::class, 'delete'])->name('portal.request.delete');

    // buyer request
    Route::any('buyer/request', [App\Http\Controllers\Portal\RequestController::class, 'list'])->name('portal.request.list');

    // wallets
    Route::get('wallet', [App\Http\Controllers\Portal\WalletController::class, 'index'])->name('wallet');

    // change level
    Route::get('change/level/{type}', [\App\Http\Controllers\Portal\PortalController::class, 'change_level'])->name('change.level');

    // payment
    Route::get('pay/{invoice}', [App\Http\Controllers\Portal\PortalController::class, 'pay'])->name('pay');


    // invoice
//    Route::get('invoices', [App\Http\Controllers\Portal\InvoiceController::class, 'index'])->name('invoices');
//    Route::get('payment/invoice/{id}', [App\Http\Controllers\Portal\InvoiceController::class, 'payment_invoice'])->name('payment.invoice');

    // tickets
//    Route::get('tickets', [App\Http\Controllers\Portal\TicketController::class, 'index'])->name('tickets');
//    Route::get('ticket/info/{id}', [App\Http\Controllers\Portal\TicketController::class, 'info'])->name('ticket.show');
//    Route::get('ticket/create', [App\Http\Controllers\Portal\TicketController::class, 'create'])->name('ticket.create');
//    Route::post('ticket/store', [App\Http\Controllers\Portal\TicketController::class, 'store'])->name('ticket.store');
//    Route::post('ticket/comment/store/{id}', [App\Http\Controllers\Portal\TicketController::class, 'comment_store'])->name('ticket.comment.store');

    // ajax
    Route::post('category/detail', [App\Http\Controllers\Portal\PortalController::class, 'category_detail'])->name('category.detail');
    Route::any('upload/file', [App\Http\Controllers\Portal\PortalController::class, 'upload'])->name('upload.file');


});

// dashboard
Route::group(['prefix' => 'dashboard', 'middleware' => ['admin']], function () {

    // dashboard
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //users
    Route::resource('users', \App\Http\Controllers\Dashboard\UserController::class);
    Route::get('users/{id}/info', [\App\Http\Controllers\Dashboard\UserController::class, 'user_info'])->name('users.info');
    Route::post('users/{id}/info/update', [\App\Http\Controllers\Dashboard\UserController::class, 'user_info_update'])->name('users.info.update');
    Route::get('users/info/{id}/pic/remove', [\App\Http\Controllers\Dashboard\UserController::class, 'user_info_remove_pic'])->name('user.info.pic.remove');
    Route::get('vip/users', [\App\Http\Controllers\Dashboard\UserController::class, 'user_vip'])->name('users.vip');
    Route::get('users/login/{id}', [\App\Http\Controllers\Dashboard\UserController::class, 'user_login'])->name('users.login');


    // categories
    Route::resource('categories', \App\Http\Controllers\Dashboard\CategoryController::class);
    Route::get('category/{id}/pic/remove', [\App\Http\Controllers\Dashboard\CategoryController::class, 'pic_remove'])->name('category.pic.remove');

    // products
    Route::resource('products', \App\Http\Controllers\Dashboard\ProductController::class);
    Route::get('product/{status}/{id}/status', [\App\Http\Controllers\Dashboard\ProductController::class, 'change_status'])->name('products.status');

    // requests
    Route::resource('requests', \App\Http\Controllers\Dashboard\RequestController::class);

    // comments
    Route::resource('comments', \App\Http\Controllers\Dashboard\CommentController::class);

    // contacts
    Route::get('contacts', [\App\Http\Controllers\Dashboard\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{id}/chat', [\App\Http\Controllers\Dashboard\ContactController::class, 'chats'])->name('contacts.chats');
    Route::delete('contacts/{id}/delete', [\App\Http\Controllers\Dashboard\ContactController::class, 'delete'])->name('contacts.delete');
    Route::get('contacts/warning/{user_id}/{type}', [\App\Http\Controllers\Dashboard\ContactController::class, 'warning_type'])->name('contacts.warning');

    // chats
    Route::get('chats', [\App\Http\Controllers\Dashboard\ChatController::class, 'index'])->name('chats.index');
    Route::delete('chats/{id}/delete', [\App\Http\Controllers\Dashboard\ChatController::class, 'delete'])->name('chats.delete');

    // identities
    Route::resource('identities', \App\Http\Controllers\Dashboard\IdentityController::class);

    // view mobile
    Route::get('mobiles', [\App\Http\Controllers\Dashboard\DashboardController::class, 'mobiles'])->name('mobiles.index');

    // remove pic
    Route::get('delete/file/{id}', [App\Http\Controllers\Dashboard\DashboardController::class, 'remove_file'])->name('remove.file');

    // plans
    Route::resource('plans', \App\Http\Controllers\Dashboard\PlanController::class);
    Route::post('plans/offer/store', [\App\Http\Controllers\Dashboard\PlanController::class, 'offer_store'])->name('plans.offer.store');
    Route::get('plans/offer/delete', [\App\Http\Controllers\Dashboard\PlanController::class, 'offer_delete'])->name('plans.offer.delete');


    // banners
    Route::resource('banners', \App\Http\Controllers\Dashboard\BannerController::class);

    // setting
    Route::resource('settings', \App\Http\Controllers\Dashboard\SettingController::class);

    // events
    Route::resource('events', \App\Http\Controllers\Dashboard\EventController::class);

    // feature
    Route::resource('features', \App\Http\Controllers\Dashboard\FeatureController::class);

    // excel
    Route::get('excel/user', [\App\Http\Controllers\Dashboard\ExcelController::class, 'users'])->name('excel.user');

    //pages
    Route::resource('pages', \App\Http\Controllers\Dashboard\PageController::class);

    // meta
    Route::resource('meta', \App\Http\Controllers\Dashboard\MetaController::class);

    // article
    Route::resource('article', \App\Http\Controllers\Dashboard\ArticleController::class);

    // invoice
    Route::resource('invoice', \App\Http\Controllers\Dashboard\InvoiceController::class);

    // upload
    Route::resource('upload', \App\Http\Controllers\Dashboard\UploadController::class);

});
