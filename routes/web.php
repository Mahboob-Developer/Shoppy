<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\connection;
use App\Http\Controllers\Owner;
use App\Http\Controllers\UserController;

// for middleware authentication 
use App\Http\Middleware\userCheck;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\OwnerCheck;


// user and guest user  
// middleware for user 
Route::middleware(['userCheck'])->group(function(){
  Route::get('/UserProfile',[UserController::class,'UserProfile']);
  Route::get('/cart',[UserController::class,'cart']);
  Route::get('/Add Cart/{id}',[UserController::class,'AddCart']);
  Route::get('/Remove-cart/{type}/{id}', [UserController::class, 'RemoveCart'])->name('cart.remove');
  Route::get('/Add-Wishlist/{type}/{id}', [UserController::class, 'AddWishlist']);

  // website
  Route::get('/ProfileUpdate', [UserController::class, 'ProfileUpdate']);
  Route::post('/ProfileUpdate', [UserController::class, 'ProfileUpdateForm'])->name('ProfileUpdate');
  Route::post('/UserProfileForm',[UserController::class,'UserProfileForm']);
  Route::get('/UserSetting',[UserController::class,'Setting']);
  Route::post('/UserSetting', [UserController::class, 'SettingForm'])->name('UserSetting');
  Route::get('/conform_buy/{id}/{quantity}',[UserController::class,'conform_buy'])->name('conform_buy');
  Route::get('/conformBuy/{id}/{quantity}/{size}',[UserController::class,'conformBuy']);;
  Route::post('/UpdateAddress/{id}', [UserController::class, 'UpdateAddress'])->name('UpdateAddress');
  Route::get('/Buy',[UserController::class,'BuyPage']);
  Route::get('/Buy/{id}',[UserController::class,'BuyPageRating']);
  Route::post('/RatingForm/{id}', [UserController::class, 'RatingForm'])->name('RatingForm');
  Route::get('/Order/{type}/{id}',[userController::class,'OrderAction']);
  Route::get('/InvoiceUser/{type}/{id}',[userController::class,'InvoiceDownload']);
  Route::get('/AddBuy/{id}/{quantity}/{size}/{discount}',[UserController::class,'AddBuy'])->name('AddBuy');
  Route::get('/rating', [UserController::class, 'rating']);
  Route::get('/Wishlist',[UserController::class,'Wishlist']);
});

Route::get('/navbaar',[UserController::class,'navbaar']);
Route::get('/footer',[UserController::class,'footer']);
Route::get('/',[UserController::class,'home']);
Route::get('/Search/{item}',[UserController::class,'Search']);
Route::get('/Search',[UserController::class,'SearchForm']);
Route::get('/allproduct/{id}',[UserController::class,'allproduct']);
Route::post('/Contact',[UserController::class,'Contact'])->name('Contact');
// for user authentication 
Route::get('/sign_up',[UserController::class,'sign_up']);
Route::post('/register',[UserController::class,'register'])->name('register');
Route::get('/Active/{id}/{token}',[UserController::class,'Activation']);
Route::get('/login',[UserController::class,'login']);
Route::post('/login',[UserController::class,'loginsubmit']);
Route::get('/Logout',[UserController::class,'Logout']);
Route::get('/Forget/{status}',[UserController::class,'Forget']);
Route::post('/Forget/{status}',[UserController::class,'forgetsubmit']);

Route::get('/PasswordChange/{status}/{token}',[UserController::class,'ResetPassword']);
Route::post('/ResetPassword/{status}/{token}',[UserController::class,'ResetPasswordSubmit'])->name('ResetPassword');
// for admin authentication 
Route::get('/Adminlogin',[UserController::class,'Adminlogin']);
Route::post('/Adminlogin',[UserController::class,'adminloginsubmit']);
Route::get('/Adminsingup',[UserController::class,'Adminsingup']);
Route::post('/Adminsingup',[UserController::class,'Adminsingupform'])->name('Adminsingup');
Route::get('/AdminForget',[UserController::class,'AdminForget']);
Route::post('/AdminForget',[UserController::class,'Adminforgetsubmit']);
Route::get('/AdminForgetOtpPage',[UserController::class,'AdminForgetOtpPage']);
Route::post('/AdminForgetOtp',[UserController::class,'AdminForgetOtp']);
Route::get('/AdminResetPassword',[UserController::class,'AdminResetPassword']);
Route::post('/AdminResetPassword',[UserController::class,'AdminResetPasswordSubmit'])->name('AdminResetPassword');


Route::get('/masterview',[UserController::class,'masterview']);

