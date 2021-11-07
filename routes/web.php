<?php

use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\User\UserDashboardComponent;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', HomeComponent::class)->name('index');

Route::get('/shop', ShopComponent::class)->name('shop');

Route::get('/cart', CartComponent::class)->name('cart');

Route::get('/checkout', CheckoutComponent::class)->name('checkout');

Route::get('/contact', ContactComponent::class)->name('contact');

Route::get('/product/{slug}', DetailsComponent::class)->name('product.details');

//Route::get('/category/{slug}', ShopComponent::class)->name('category.products');

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//	return view('dashboard');
//})->name('dashboard');

//for normal user

Route::prefix('user')->middleware(['auth:sanctum', 'verified'])->group(function () {
	Route::get('/dashboard', UserDashboardComponent::class)->name('user.dashboard');
});

//for admin
Route::prefix('admin')->middleware(['auth:sanctum', 'verified', 'auth_admin'])->group(function () {

	Route::get('/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
});
