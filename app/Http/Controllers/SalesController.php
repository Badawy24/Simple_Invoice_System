<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    // ----------------------------------------------------------------
    public function view_make_sales_invoice()
    {

        $items = DB::select('SELECT * FROM Items');
        $clients = DB::select('SELECT * FROM Clients');

        return view('sales.make_sales_invoice', compact('items', 'clients'));
    }
    // ----------------------------
    public function insert_new_sales_invoice_exist_client(Request $request)
    {
        $selectedClientNames = $request->input('client_name_select');
        $selectedClientCodes = $request->input('client_code_select');
        $selectedClientPhones = $request->input('client_phone_select');

        if (empty($selectedClientNames) && empty($selectedClientCodes) && empty($selectedClientPhones)) {
            return back()->with('client_data_error', 'يجب اختيار بيانات العميل');
        }
        $DateToday = Carbon::now();

        $total_invoice = $request->total;
        $clientId = 0;
        if (!empty($selectedClientNames)) {
            $clientId = $selectedClientNames;
        } elseif (!empty($selectedClientCodes)) {
            $clientId = $selectedClientCodes;
        } elseif (!empty($selectedClientPhones)) {
            $clientId = $selectedClientPhones;
        } else {
            return back()->with('client_data_error', 'حدث خطأ ما');
        }

        // Update the Quantity Of Items 
        $itemQuantities = $request->input('quantities');
        foreach ($itemQuantities as $index => $newQuantity) {
            $itemId = $request->input('items')[$index];

            $currentQuantity = DB::table('Items')
                ->where('ItemID', $itemId)
                ->value('Quantity');

            $updatedQuantity = $currentQuantity - $newQuantity;

            DB::table('Items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => $updatedQuantity]);
        }

        // Store Sales OF each Items
        $itemIds = $request->input('items');
        $quantitiesSales = $request->input('quantities');
        $discountsInvoice = $request->input('discount_view');


        $salesData = [];

        foreach ($itemIds as $index => $itemId) {
            $quantitySales = $quantitiesSales[$index];
            if ($quantitySales > 0) {
                $SalesPrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('SalePrice');

                $totalCost = $quantitySales * $SalesPrice;
            }
        }



        // Store the sales invoice
        DB::table('Bills')->insert([
            'BillDate' => $DateToday,
            'ClientID' => $clientId,
            'TotalAmount' => $total_invoice,
            'type' => 'sales',
            'discount_bill' => $discountsInvoice,
        ]);
        $lastInsertedBillID = DB::getPdo()->lastInsertId();

        // Store the invoice with item detalis into the BillsItems Table 
        $itemIds = $request->input('items');

        $quantitiesSales = $request->input('quantities');
        $discountsItem = $request->input('discounts');

        $billItemsData = [];


        foreach ($itemIds as $index => $itemId) {
            $quantitySales = $quantitiesSales[$index];
            $discountsItems = $discountsItem[$index];

            if ($quantitySales > 0) {
                $salesPrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('SalePrice');

                $totalCost = $quantitySales * $salesPrice;

                $discount_value = ($totalCost * $discountsItems) / 100;

                $final_price = $totalCost - $discount_value;
                $billItemsData[] = [
                    'BillID' => $lastInsertedBillID,
                    'ItemID' => $itemId,
                    'Quantity' => $quantitySales,
                    'unitPrice' => $salesPrice,
                    'TotalPrice' => $totalCost,
                    'discount' => $discountsItems,
                    'finalPrice' => $final_price
                ];
            }
        }
        DB::table('BillItems')->insert($billItemsData);
        return redirect("/view_sales_invoice/$lastInsertedBillID");
    }
    // ----------------------------
    public function insert_new_sales_invoice(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'client_code' => 'required|unique:Clients',
            'phone' => 'required|unique:Clients|min:11',
        ]);
        $DateToday = Carbon::now();

        $client_name = $request->client_name;
        $client_code = $request->client_code;
        $client_phone = $request->phone;
        $total_invoice = $request->total;

        // Store The Client information
        try {
            $insert_client = DB::insert("INSERT INTO Clients (ClientName, ClientNumber, ClientPhone) VALUES(?,?,?)", [$client_name, $client_code, $client_phone]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['failed_code' => "كود العميل مقرر ، يرجي اختيار كود اخر"]);
        }
        $clientId = DB::getPdo()->lastInsertId();

        // Update the Quantity Of Items 
        $itemQuantities = $request->input('quantities');
        foreach ($itemQuantities as $index => $newQuantity) {
            $itemId = $request->input('items')[$index];

            $currentQuantity = DB::table('Items')
                ->where('ItemID', $itemId)
                ->value('Quantity');

            $updatedQuantity = $currentQuantity - $newQuantity;

            DB::table('Items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => $updatedQuantity]);
        }

        // Store Sales OF each Items
        $itemIds = $request->input('items');
        $quantitiesSales = $request->input('quantities');
        $discountsInvoice = $request->input('discount_view');

        $salesData = [];

        foreach ($itemIds as $index => $itemId) {
            $quantitySales = $quantitiesSales[$index];

            if ($quantitySales > 0) {
                $salesPrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('SalePrice');

                $totalCost = $quantitySales * $salesPrice;
            }
        }


        // Store the sales invoice
        DB::table('Bills')->insert([
            'BillDate' => $DateToday,
            'ClientID' => $clientId,
            'TotalAmount' => $total_invoice,
            'type' => 'sales',
            'discount_bill' => $discountsInvoice,
        ]);
        $lastInsertedBillID = DB::getPdo()->lastInsertId();

        // Store the invoice with item detalis into the BillsItems Table 
        $itemIds = $request->input('items');

        $quantitiesSales = $request->input('quantities');
        $discountsItem = $request->input('discounts');


        $billItemsData = [];


        foreach ($itemIds as $index => $itemId) {
            $quantitySales = $quantitiesSales[$index];
            $discountsItems = $discountsItem[$index];

            if ($quantitySales > 0) {
                $salesPrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('SalePrice');

                $totalCost = $quantitySales * $salesPrice;

                $discount_value = ($totalCost * $discountsItems) / 100;

                $final_price = $totalCost - $discount_value;

                $billItemsData[] = [
                    'BillID' => $lastInsertedBillID,
                    'ItemID' => $itemId,
                    'Quantity' => $quantitySales,
                    'unitPrice' => $salesPrice,
                    'TotalPrice' => $totalCost,
                    'discount' => $discountsItems,
                    'finalPrice' => $final_price
                ];
            }
        }
        DB::table('BillItems')->insert($billItemsData);
        return redirect("/view_sales_invoice/$lastInsertedBillID");
    }
    // ----------------------------
    public function view_sales_invoice($bill_id)
    {
        $bill_details = DB::select('
            SELECT 
                BillItems.*,
                Items.ItemName,
                Items.SalePrice,
                Bills.*,
                Clients.ClientName,
                Clients.ClientNumber,
                Clients.ClientPhone
            FROM BillItems
            JOIN Items ON BillItems.ItemID = Items.ItemID
            JOIN Bills ON BillItems.BillID = Bills.BillID
            JOIN Clients ON Bills.ClientID = Clients.ClientID
            WHERE BillItems.BillID = ?
        ', [$bill_id]);

        $bill_total = $bill_details[0]->TotalAmount;
        $bill_discount = $bill_details[0]->discount_bill;
        $discount_value = ($bill_total * $bill_discount) / 100;
        $total_with_discount = $bill_total - $discount_value;
        return view('sales.view_sales_invoice', compact('bill_details', 'total_with_discount'));
    }
    // ----------------------------
    public function view_edit_sales_invoice()
    {

        $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
                        JOIN Clients ON Bills.ClientID = Clients.ClientID WHERE type = 'sales'");


        return view('sales.view_edit_sales_invoice', compact('bills'));
    }


    // ----------------------------

    public function edit_sales_invoice($bill_id)
    {

        $bill_details = DB::select('
            SELECT 
                BillItems.*,
                Items.ItemName,
                Items.SalePrice,
                Bills.*,
                Clients.ClientName,
                Clients.ClientNumber,
                Clients.ClientPhone
            FROM BillItems
            JOIN Items ON BillItems.ItemID = Items.ItemID
            JOIN Bills ON BillItems.BillID = Bills.BillID
            JOIN Clients ON Bills.ClientID = Clients.ClientID
            WHERE BillItems.BillID = ?
        ', [$bill_id]);

        return view('sales.edit_sales_invoice', compact('bill_details'));
    }

    // ----------------------------
    public function confirm_edit_sales_invoice($bill_id, Request $request)
    {
        $old_itemQuantities = $request->input('real_quantities');
        $new_itemQuantities = $request->input('edit_quantities');
        $new_total = $request->input('new_total');
        $discounts = $request->input('discounts');
        $discount_total = $request->input('discount_view');

        foreach ($new_itemQuantities as $index => $newQuantity) {
            $itemId = $request->input('items')[$index];
            $oldQuantity = $old_itemQuantities[$index];

            $difference = $newQuantity - $oldQuantity;

            // update quantity In Items 
            DB::table('items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => DB::raw("Quantity + $difference")]);
        }

        // update Total Invoice in Bills
        DB::table('Bills')
            ->where('BillId', $bill_id)
            ->update([
                'TotalAmount' => $new_total,
                'discount_bill' => $discount_total
            ]);

        // update Quantity Items in BillItems
        $itemIds = $request->input('items');
        $quantitiesSales = $request->input('edit_quantities');
        $discounts = $request->input('discounts');

        foreach ($itemIds as $index => $itemId) {
            $quantitySales = $quantitiesSales[$index];
            $discountItem = $discounts[$index];

            $salesPrice = DB::table('Items')
                ->where('ItemID', $itemId)
                ->value('SalePrice');

            $totalCost = $quantitySales * $salesPrice;

            $discount_value = ($totalCost * $discountItem) / 100;

            $final_price = $totalCost - $discount_value;
            // Update the 'Quantity' and 'TotalPrice' columns in 'BillItems' table
            DB::table('BillItems')
                ->where('BillID', $bill_id)
                ->where('ItemID', $itemId)
                ->update([
                    'Quantity' => $quantitySales,
                    'TotalPrice' => $totalCost,
                    'finalPrice' => $final_price,
                    'discount' => $discountItem,
                ]);
        }

        return redirect("/view_sales_invoice/$bill_id");
    }
    public function delete_sales_invoice($bill_id)
    {
        $bill = DB::table('Bills')->where('BillId', $bill_id)->first();

        if (!$bill) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }
        $billItems = DB::table('BillItems')->where('BillID', $bill_id)->get();

        foreach ($billItems as $billItem) {
            $itemId = $billItem->ItemID;
            $quantity = $billItem->Quantity;

            DB::table('items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => DB::raw("Quantity - $quantity")]);
        }

        DB::table('Bills')->where('BillId', $bill_id)->delete();
        return redirect("/view_edit_sales_invoice")->with('delete_done', 'تم الحذف بنجاح');
    }
}