// for admin  
Route::middleware(['AdminCheck'])->group(function(){
  Route::post('/LogoutAdmin',[connection::class,'LogoutAdmin']);
  Route::get('/AdminIndex',[connection::class,'AdminIndex']);

  Route::get('/Products',[connection::class,'Products']);
  Route::get('/ProductAdd',[connection::class,'ProductAdd']);
  Route::get('/Products/{id}', [connection::class, 'ProductDelete'])->name('product.delete');
  Route::post('/ProductAdd', [connection::class, 'ProductAddform']);
  Route::get('/ProductUpdate/{id}', [Connection::class, 'ProductUpdate'])->name('ProductUpdate');
  Route::post('/ProductUpdateForm/{id}', [Connection::class, 'ProductUpdateForm'])->name('ProductUpdateForm');
  Route::post('/productDelete/{id}', [Connection::class, 'ProductDeleteForm']);
  Route::get('/OrderProduct',[connection::class,'Order']);
  Route::get('/Order/{id}', [connection::class, 'OrderId']);
  Route::post('/OrderDeleted/{id}', [connection::class, 'OrderDeleted']);
  Route::get('/OrderUpdate/{type}/{id}',[connection::class,'OrderUpdate']);
  Route::get('/RefundRequest',[connection::class,'RefundRequest']);
  Route::get('/RefundRequest/{id}', [connection::class, 'RefundRequestId']);
  Route::post('/RefundCancel/{id}', [connection::class, 'RefundCancelForm']);
  Route::get('/ProfileAdmin',[connection::class,'ProfileAdmin']);
  Route::get('/ProfileAdminUpdate', [Connection::class, 'ProfileUpdate']);
  Route::post('/ProfileAdminUpdate', [Connection::class, 'ProfileAdminUpdate']);
  Route::get('/Account Setting',[connection::class,'AccountSetting']);
  Route::post('/AdminSetting', [connection::class, 'AdminSetting']);
  Route::post('adminProfile',[connection::class, 'adminProfile'])->name('adminProfile');

});

// for owner 
Route::middleware(['OwnerCheck'])->group(function(){
  //for owner of product
  Route::get('/Owner', [Owner::class, 'Dashboard']);
  Route::post('/ownerprofile',[Owner::class, 'adminProfile'])->name('adminProfile');
  Route::get('/ProductDetails',[Owner::class, 'ProductDetails']);
  // this is product block 
  Route::get('ProductDetails/{id}/{button}',[Owner::class, 'ProductDetailsAction'])->name('ProductDetails');
  Route::post('ProductDetailsAction/{id}/{button}', [Owner::class, 'ProductDetailsActionForm'])->name('ProductDetailsAction');

  Route::get('/OfferDetails',[Owner::class, 'OfferDetails']);
  Route::get('/OfferAdd',[Owner::class, 'OfferAdd']);
  Route::post('/OfferAdd', [Owner::class, 'OfferAddForm']);
  Route::get('/OfferDetails/{id}', [Owner::class, 'OfferDetailsAction'])->name('OfferDetails');
  Route::post('/OfferDelete/{id}', [Owner::class, 'OfferDeleteForm'])->name('OfferDeleteForm');
  Route::get('/OfferUpdate/{id}', [Owner::class, 'OfferUpdate']);
  Route::post('/OfferUpdate/{id}', [Owner::class, 'OfferUpdateForm']);
  Route::get('/User',[Owner::class,'UserDetails']);
  Route::get('/User/{id}',[Owner::class,'UserDetailsAction']);
  Route::get('/UserAction/{type}/{id}',[Owner::class,'UserAction']);
  // this is User block 
  Route::get('UserBlock/{id}/button={button}',[Owner::class, 'UserBlock'])->name('UserBlock');
  Route::post('UserBlock/{id}', [Owner::class, 'UserBlockSuccess'])->name('UserBlock');
  // this is User unblock 
  Route::get('UserUnBlock/{id}/button={button}',[Owner::class, 'UserUnBlock'])->name('UserUnBlock');
  Route::post('UserUnBlock/{id}', [Owner::class, 'UserUnBlockSuccess'])->name('UserUnBlock');
  Route::get('/Saller',[Owner::class,'Saller']);
    Route::get('/Saller/{type}/{id}',[Owner::class,'SallerAction']);
    Route::post('/SallerActionForm/{type}/{id}',[Owner::class,'SallerActionForm']);
  Route::get('/Catagorydetails',[Owner::class,'Catagorydetails']);
  Route::get('Catagorydetails/{id}',[Owner::class,'CatagoryAction'])->name('Catagorydetails');
  Route::post('/CatagoryAction/{id}',[Owner::class,'CatagoryActionForm'])->name('CatagoryAction');
  Route::get('CatagoryAdd',[Owner::class,'CatagoryAdd']);
  Route::post('CatagoryAdd', [Owner::class, 'CatagoryAddForm']);
  Route::get('/CatagoryUpdate/{id}', [Owner::class, 'CatagoryUpdate'])->name('CatagoryUpdate');
  Route::post('/CatagoryUpdate/{id}', [Owner::class, 'CatagoryUpdateForm'])->name('CatagoryUpdateForm');
  Route::get('/Account',[Owner::class,'Account']);
  Route::get('/AccountUpdate', [Owner::class, 'ProfileUpdate']);
  Route::post('/AccountUpdate', [Owner::class, 'ProfileAdminUpdate']);
  Route::get('/Setting',[Owner::class,'Setting']);
  Route::post('/Setting', [Owner::class, 'SettingForm']);
  Route::get('/ViewUser',[Owner::class, 'ViewUser']);

  Route::get('UserCart',[Owner::class, 'UserCart']);
  Route::get('OwnerAction/{type}/{id}', [Owner::class, 'OwnerAction']);

  Route::get('/ContactUs',[Owner::class,'ContactUs']);
  Route::get('ContactUs/{type}/{id}',[Owner::class, 'ContactUsAction'])->name('ContactUs');
  Route::post('/ContactReply/{id}', [Owner::class, 'ContactReplyForm']);
  Route::post('/ContactDelete/{id}',[Owner::class,'ContactDeleteFrom']);
  Route::get('/InvoiceOwner/{type}/{userid}/{id}',[Owner::class,'InvoiceDownload']);

});

