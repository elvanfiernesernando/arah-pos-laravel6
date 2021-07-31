<?php

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
    return redirect(route('login'));
});

Route::get('/register', function () {
    return redirect(route('register'));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/registration/wizard', 'WizardController@index')->name('wizard.index');
    Route::POST('/registration/wizard/store', 'WizardController@store')->name('wizard.store');

    //home / Dashboard kita taruh diluar group karena semua jenis user yg login bisa mengaksesnya
    Route::get('/home', 'HomeController@index')->name('home');

    //route yang berada dalam group ini, hanya bisa diakses oleh user
    //yang memiliki permission yang telah disebutkan dibawah
    // Kenapa harus memiliki Permission Category dan Product? Tidak salah satunya saja?
    // Karena kita tidak bisa membuat product tanpa mengakses Category
    Route::group(['middleware' => ['role_or_permission:Master|Access Category Page|Create Category|Edit Category|Delete Category|Access Product Page|Create Product|Edit Product|Delete Product']], function () {
        Route::resource('/category', 'CategoryController');

        Route::resource('/product', 'ProductController');

        Route::POST('/product/category', 'ProductController@category');
    });

    Route::group(['middleware' => ['role_or_permission:Master|Access Business Unit Page|Create Business Unit|Edit Business Unit|Delete Business Unit|Access Outlet Page|Create Outlet|Edit Outlet|Delete Outlet']], function () {
        Route::resource('/business-unit', 'BusinessUnitController');

        Route::resource('/outlet', 'BranchController');
    });

    Route::group(['middleware' => ['role_or_permission:Master|Access Employee Page|Create Business Unit']], function () {
        Route::resource('/user', 'UserController')->except([
            'show'
        ]);

        Route::POST('/user/branch', 'UserController@branch');
    });


    Route::resource('/role', 'RoleController')->except([
        'create', 'show', 'edit', 'update'
    ]);

    Route::get('/transaction', 'TransactionController@index')->name('transaction.index');
    Route::get('/transaction/getproducts', 'TransactionController@getProductsData');

    Route::resource('/company', 'CompanyController');

    //Route yang berada dalam group ini hanya dapat diakses oleh user
    //yang memiliki role admin

    Route::group(['middleware' => ['role:Admin']], function () {
    });

    //route group untuk kasir
    Route::group(['middleware' => ['role:Cashier']], function () {
        // Route untuk Cart
        Route::post('/transaction/addtocart/{id}', 'TransactionController@addProductCart');
        Route::post('/transaction/increasecart/{id}', 'TransactionController@increaseCart');
        Route::post('/transaction/decreasecart/{id}', 'TransactionController@decreaseCart');
        Route::post('/transaction/payout', 'TransactionController@payout');
    });


    // Route Business Unit
    // Route::post('/business-unit', 'CompanyController@addBusinessUnit')->name('company.add_business_unit');
    // Route::get('/business-unit/create', 'CompanyController@createBusinessUnit');
    // Route::post('/company/add-branch', 'CompanyController@addBranch')->name('company.add_branch');

    Route::get('permission/role-permission', 'PermissionController@rolePermission')->name('permission.roles_permission');
    Route::post('permission/add-permission', 'PermissionController@addPermission')->name('permission.add_permission');
    Route::put('permission/{role}/set', 'PermissionController@setRolePermission')->name('permission.setRolePermission');

    Route::post('/customer/search', 'CustomerController@search');
});
