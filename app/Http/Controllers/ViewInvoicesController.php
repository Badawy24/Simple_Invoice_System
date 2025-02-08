<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewInvoicesController extends Controller
{
    // ----------------------------
    public function view_all_invoices()
    {
        $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
                        JOIN Clients ON Bills.ClientID = Clients.ClientID");


        return view('bills.invoices', compact('bills'));
    }
    // ----------------------------
    public function view_sales_invoices()
    {
        $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
                        JOIN Clients ON Bills.ClientID = Clients.ClientID WHERE type = 'sales'");


        return view('bills.sales_invoice', compact('bills'));
    }
    // ----------------------------
    public function view_purches_invoices()
    {
        $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
                        JOIN Clients ON Bills.ClientID = Clients.ClientID WHERE type = 'purch'");


        return view('bills.purches_invoice', compact('bills'));
    }
}
