<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    // ----------------------------------------------------------------
    public function view_make_purchase_invoice()
    {

        $items = DB::select('SELECT * FROM Items');
        $clients = DB::select('SELECT * FROM Clients');

        return view('purches.make_purchase_invoice', compact('items', 'clients'));
    }
    // ----------------------------
    public function view_edit_purchase_invoice()
    {

        $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
        JOIN Clients ON Bills.ClientID = Clients.ClientID WHERE type = 'purch'");


        return view('purches.view_edit_purches_invoice', compact('bills'));
    }
    // ----------------------------
    public function insert_new_purchase_invoice(Request $request)
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

            $updatedQuantity = $currentQuantity + $newQuantity;

            DB::table('Items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => $updatedQuantity]);
        }

        // Store Purchases OF each Items
        $itemIds = $request->input('items');
        $quantitiesPurchased = $request->input('quantities');


        $purchaseData = [];

        foreach ($itemIds as $index => $itemId) {
            $quantityPurchased = $quantitiesPurchased[$index];

            if ($quantityPurchased > 0) {
                $purchasePrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('PurchPrice');

                $totalCost = $quantityPurchased * $purchasePrice;

                // $purchaseData[] = [
                //     'PurchaseDate' => $DateToday,
                //     'ItemID' => $itemId,
                //     'QuantityPurchased' => $quantityPurchased,
                //     'TotalCost' => $totalCost,
                // ];
            }
        }

        // DB::table('Purchases')->insert($purchaseData);

        // Store the purchase invoice
        DB::table('Bills')->insert([
            'BillDate' => $DateToday,
            'ClientID' => $clientId,
            'TotalAmount' => $total_invoice,
            'type' => 'purch',
            'discount_bill' => 0,
        ]);
        $lastInsertedBillID = DB::getPdo()->lastInsertId();

        // Store the invoice with item detalis into the BillsItems Table 
        $itemIds = $request->input('items');

        $quantitiesPurchased = $request->input('quantities');

        $billItemsData = [];


        foreach ($itemIds as $index => $itemId) {
            $quantityPurchased = $quantitiesPurchased[$index];

            if ($quantityPurchased > 0) {
                $purchasePrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('PurchPrice');

                $totalCost = $quantityPurchased * $purchasePrice;


                $billItemsData[] = [
                    'BillID' => $lastInsertedBillID,
                    'ItemID' => $itemId,
                    'Quantity' => $quantityPurchased,
                    'unitPrice' => $purchasePrice,
                    'TotalPrice' => $totalCost,
                    'discount' => 0,
                    'finalPrice' => $totalCost - 0
                ];
            }
        }
        DB::table('BillItems')->insert($billItemsData);
        return redirect("/view_purch_invoice/$lastInsertedBillID");
    }
    // ----------------------------
    public function insert_new_purchase_invoice_exist_client(Request $request)
    {
        $selectedClientNames = $request->input('client_name_select');
        $selectedClientCodes = $request->input('client_code_select');
        $selectedClientPhones = $request->input('client_phone_select');
        // return dd($selectedClientNames, $selectedClientCodes, $selectedClientPhones);
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

            $updatedQuantity = $currentQuantity + $newQuantity;

            DB::table('Items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => $updatedQuantity]);
        }

        // Store Purchases OF each Items
        $itemIds = $request->input('items');
        $quantitiesPurchased = $request->input('quantities');


        $purchaseData = [];

        foreach ($itemIds as $index => $itemId) {
            $quantityPurchased = $quantitiesPurchased[$index];

            if ($quantityPurchased > 0) {
                $purchasePrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('PurchPrice');

                $totalCost = $quantityPurchased * $purchasePrice;

                // $purchaseData[] = [
                //     'PurchaseDate' => $DateToday,
                //     'ItemID' => $itemId,
                //     'QuantityPurchased' => $quantityPurchased,
                //     'TotalCost' => $totalCost,
                // ];
            }
        }

        // DB::table('Purchases')->insert($purchaseData);

        // Store the purchase invoice
        DB::table('Bills')->insert([
            'BillDate' => $DateToday,
            'ClientID' => $clientId,
            'TotalAmount' => $total_invoice,
            'type' => 'purch',
            'discount_bill' => 0,
        ]);
        $lastInsertedBillID = DB::getPdo()->lastInsertId();

        // Store the invoice with item detalis into the BillsItems Table 
        $itemIds = $request->input('items');

        $quantitiesPurchased = $request->input('quantities');

        $billItemsData = [];


        foreach ($itemIds as $index => $itemId) {
            $quantityPurchased = $quantitiesPurchased[$index];

            if ($quantityPurchased > 0) {
                $purchasePrice = DB::table('Items')
                    ->where('ItemID', $itemId)
                    ->value('PurchPrice');

                $totalCost = $quantityPurchased * $purchasePrice;


                $billItemsData[] = [
                    'BillID' => $lastInsertedBillID,
                    'ItemID' => $itemId,
                    'Quantity' => $quantityPurchased,
                    'unitPrice' => $purchasePrice,
                    'TotalPrice' => $totalCost,
                    'discount' => 0,
                    'finalPrice' => $totalCost - 0
                ];
            }
        }
        DB::table('BillItems')->insert($billItemsData);
        return redirect("/view_purch_invoice/$lastInsertedBillID");
    }
    // ----------------------------
    public function view_purch_invoice($bill_id)
    {
        $bill_details = DB::select('
        SELECT 
            BillItems.*,
            Items.ItemName,
            Items.PurchPrice,
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

        return view('purches.view_purch_invoice', compact('bill_details'));
    }
    // ----------------------------
    public function edit_purchase_invoice($bill_id)
    {

        $bill_details = DB::select('
        SELECT 
            BillItems.*,
            Items.ItemName,
            Items.PurchPrice,
            Bills.BillID,
            Bills.ClientID,
            Bills.BillDate,
            Clients.ClientName,
            Clients.ClientNumber,
            Clients.ClientPhone
        FROM BillItems
        JOIN Items ON BillItems.ItemID = Items.ItemID
        JOIN Bills ON BillItems.BillID = Bills.BillID
        JOIN Clients ON Bills.ClientID = Clients.ClientID
        WHERE BillItems.BillID = ?
    ', [$bill_id]);

        return view('purches.edit_purchase_invoice', compact('bill_details'));
    }

    // ----------------------------
    public function confirm_edit_purchase_invoice($bill_id, Request $request)
    {
        $old_itemQuantities = $request->input('real_quantities');
        $new_itemQuantities = $request->input('edit_quantities');
        $new_total = $request->input('new_total');

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
            ]);

        // update Quantity Items in BillItems
        $itemIds = $request->input('items');
        $quantitiesPurchased = $request->input('edit_quantities');

        foreach ($itemIds as $index => $itemId) {
            $quantityPurchased = $quantitiesPurchased[$index];

            $purchasePrice = DB::table('Items')
                ->where('ItemID', $itemId)
                ->value('PurchPrice');

            $totalCost = $quantityPurchased * $purchasePrice;

            // Update the 'Quantity' and 'TotalPrice' columns in 'BillItems' table
            DB::table('BillItems')
                ->where('BillID', $bill_id)
                ->where('ItemID', $itemId)
                ->update([
                    'Quantity' => $quantityPurchased,
                    'TotalPrice' => $totalCost,
                    'finalPrice' => $totalCost,
                ]);
        }

        return redirect("/view_purch_invoice/$bill_id");
    }
    public function delete_purchase_invoice($bill_id)
    {
        // Step 1: Retrieve relevant data
        $bill = DB::table('Bills')->where('BillId', $bill_id)->first();

        if (!$bill) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }
        $billItems = DB::table('BillItems')->where('BillID', $bill_id)->get();

        foreach ($billItems as $billItem) {
            $itemId = $billItem->ItemID;
            $quantity = $billItem->Quantity;

            // Subtract the quantity from the 'Items' table
            DB::table('items')
                ->where('ItemID', $itemId)
                ->update(['Quantity' => DB::raw("Quantity - $quantity")]);
        }

        // Step 3: Delete the invoice
        DB::table('Bills')->where('BillId', $bill_id)->delete();
        return redirect("/make_purchase_invoice")->with('delete_done', 'تم الحذف بنجاح');
    }
}
