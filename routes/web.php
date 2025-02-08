<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ViewInvoicesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\DB;

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
    return view('view_store');
});

// Route::get('/{page}', [AdminController::class, 'index']);
// ------- Store
Route::get('/', [StoreController::class, 'view_store']);

// -------- Items 
Route::get('/add_new_item', [ItemsController::class, 'view_add_new_item']);
Route::post('/insert_new_item', [ItemsController::class, 'insert_new_item']);
Route::get('/edit_item', [ItemsController::class, 'view_edit_item']);
Route::post('/edit_new_data_item', [ItemsController::class, 'edit_new_data_item']);
Route::post('/delete_item', [ItemsController::class, 'delete_item']);

// use Illuminate\Http\Request;

// -------- Purches 
Route::get('/make_purchase_invoice', [PurchaseController::class, 'view_make_purchase_invoice']);
Route::post('/insert_new_purchase_invoice', [PurchaseController::class, 'insert_new_purchase_invoice']);
Route::get('/view_purch_invoice/{bill_id}', [PurchaseController::class, 'view_purch_invoice']);
Route::get('/edit_purchase_invoice/{bill_id}', [PurchaseController::class, 'edit_purchase_invoice']);
Route::post('/confirm_edit_purchase_invoice/{bill_id}', [PurchaseController::class, 'confirm_edit_purchase_invoice']);
Route::post('/delete_purchase_invoice/{bill_id}', [PurchaseController::class, 'delete_purchase_invoice']);
Route::post('/insert_new_purchase_invoice_exist_client', [PurchaseController::class, 'insert_new_purchase_invoice_exist_client']);
Route::get('/view_edit_purchase_invoice', [PurchaseController::class, 'view_edit_purchase_invoice']);

// -------- Sales 
Route::get('/make_sales_invoice', [SalesController::class, 'view_make_sales_invoice']);
Route::post('/insert_new_sales_invoice', [SalesController::class, 'insert_new_sales_invoice']);
Route::get('/view_sales_invoice/{bill_id}', [SalesController::class, 'view_sales_invoice']);
Route::get('/edit_sales_invoice/{bill_id}', [SalesController::class, 'edit_sales_invoice']);
Route::post('/confirm_edit_sales_invoice/{bill_id}', [SalesController::class, 'confirm_edit_sales_invoice']);
Route::post('/delete_sales_invoice/{bill_id}', [SalesController::class, 'delete_sales_invoice']);
Route::post('/insert_new_sales_invoice_exist_client', [SalesController::class, 'insert_new_sales_invoice_exist_client']);
Route::get('/view_edit_sales_invoice', [SalesController::class, 'view_edit_sales_invoice']);

// ---------- View Invoices 
Route::get('/view_all_invoices', [ViewInvoicesController::class, 'view_all_invoices']);
Route::get('/view_sales_invoices', [ViewInvoicesController::class, 'view_sales_invoices']);
Route::get('/view_purches_invoices', [ViewInvoicesController::class, 'view_purches_invoices']);

// ---------- View Clients 
Route::get('/view_clients_data', [ClientsController::class, 'view_clients_data']);
Route::get('/show_client_invoices/{ClientID}', [ClientsController::class, 'show_client_invoices']);

// Route::get('/get', function (Request $request) {
//     echo $request->select;
// });
