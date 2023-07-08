<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

Route::group(['middleware' => 'auth'], function () {
    
    //Admin route  
    Route::group(['middleware' => 'can:isAdmin'], function () {
        Route::get('/admin', [AdminController::class, 'adminHome']);
        Route::get('/bookingList', [AdminController::class, 'bookingList']);
        Route::get('/roomList', [AdminController::class, 'adminRoomList']);
        //admin action
        Route::get('/approveRoom/{id}', [RoomController::class, 'approveRoom'])->name('room.approve');
        Route::get('/deleteRoom/{id}', [RoomController::class, 'deleteRoom'])->name('room.delete');
        Route::get('/ModifyRoom/{id}', [RoomController::class, 'editRoom'])->name('room.edit');
        Route::post('/updateRoom', [RoomController::class, 'store']);
        Route::get('/ModifyBooking/{id}', [BookingController::class, 'editBooking'])->name('booking.edit');
        Route::post('/updateBooking', [RoomController::class, 'store']);
        Route::get('/addBooking', [AdminController::class, 'adminCreateBooking'])->name('admin.addBooking');
    });

//User route
    Route::get('/', function () {
        return redirect('/home');
    });
    Route::get('/apply', [RoomController::class, 'create']);
    Route::get('/viewOwnedRoom', [RoomController::class, 'show'])->name('rooms.show');
    Route::post('/addRoom', [RoomController::class, 'store']);
    Route::get('/mybooking', [BookingController::class, 'myBooking'])->name('User.mybooking');

    //User action
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('User.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/{booking}/delete', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/{booking}/view', [BookingController::class, 'viewDetails'])->name('bookings.view');
    Route::post('/bookings/{booking}/updateStatus', [BookingController::class, 'updateStatus']);


    Route::get('/search', [RoomController::class, 'search']);

    Route::get('/home', [RoomController::class, 'index']);
    Route::get('/room/{id}',  [RoomController::class, 'oneroom']);
    Route::get('/deleteRoom/{id}', [RoomController::class, 'deleteRoom'])->name('room.delete');
    Route::get('/editRoom/{id}', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/editRoom', [RoomController::class, 'update']); 
    Route::get('/mybooking', [function () {
        return view('User/mybooking');
    }]);
    Route::post('/bookingConfirmation',  [BookingController::class, 'bookingConfirmation']);

    
    Route::permanentRedirect('/login', '/home');
});

Route::group(['middleware' => ['prevent-history', 'guest']], function(){
    Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class,'userLogin']);
});

Route::get('/register', [RegisterController::class,'showRegisterForm']);
Route::post('/register', [RegisterController::class,'registerUser']);
Route::get('logout', [LoginController::class,'logout']);
Auth::routes();

