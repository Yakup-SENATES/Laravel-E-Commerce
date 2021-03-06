<?php

use App\Http\Livewire\Admin\AdminAddAttributeComponent;
use App\Http\Livewire\Admin\AdminAddCategoryComponent;
use App\Http\Livewire\Admin\AdminAddCouponComponent;
use App\Http\Livewire\Admin\AdminAddHomeSliderComponent;
use App\Http\Livewire\Admin\AdminAddProductComponent;
use App\Http\Livewire\Admin\AdminAttributesComponent;
use App\Http\Livewire\Admin\AdminCategoryComponent;
use App\Http\Livewire\Admin\AdminContactComponent;
use App\Http\Livewire\Admin\AdminCouponsComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\AdminEditAttributeComponent;
use App\Http\Livewire\Admin\AdminEditCategoryComponent;
use App\Http\Livewire\Admin\AdminEditCouponComponent;
use App\Http\Livewire\Admin\AdminEditHomeSlider;
use App\Http\Livewire\Admin\AdminEditProductComponent;
use App\Http\Livewire\Admin\AdminHomeCategoryComponent;
use App\Http\Livewire\Admin\AdminHomeSliderComponent;
use App\Http\Livewire\Admin\AdminOrderComponent;
use App\Http\Livewire\Admin\AdminOrderDetailsComponent;
use App\Http\Livewire\Admin\AdminProductComponent;
use App\Http\Livewire\Admin\AdminSaleComponent;
use App\Http\Livewire\Admin\AdminSettingComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ThankyouComponent;
use App\Http\Livewire\User\UserChangePasswordComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\User\UserEditProfileComponent;
use App\Http\Livewire\User\UserOrderDetailsComponent;
use App\Http\Livewire\User\UserOrdersComponent;
use App\Http\Livewire\User\UserProfileComponent;
use App\Http\Livewire\User\UserReviewComponent;
use App\Http\Livewire\WishlistComponent;
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

Route::get('/product-category/{category_slug}/{scategory_slug?}', CategoryComponent::class)->name('product.category');

Route::get('/search', SearchComponent::class)->name('product.search');

Route::get('/wishlist', WishlistComponent::class)->name('wishlist');
Route::get('/thank-you', ThankyouComponent::class)->name('thankyou');
Route::get('/contact-us', ContactComponent::class)->name('contact');


//Route::get('/category/{slug}', ShopComponent::class)->name('category.products');

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//	return view('dashboard');
//})->name('dashboard');

//for normal user

Route::prefix('user')->middleware(['auth:sanctum', 'verified'])->group(function () {
	Route::get('/dashboard', UserDashboardComponent::class)->name('user.dashboard');
	Route::get('/orders', UserOrdersComponent::class)->name('user.orders');
	Route::get('/order/{order_id}', UserOrderDetailsComponent::class)->name('user.order.details');
	Route::get('/review/{order_item_id}', UserReviewComponent::class)->name('user.review');
	Route::get('/change-password', UserChangePasswordComponent::class)->name('user.changePassword');
	Route::get('/profile', UserProfileComponent::class)->name('user.profile');
	Route::get('/profile/edit/{user_id}', UserEditProfileComponent::class)->name('user.profile.edit');
});

//for admin
Route::prefix('admin')->middleware(['auth:sanctum', 'verified', 'auth_admin'])->group(function () {

	Route::get('/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
	Route::get('/categories', AdminCategoryComponent::class)->name('admin.categories');
	Route::get('/categories/add', AdminAddCategoryComponent::class)->name('admin.categories.add');
	Route::get('/categories/edit/{category_slug}/{scategory_slug?}', AdminEditCategoryComponent::class)->name('admin.categories.edit');
	Route::get('/products', AdminProductComponent::class)->name('admin.products');
	Route::get('/products/add', AdminAddProductComponent::class)->name('admin.products.add');
	Route::get('/products/edit/{product_slug}', AdminEditProductComponent::class)->name('admin.products.edit');
	Route::get('/slider', AdminHomeSliderComponent::class)->name('admin.homeSlider');
	Route::get('/slider/add', AdminAddHomeSliderComponent::class)->name('admin.homeSlider.add');
	Route::get('/slider/edit/{slider_id}', AdminEditHomeSlider::class)->name('admin.homeSlider.edit');
	Route::get('/home/categories', AdminHomeCategoryComponent::class)->name('admin.home.categories');
	Route::get('/home/sale', AdminSaleComponent::class)->name('admin.sale');
	Route::get('/coupons', AdminCouponsComponent::class)->name('admin.coupons');
	Route::get('/coupons/add', AdminAddCouponComponent::class)->name('admin.add.coupon');
	Route::get('/coupons/edit/{coupon_id}', AdminEditCouponComponent::class)->name('admin.edit.coupon');
	Route::get('/orders', AdminOrderComponent::class)->name('admin.orders');
	Route::get('/orders/{order_id}', AdminOrderDetailsComponent::class)->name('admin.order.details');
	Route::get('/contact-us', AdminContactComponent::class)->name('admin.contact');
	Route::get('/settings', AdminSettingComponent::class)->name('admin.settings');
	Route::get('/attributes', AdminAttributesComponent::class)->name('admin.attributes');
	Route::get('/attributes/add', AdminAddAttributeComponent::class)->name('admin.add.attribute');
	Route::get('/attributes/edit/{attribute_id}', AdminEditAttributeComponent::class)->name('admin.edit.attribute');
});
