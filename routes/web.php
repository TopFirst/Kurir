<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Seller;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WebController;
use App\Models\web_about;
use App\Models\web_general_info;
use App\Models\web_layanan;

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

// Route::get('/', function () {
//     $web_data=web_general_info::first();
//     $web_layanans=web_layanan::all();
//     $web_about=web_about::first();
//     return view('index',compact('web_data','web_layanans','web_about'));
// });
Route::get('/', [WebController::class,'index'])->name('web.index');
Route::post('/update_gen_info_pic/{web_general_info:id}', [WebController::class,'update_gen_info_pic'])->middleware('auth')->name('web.update_gen_info_pic');

Route::get('changepassword', [UserController::class,'viewchangepassword'])->name('users.viewchangepassword');
Route::post('changepassword', [UserController::class,'changepassword'])->name('users.changepassword');

Route::get('exportseller', [SellerController::class,'exportseller'])->name('seller.exportseller');

Route::post('/konfirmasi_antar',[TransaksiController::class,'konfirmasi_antar'])->middleware('auth')->name('transaksi.konfirmasi_antar');
Route::post('/gantistatus',[TransaksiController::class,'gantistatus'])->middleware('auth')->name('transaksi.gantistatus');
Route::get('/adminpage',[TransaksiController::class,'admin'])->middleware('auth')->name('transaksi.admin');
Route::get('/transaksi/json',[TransaksiController::class,'json'])->middleware('auth')->name('transaksi.json');
Route::get('/transaksi/json_br',[TransaksiController::class,'json_br'])->middleware('auth')->name('transaksi.json_br');
Route::get('/transaksi/cekseller',[TransaksiController::class,'cekseller'])->middleware('auth')->name('transaksi.cekseller');
Route::post('/transaksi/cetakpdf',[TransaksiController::class,'cetakpdf'])->middleware('auth')->name('transaksi.cetakpdf');
Route::get('/transaksi/br',[TransaksiController::class,'br'])->middleware('auth')->name('transaksi.br');
Route::get('/transaksi/appconfig',[TransaksiController::class,'appconfig'])->middleware('auth')->name('transaksi.appconfig');
Route::post('/transaksi/lunaskan',[TransaksiController::class,'lunaskan'])->middleware('auth')->name('transaksi.lunaskan');
Route::post('/transaksi/backup',[TransaksiController::class,'backup'])->middleware('auth')->name('transaksi.backup');
Route::post('/transaksi/restore',[TransaksiController::class,'restore'])->middleware('auth')->name('transaksi.restore');
Route::post('/transaksi/ubahconfig/{AppConfig}',[TransaksiController::class,'ubahconfig'])->middleware('auth')->name('transaksi.ubahconfig');

Route::get('/home/json',[HomeController::class,'json'])->middleware('auth')->name('home.json');
Route::get('/home/json_cancel',[HomeController::class,'json_cancel'])->middleware('auth')->name('home.json_cancel');
Route::get('/home/dokumentasi',[HomeController::class,'dokumentasi'])->middleware('auth')->name('home.dokumentasi');

Route::post('/update_layanan',[WebController::class,'update_layanan'])->middleware('auth')->name('web.update_layanan');
Route::post('/hapus',[WebController::class,'hapus'])->middleware('auth')->name('web.hapus');
Route::post('/isi_layanan',[WebController::class,'isi_layanan'])->middleware('auth')->name('web.isi_layanan');
Route::post('/update_web_info/{web_general_info}',[WebController::class,'update_web_info'])->middleware('auth')->name('web.update_web_info');


Route::get('/ex', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::post('/transaksi/hapus', [TransaksiController::class, 'hapus'])->middleware('auth')->name('transaksi.hapus');
Route::get('/transaksi/GetJemput',[TransaksiController::class,'GetJemput'])->name('transaksi.GetJemput');

Route::get('/admin', [HomeController::class, 'index'])->middleware('auth')->name('admin');
Route::get('/cekresi',[HomeController::class,'cekresi'])->name('home.cekresi');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('web', WebController::class);
    Route::resource('seller', SellerController::class);
});