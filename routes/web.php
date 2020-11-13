<?php

use App\Http\Controllers\JoinController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Account;
use App\Models\Firm;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/join', [JoinController::class, 'show']);

Route::get('/model', [JoinController::class, 'model']);

Route::get('/relation', [JoinController::class,'relation']);

Route::get('/query', function() {

// $firm = Firm::find(1);
// $user = User::find(7);
// dd($user);
// return $user->firm;

// return $user->phone;


$firm = Firm::find(1);

return $firm->users;





});