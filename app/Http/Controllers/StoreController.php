<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function view_store()
    {
        $items_in_store = DB::select('SELECT * FROM Items WHERE Quantity IS NOT NULL');

        return view('view_store', compact('items_in_store'));
    }
}
