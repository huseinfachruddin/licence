<?php

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\Auth;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\XenditController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function(){
    $user = User::where('id','1')->first();
    $user = $user->syncRoles('admin');
    return $user;
});


// Imron
//Xendit
Route::get('/xendit/channel',[XenditController::class,'getChannel']);
Route::post('/xendit/payment',[XenditController::class,'payment']);
Route::post('/xendit/invoice',[XenditController::class,'invoice']);
Route::post('/xendit/callback',[XenditController::class,'paid']);





// CHECK LICENCE 
Route::match(['get','post'],'/checking', [LicenceController::class,'checkLicence']);
Route::match(['get','post'],'/setting', [LicenceController::class,'setLicence']);

//Domain
Route::get('/domain',[DomainController::class,'getDomain']);
Route::delete('/domain/{id}',[DomainController::class,'deleteDomain']);

Route::get('/product',[ProductController::class,'getProduct']);
Route::get('/product/{id}',[ProductController::class,'detailProduct']);
Route::post('/product',[ProductController::class,'createProduct']);
Route::put('/product/{id}',[ProductController::class,'editProduct']);
Route::delete('/product/{id}',[ProductController::class,'deleteProduct']);

// Profile
Route::get('/package',[PackageController::class,'getPackage']);
Route::get('/package/{id}',[PackageController::class,'detailPackage']);
Route::post('/package',[PackageController::class,'createPackage']);
Route::put('/package',[PackageController::class,'editPackage']);
Route::delete('/package/{id}',[PackageController::class,'deletePackage']);


Route::post('/register',[Auth::class,'register']);
Route::post('/login',[Auth::class,'login']);

Route::post('/xendit/paid',[XenditController::class,'paid']);

Route::group(['middleware'=>'auth:sanctum'],function(){ 
    Route::get('/logout',[Auth::class,'logout']);
    // Order
    Route::get('/order',[OrderController::class,'getOrder']);
    Route::get('/order/{id}',[OrderController::class,'detailOrder']);
    Route::post('/order',[OrderController::class,'createOrder']);
    Route::put('/order',[OrderController::class,'editOrder']);
    Route::delete('/order/{id}',[OrderController::class,'deleteOrder']);
    
    // Profile
    Route::get('/profile',[ProfileController::class,'getProfile']);
    Route::put('/profile',[ProfileController::class,'editProfile']);
    Route::put('/profile/password',[ProfileController::class,'passwordProfile']);
    // User
    Route::get('/user',[UserController::class,'getUser']);
    Route::get('/user/{id}',[UserController::class,'detailUser']);
    Route::put('/user/{id}',[UserController::class,'editUser']);
    Route::delete('/user/{id}',[UserController::class,'deleteUser']);
    // Role
    Route::get('/role',[RoleController::class,'getRole']);
    Route::get('/role/{id}',[RoleController::class,'detailRole']);
    Route::post('/role',[RoleController::class,'createRole']);
    Route::put('/role/{id}',[RoleController::class,'editRole']);
    Route::delete('/role/{id}',[RoleController::class,'deleteRole']);

    // Licence
    Route::get('/licence',[LicenceController::class,'getLicence']);
    Route::get('/licence/{id}',[LicenceController::class,'detailLicence']);
    Route::post('/licence',[LicenceController::class,'createLicence']);
    Route::put('/licence/{id}',[LicenceController::class,'editLicence']);
    Route::delete('/licence/{id}',[LicenceController::class,'deleteLicence']);

    // Cart
    Route::get('/cart',[CartController::class,'getCart']);
    Route::post('/cart',[CartController::class,'createCart']);
    Route::delete('/cart/subcart/{id}',[CartController::class,'deleteSubcart']);
    
    // //Xendit
    // Route::get('/xendit/channel',[XenditController::class,'getChannel']);
    // Route::post('/xendit/payment',[XenditController::class,'payment']);
    // Route::post('/xendit/invoice',[XenditController::class,'invoice']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin',function(Request $request){
            return 'Ok';
        });
    });
});



