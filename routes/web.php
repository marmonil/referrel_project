<?php

use App\Http\Controllers\cartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\copunController;
use App\Http\Controllers\coustomRegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\customerloginController;
use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\fontendController;
use App\Http\Controllers\githubController;
use App\Http\Controllers\hobicontroller;
use App\Http\Controllers\productcontroller;
use App\Http\Controllers\usersController;
use App\Http\Controllers\subcategoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\GoogleControler;
use App\Http\Controllers\RollManagerController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Auth;







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
//     return view('welcome');
// });

Auth::routes();
// fontend
Route::get('/', [fontendController::class, 'welcome'])->name('/');
Route::get('product/details/{product_slug}', [fontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [fontendController::class, 'getSize']);
Route::get('/cart', [fontendController::class, 'cart'])->name('cart');
Route::get('/checkout', [fontendController::class, 'checkout'])->name('checkout');
Route::get('/account', [fontendController::class, 'account'])->name('account');
Route::get('/shop', [fontendController::class, 'shop'])->name('shop');


Route::get('contact', [fontendController::class, 'contact'])->name('contact');
Route::get('about', [fontendController::class, 'about'])->name('about');


// user_list
Route::get('users', [usersController::class, 'users'])->name('users');



Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard', [usersController::class, 'dashboard'])->name('dashboard');

//delete
Route::get('/delete/user/{user_id}', [usersController::class, 'delete'])->name('del.user');
Route::get('/profile', [usersController::class, 'profile'])->name('profile');
Route::post('name/change', [usersController::class, 'name_change'])->name('name.change');
Route::post('password/change', [usersController::class, 'password_change'])->name('password.change');
Route::post('/photo/change', [usersController::class, 'photo_change'])->name('photo.change');

//category
Route::get('category/list', [CategoryController::class, 'category'])->name('category');

Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');

Route::get('category/delete/{category_id}', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('category/hard/delete{category_id}', [CategoryController::class, 'hard_delete'])->name('category.hard.delete');

Route::get('category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');

Route::get('category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');

Route::post('category/update', [CategoryController::class, 'category_update'])->name('category.update');

//subcategory controller

Route::get('subcategory', [subcategoryController::class, 'subcetegory'])->name('subcategory');
Route::post('subcategory/store', [subcategoryController::class, 'subcetegory_store'])->name('subcategory.store');

Route::get('subcategory/edit/{subcategory_id}', [subcategoryController::class, 'subcategory_edit'])->name('subcategory.edit');

Route::post('subcategory/update', [subcategoryController::class, 'subcategory_update'])->name('subcategory.update');
Route::get('subcategory/delete/{subcategory_id}', [subcategoryController::class, 'subcategory_delete'])->name('subcategory.delete');


// Product
Route::get('product/add', [productcontroller::class, 'add_product'])->name('add.product');
Route::get('product/delete', [productcontroller::class, 'del_product'])->name('delete.product');
Route::post('/getsubcategory', [productcontroller::class, 'getsubcategory']);
Route::post('product/store', [productcontroller::class, 'product_store'])->name('product.store');
Route::get('product/list', [productcontroller::class, 'product_list'])->name('product.list');
Route::get('product/color/size', [productcontroller::class, 'add_color_size'])->name('add.color.size');
Route::post('add/color', [productcontroller::class, 'add_color'])->name('add.color');
Route::post('add/size', [productcontroller::class, 'add_size'])->name('add.size');
Route::get('delete/size', [productcontroller::class, 'delete_size'])->name('delete.size');
Route::get('inventory/{product_id}', [productcontroller::class, 'inventory'])->name('inventory');
Route::post('add/inventory/', [productcontroller::class, 'add_inventory'])->name('add.inventory');




// Coustomer
Route::get('hobi/register/', [hobicontroller::class, 'hobi_register'])->name('hobi.register');
Route::post('coustomer/register/store', [hobicontroller::class, 'coustomer_register_store'])->name('coustomer.register.store');
Route::post('coustomer/login', [customerloginController::class, 'customer_login'])->name('customer.login');
Route::get('coustomer/logout', [customerloginController::class, 'customer_logout'])->name('customer.logout');
Route::get('invoice/download/{order_id}', [CustomerController::class, 'invoicedownload'])->name('invoicedownload');


//cart
Route::post('/cart/store', [cartController::class, 'cart_store'])->name('cart.store');
Route::get('/cart/delete/{cart_id}', [cartController::class, 'cart_delete'])->name('cart.delete');
Route::post('/cart/update/', [cartController::class, 'cart_update'])->name('cart.update');

//copun
Route::get('/copun', [copunController::class, 'copun'])->name('copun');
Route::post('copun/store', [copunController::class, 'copun_store'])->name('copun.store');
Route::get('copun/delete/{copun_id}', [copunController::class, 'copun_delete'])->name('copun.delete');


//checkout
Route::post('/getCity', [checkoutController::class, 'getCity'])->name('getCity');
Route::post('order/store', [checkoutController::class, 'order_store'])->name('order.store');
Route::get('order/success', [checkoutController::class, 'order_success'])->name('order.success');






// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

//SSLCOMMERZ END

//strpe
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

//review

Route::post('review', [CustomerController::class, 'review'])->name('review');

//password reset
Route::get('password/reset/request/form', [CustomerController::class, 'pass_reset_repassq_form'])->name('pass.reset.repassq.form');
Route::post('password/reset/request/send', [CustomerController::class, 'pass_reset_repassq_send'])->name('pass.reset.req.send');
Route::get('password/reset/form/{reset_token}', [CustomerController::class, 'pass_reset_form'])->name('pass.reset.form');
Route::post('password/reset/update', [CustomerController::class, 'customer_pass_reset_update'])->name('pass.reset.update');

//verify email
Route::get('email/verify/{verify_token}', [hobicontroller::class, 'verify_email'])->name('verify.email');


//<-------------social login ---------------->
//github login
Route::get('/github/redirect', [githubController::class, 'redirct_provider']);
Route::get('/github/callback', [githubController::class, 'provider_to_aplication']);

//google login
Route::get('/google/redirect', [GoogleControler::class, 'redirct_provider']);
Route::get('/google/callback', [GoogleControler::class, 'provider_to_aplication']);

//Facebook login
Route::get('/facebook/redirect', [FacebookController::class, 'redirct_provider']);
Route::get('/facebook/callback', [FacebookController::class, 'provider_to_aplication']);

//roll manager
Route::get('role/manager', [RollManagerController::class, 'role_manager'])->name('role.manager');
Route::post('add/permision', [RollManagerController::class, 'add_permision'])->name('add.permision');
Route::post('add/role', [RollManagerController::class, 'add_role'])->name('add.role');
Route::post('assign/role', [RollManagerController::class, 'assign_role'])->name('assign.role');
Route::get('edit/permission/{user_id}', [RollManagerController::class, 'edit_permission'])->name('edit.permission');
Route::post('update/permission', [RollManagerController::class, 'update_permission'])->name('updata.permission');
Route::get('remove/role/{user_id}', [RollManagerController::class, 'remove_role'])->name('remove.role');
Route::get('edit/role/{role_id}', [RollManagerController::class, 'edit_role'])->name('edit.role');
Route::post('update/role/', [RollManagerController::class, 'update_role'])->name('update.role');


//Products
Route::get('products/', [ProductsController::class, 'products'])->name('products');
Route::post('order/status', [ProductsController::class, 'order_status'])->name('order.status');
