<?php

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

Route::group(['middleware' => ['web']], function() {

  Route::get('/login', 'Home\LoginController@page')->name('pageLogin');
  Route::get('/set-locale/{locale}', 'Controller@setLocale')->name('controllerSetLocale');
  Route::post('/login', 'Home\LoginController@login')->name('controllerLogin');

});

Route::group(['middleware' => ['web', 'auth']], function() {

  Route::get('/', 'Auth\DashboardController@page')->name('pageDashboard');
  Route::get('/logout', 'Auth\DashboardController@logout')->name('controllerLogout');
  Route::get('/clear-cache', 'Auth\DashboardController@clearCache')->name('controllerClearCache');
  
  /** ACCOUNT */
  Route::prefix('account')->group(function () {
    Route::prefix('profile')->group(function () {
      Route::get('/account-password', 'Auth\Account\Profile\AccountPasswordController@page')->name('pageAccountProfileAccountPassword');
      Route::post('/account-password', 'Auth\Account\Profile\AccountPasswordController@updatePassword')->name('controllerAccountPasswordUpdatePassword');
    });
    Route::prefix('my-payments')->group(function () {
      Route::get('/', 'Auth\Account\MyPaymentsController@page')->name('pageAccountMyPayments');
      Route::post('/search', 'Auth\Account\MyPaymentsController@searchMyPayments')->name('controllerAccountMyPaymentsSearchMyPayments');
    });
    Route::prefix('my-orders')->group(function () {
      Route::get('/', 'Auth\Account\MyOrdersController@page')->name('pageAccountMyOrders');
      Route::post('/search', 'Auth\Account\MyOrdersController@searchMyOrders')->name('controllerAccountMyOrdersSearchMyOrders');
    });
    Route::prefix('my-wallets')->group(function () {
      Route::get('/', 'Auth\Account\MyWalletsController@page')->name('pageAccountMyWallets');
    });
    Route::prefix('my-wallets-transactions')->group(function () {
      Route::get('/', 'Auth\Account\MyWalletsTransactionsController@page')->name('pageAccountMyWalletsTransactions');
      Route::post('/search', 'Auth\Account\MyWalletsTransactionsController@searchMyWalletsTransactions')->name('controllerAccountMyWalletsTransactionsSearchMyWalletsTransactions');
    });
  });

  /** MANAGEMENT */
  Route::prefix('management')->group(function () {
    /** Users */
    Route::prefix('users')->group(function () {
      Route::get('/', 'Auth\Management\UsersController@page')->name('pageManagementUsers');
      Route::post('/search', 'Auth\Management\UsersController@searchUsers')->name('controllerManagementUsersSearchUsers');
      Route::post('/add', 'Auth\Management\UsersController@addUser')->name('controllerManagementUsersAddUser');
      Route::post('/get', 'Auth\Management\UsersController@getUser')->name('controllerManagementUsersGetUser');
      Route::post('/update', 'Auth\Management\UsersController@updateUser')->name('controllerManagementUsersUpdateUser');
    });

    /** Payments */
    Route::prefix('payments')->group(function () {
      Route::get('/', 'Auth\Management\PaymentsController@page')->name('pageManagementPayments');
      Route::post('/search', 'Auth\Management\PaymentsController@searchPayments')->name('controllerManagementPaymentsSearchPayments');
    });

    /** Orders */
    Route::prefix('orders')->group(function () {
      Route::get('/', 'Auth\Management\OrdersController@page')->name('pageManagementOrders');
      Route::post('/search', 'Auth\Management\OrdersController@searchOrders')->name('controllerManagementOrdersSearchOrders');
    });

    /** Wallets */
    Route::prefix('wallets')->group(function () {
      Route::get('/', 'Auth\Management\WalletsController@page')->name('pageManagementWallets');
      Route::post('/search', 'Auth\Management\WalletsController@searchWallets')->name('controllerManagementWalletsSearchWallets');
    });

    /** Wallets Transactions */
    Route::prefix('wallets-transactions')->group(function () {
      Route::get('/', 'Auth\Management\WalletsTransactionsController@page')->name('pageManagementWalletsTransactions');
      Route::post('/search', 'Auth\Management\WalletsTransactionsController@searchWalletsTransactions')->name('controllerManagementWalletsTransactionsSearchWalletsTransactions');
    });
  });
});
