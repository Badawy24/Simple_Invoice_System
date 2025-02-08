<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function view_add_new_item()
    {
        $exist_items = DB::select('SELECT * FROM items DESC');

        return view('items.add_new_item', compact(['exist_items']));
    }
    public function insert_new_item(Request $request)
    {
        $request->validate([
            'item_name' => 'required|unique:Items',
            'purchase_price' => 'required',
            'sales_price' => 'required',
        ]);

        $name = $request->item_name;
        $purchase_price = $request->purchase_price;
        $sales_price = $request->sales_price;
        try {
            $item = DB::insert("INSERT INTO Items (ItemName, PurchPrice, SalePrice,Quantity) values (?,?,?,?)", [$name, $purchase_price, $sales_price, 0]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => "$name موجود بالفعل"]);
        }
        if ($item) {
            return redirect()->back()->with(['success' => "تم اضافة $name بنجاح"]);
        } else {
            return redirect()->back()->with(['failed' => "حدث خطأ ما لم يتم الاضافة"]);
        }
    }
    public function view_edit_item()
    {
        $exist_items = DB::select('SELECT * FROM items');

        return view('items.edit_item', compact(['exist_items']));
    }
    public function edit_new_data_item(Request $request)
    {
        $request->validate([
            'item_name' => 'required|unique:Items',
            'purchase_price' => 'required',
            'sales_price' => 'required',
        ]);
        $item_id = $request->item_id;
        $name = $request->item_name;
        $purchase_price = $request->purchase_price;
        $sales_price = $request->sales_price;

        $update_items = DB::update('UPDATE items SET ItemName = ?, PurchPrice = ?, Saleprice =? Where ItemID = ?', [$name, $purchase_price, $sales_price, $item_id]);
        if ($update_items) {
            return redirect('edit_item')->with(['success' => "تم تعديل $name بنجاح"]);
        } else {
            return redirect('edit_item')->with(['failed' => "حدث خطأ ما لم يتم التعديل"]);
        }
    }
    public function delete_item(Request $request)
    {
        $item_id = $request->item_id;
        $name = $request->item_name;

        $delete_item = DB::table('items')->where('ItemID', $item_id)->delete();
        if ($delete_item) {
            return redirect('edit_item')->with(['del_success' => "تم الحذف $name بنجاح"]);
        } else {
            return redirect('edit_item')->with(['del_failed' => "حدث خطأ ما لم يتم الحذف"]);
        }
    }
}
