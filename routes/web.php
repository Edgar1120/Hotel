<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPhotoController;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomPhotoController;
use App\Http\Controllers\UserController;
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

Route::prefix('api')->group(
    function(){
        //User routes
        Route::get('/userId/{id}',[UserController::class,'getId']);
        Route::get('/user/getidentity',[UserController::class,'getIdentity']);
        Route::get('/user',[UserController::class,'index']);
        Route::post('/user/store',[UserController::class,'store']);
        Route::put('/user/update/{id}',[UserController::class,'update']);
        Route::delete('/user/delete/{id}',[UserController::class,'delete']);
        Route::post('/user/login',[UserController::class,'login']);
        


        //Reservation routes
        Route::get('/reservationId/{id}',[ReservationController::class,'getId']);
        Route::get('/reservation',[ReservationController::class,'index']);
        Route::post('/reservation/store',[ReservationController::class,'store']);
        Route::put('/reservation/update/{id}',[ReservationController::class,'update']);
        Route::delete('/reservation/delete/{id}',[ReservationController::class,'delete']);


        //Rooms routes 
        Route::get('/roomId/{id}',[RoomController::class,'getId']);
        Route::get('/room',[RoomController::class,'index']);
        Route::post('/room/store',[RoomController::class,'store']);
        Route::put('/room/update/{id}',[RoomController::class,'update']);
        Route::delete('/room/delete/{id}',[RoomController::class,'delete']);
        Route::get('/room/getImage/{filename}',[RoomController::class,'getImage']);
        Route::post('/room/upload',[RoomController::class,'uploadImage']);

       
        //Hotels routes
        Route::get('/hotelId/{id}',[HotelController::class,'getId']);
        Route::get('/hotel',[HotelController::class,'index']);
        Route::post('/hotel/store',[HotelController::class,'store']);
        Route::put('hotel/update/{id}',[HotelController::class,'update']);
        Route::delete('hotel/delete/{id}',[HotelController::class,'delete']);
        Route::get('/hotel/getImage/{filename}',[HotelController::class,'getImage']);
        Route::post('/hotel/upload',[HotelController::class,'uploadImage']);

        
    

        //Bills routes
        Route::get('/billId/{id}',[BillController::class,'getId']);
        Route::get('/bill',[BillController::class,'index']);
        Route::post('/bill/store',[BillController::class,'store']);
        Route::put('/bill/update/{id}',[BillController::class,'update']);
        Route::delete('/bill/delete/{id}',[BillController::class,'delete']);
    
    }
);

