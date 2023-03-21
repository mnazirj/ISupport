<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageViewController;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(DashboardController::class)->prefix('dashboard')->group(function(){
    Route::get('home','Index')->name('dash.home');
    Route::get('users','UsersIndex')->name('dash.users');
    Route::get('logs','LogsIndex')->name('dash.logs');
   
    Route::group(['prefix'=>'tickets'],function(){
        Route::get('list','TicketIndex')->name('dash.tickets');
        Route::post('list','CreateTicket')->name('dash.post.tickets');
        Route::get('{id}/view','ViewTicket')->name('dash.view_ticket');
        Route::post('{id}/view','AddComment')->name('dash.replay');
        Route::get('{id}/close','CloseTicket')->name('dash.ticket.close');
        Route::post('{id}/edit','EditTicket')->name('dash.ticket.edit');
        Route::get('{id}/delete','DeleteTicket')->name('dash.ticket.delete');
    });

    Route::group(['prefix'=>'categoryies'],function(){
        Route::get('list','CateIndex')->name('dash.categories');
        Route::post('create','CreateCategory')->name('cate.new');
        Route::post('{id}/edit','EditCategory')->name('cate.edit');
        Route::get('{id}/delete','DeleteCategory')->name('cate.delete');
    });
    Route::group(['prefix'=>'labels'],function(){
        Route::get('list','LabelIndex')->name('dash.labels');
        Route::post('create','CreateLabel')->name('label.new');
        Route::post('{id}/edit','EditLabel')->name('label.edit');
        Route::get('{id}/delete','DeleteLabel')->name('label.delete');
    });
    
});


Route::group(['prefix'=>'auth'],function(){
    Route::get('login',[PageViewController::class,'LoginIndex'])->name('login');
    Route::post('login',[AuthController::class,'Login']);
});

Route::get('ts', function () {
//    session()->remove('UserId');
//    return redirect(route('login'));
return view('test')->with([
    'PageTitle'=>'sho ma kan',
    'User'=>User::find(1),
]);
});
