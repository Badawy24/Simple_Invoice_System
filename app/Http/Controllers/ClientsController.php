<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function view_clients_data()
    {
        $bills = DB::select(" SELECT
                                Clients.ClientName,
                                Clients.ClientNumber,
                                Clients.ClientPhone,
                                Clients.ClientID,
                                COUNT(Bills.BillID) AS NumberOfInvoices,
                                SUM(CASE WHEN Bills.type = 'purch' THEN Bills.TotalAmount ELSE 0 END) AS TotalPurchBills,
                                SUM(CASE WHEN Bills.type = 'sales' THEN Bills.TotalAmount ELSE 0 END) AS TotalSalesBills
                            FROM
                                Clients
                            LEFT JOIN
                                Bills ON Clients.ClientID = Bills.ClientID
                            WHERE
                                Bills.type IN ('purch', 'sales')
                            GROUP BY
                                Clients.ClientName, Clients.ClientNumber, Clients.ClientPhone
                        ");
        // $bills = DB::select("SELECT Bills.*, Clients.* FROM Bills
        //                 JOIN Clients ON Bills.ClientID = Clients.ClientID");


        return view('clients.view_clients_data', compact('bills'));
    }

    public function show_client_invoices($ClientID)
    {
        $client = DB::table('Clients')
            ->select('ClientName', 'ClientNumber', 'ClientPhone')
            ->where('ClientID', $ClientID)
            ->first();

        $bills_of_client = DB::table('Bills')->where('Bills.ClientID', $ClientID)->get();

        $invoices = DB::table('Bills')
            ->join('BillItems', 'Bills.BillID', '=', 'BillItems.BillID')
            ->join('Items', 'BillItems.ItemID', '=', 'Items.ItemID')
            ->where('Bills.ClientID', $ClientID)
            ->orderBy('Bills.BillDate')
            ->select(
                'Bills.BillID',
                'Bills.BillDate',
                'Bills.type',
                'BillItems.Quantity',
                'Items.ItemName',
                'BillItems.UnitPrice',
                'BillItems.discount',
                'BillItems.finalPrice',
                'Bills.TotalAmount',
                'Bills.discount_bill'
            )
            ->get();

        $invoicesWithItems = [];

        foreach ($invoices as $invoice) {
            $invoiceId = $invoice->BillID;

            if (!isset($invoicesWithItems[$invoiceId])) {
                // Initialize the invoice details if it doesn't exist in the array
                $invoicesWithItems[$invoiceId] = [
                    'BillID' => $invoice->BillID,
                    'BillDate' => $invoice->BillDate,
                    'type' => $invoice->type,
                    'items' => [],
                    'TotalAmount' => $invoice->TotalAmount,
                    'discount_bill' => $invoice->discount_bill,
                ];
            }

            // Add the item details to the invoice
            $invoicesWithItems[$invoiceId]['items'][] = [
                'ItemName' => $invoice->ItemName,
                'Quantity' => $invoice->Quantity,
                'UnitPrice' => $invoice->UnitPrice,
                'discount' => $invoice->discount,
                'finalPrice' => $invoice->finalPrice,

            ];
        }
        // return view('invoices', compact('client', 'invoices'));
        $bills_num = $bills_of_client->count();

        // Pass the data to the view
        return view('clients.client_invoices', compact('invoicesWithItems', 'client', 'bills_num'));
    }
}
