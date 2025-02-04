<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Partner\MenuController;
use App\Http\Controllers\Partner\MenuDetailsController;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//Frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('user/profile/edit', [UserController::class, 'userProfileEdit'])->name('user.profile.edit');
    Route::get('/user/profile/change/password', [UserController::class, 'userProfileChangePassword'])->name('user.profile.change.password');
    Route::post('/user/password/change', [UserController::class, 'userPasswordChange'])->name('user.password.change');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/user/logout', [UserController::class, 'userLogout'])->name('user.logout');

//Admin
Route::middleware('admin')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile_edit', [AdminController::class, 'adminProfileEdit'])->name('admin.profile.edit');
    Route::get('/admin/profile/change/password', [AdminController::class, 'adminProfileChangePassword'])->name('admin.profile.change.password');
    Route::post('/admin/password/change', [AdminController::class, 'adminPasswordChange'])->name('admin.password.change');
// Admin Category
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/admin/all_category','adminAllCategory')->name('admin.all_category');
        Route::get('/admin/add_category','adminAddCategory')->name('admin.add_category');
        Route::post('/admin/category/add_submit','adminAddCategorySubmit')->name('admin.category.add.submit');
        Route::get('/admin/edit_category/{id}','adminEditCategory')->name('admin.edit.category');
        Route::post('/admin/category/edit_submit','adminEditCategorySubmit')->name('admin.category.edit.submit');
        Route::get('/admin/delete_category/{id}','adminDeleteCategory')->name('admin.delete.category');
    });
// Admin City
Route::controller(CityController::class)->group(function(){
    Route::get('/admin/all_city','adminAllCity')->name('admin.all_city');
    Route::post('/admin/city/add_submit','adminAddCitySubmit')->name('admin.city.add.submit');
    Route::get('/admin/edit/city/{id}','adminEditCity');
    Route::post('/admin/city/edit_submit','adminEditCitySubmit')->name('admin.city.edit.submit');
    Route::get('/admin/delete_city/{id}','adminDeleteCity')->name('admin.delete.city');
});
});

Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/loginsubmit', [AdminController::class, 'adminLoginSubmit'])->name('admin.loginsubmit');
Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
Route::get('/admin/forget_password', [AdminController::class, 'adminForgetPassword'])->name('admin.forget_password');
Route::post('/admin/forget_submit', [AdminController::class, 'adminForgetSubmit'])->name('admin.forget_submit');
Route::get('admin/reset_link/{token}/{email}', [AdminController::class, 'adminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminController::class, 'adminResetPasswordSubmit'])->name('admin.reset_password_submit');


// Partner
Route::get('/partner/login', [PartnerController::class, 'partnerLogin'])->name('partner.login');
Route::get('/partner/register', [PartnerController::class, 'partnerRegister'])->name('partner.register');
Route::post('/partner/register/submit', [PartnerController::class, 'partnerRegisterSubmit'])->name('partner.register.submit');
Route::get('/partner/forget_password', [PartnerController::class, 'partnerForgetPassword'])->name('partner.forget_password');
Route::post('/partner/forget_submit', [PartnerController::class, 'partnerForgetSubmit'])->name('partner.forget_submit');
Route::get('partner/reset_link/{token}/{email}', [PartnerController::class, 'partnerResetPassword']);
Route::post('/partner/reset_password_submit', [PartnerController::class, 'partnerResetPasswordSubmit'])->name('partner.reset_password_submit');
Route::post('/partner/loginsubmit', [PartnerController::class, 'partnerLoginSubmit'])->name('partner.loginsubmit');
Route::get('/partner/logout', [PartnerController::class, 'partnerLogout'])->name('partner.logout');

Route::middleware('partner')->group(function(){
    Route::get('/partner/dashboard', [PartnerController::class, 'partnerDashboard'])->name('partner.dashboard');
    Route::get('/partner/profile', [PartnerController::class, 'partnerProfile'])->name('partner.profile');
    Route::post('/partner/profile_edit', [PartnerController::class, 'partnerProfileEdit'])->name('partner.profile.edit');
    Route::get('/partner/profile/change/password', [PartnerController::class, 'partnerProfileChangePassword'])->name('partner.profile.change.password');
    Route::post('/partner/password/change', [PartnerController::class, 'partnerPasswordChange'])->name('partner.password.change');
// Menu ////////
    Route::controller(MenuController::class)->group(function(){
        Route::get('/partner/all_menu','partnerAllMenu')->name('partner.all_menu');
        Route::get('/partner/add_menu','partnerAddMenu')->name('partner.add_menu');
        Route::post('/partner/menu/add_submit','partnerAddMenuSubmit')->name('partner.menu.add.submit');
        Route::get('/partner/edit_menu/{id}','partnerEditMenu')->name('partner.edit.menu');
        Route::post('/partner/menu/edit_submit','partnerEditMenuSubmit')->name('partner.menu.edit.submit');
        Route::get('/partner/delete_menu/{id}','partnerDeleteMenu')->name('partner.delete.menu');
    });
// Menu Details ////////
Route::controller(MenuDetailsController::class)->group(function(){
    Route::get('/partner/all_menu_details','partnerAllMenuDetails')->name('partner.all_menu_details');
    Route::get('/partner/add_menu_details','partnerAddMenuDetials')->name('partner.add_menu_details');
    Route::post('/partner/menu_details/add_submit','partnerAddMenuDetialsSubmit')->name('partner.menu.detials.add.submit');
    Route::get('/partner/edit_menu_detials/{id}','partnerEditMenuDetials')->name('partner.edit.menu_detials');
    Route::post('/partner/menu_detials/edit_submit','partnerEditMenuDetialsSubmit')->name('partner.menu.detials.edit.submit');
    Route::get('/partner/delete/menu_detials/{id}','partnerDeleteMenuDetials')->name('partner.delete.menu_detials');
    Route::get('/changeStatus','changeStatus');
});
});
require __DIR__.'/auth.php';
