@extends('layouts.master')
<style>
    @media print {
        #make {
            display: none;
        }

        #edit {
            display: none;
        }

        #delete {
            display: none;
        }

        #print {
            display: none;
        }
    }
</style>
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فاتورة {{ $bill_details[0]->BillID }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ $bill_details[0]->type === 'purch' ? 'المشتريات' : ($bill_details[0]->type === 'sales' ? 'المبيعات' : 'نوع غير معروف') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-xl-12" id="printBody">
            <div class="card-header">
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <h4 class="card-title mb-1">
                    اسم العميل : <span class="text-danger">{{ $bill_details[0]->ClientName }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    كود العميل : <span class="text-danger">{{ $bill_details[0]->ClientNumber }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    رقم الهاتف : <span class="text-danger">{{ $bill_details[0]->ClientPhone }}</span>
                </h4>
                <h4 class="card-title mb-1 mt-4">
                    <?php
                    
                    use Carbon\Carbon;
                    
                    $billDate = $bill_details[0]->BillDate;
                    $carbonDate = Carbon::parse($billDate);
                    $formattedDate = $carbonDate->locale('ar')->isoFormat('dddd DD-MM-YYYY HH:mm');
                    
                    ?>
                    تاريخ الفاتورة : <span class="text-danger"><?php echo $formattedDate; ?></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    رقم الفاتورة : <span class="text-danger">{{ $bill_details[0]->BillID }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    نوع الفاتورة : <span
                        class="text-danger">{{ $bill_details[0]->type === 'purch' ? 'مشتريات' : ($bill_details[0]->type === 'sales' ? 'مبيعات' : 'نوع غير معروف') }}</span>
                </h4>
            </div>
            <div id="printable-content" class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الصنف</th>
                                <th>العدد </th>
                                <th>السعر</th>
                                <th>الاجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($bill_details as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->ItemName }}</td>
                                    <td>
                                        <label for="quantity_{{ $item->ItemID }}">
                                            <div class="col-md-8 mg-t-5 mg-md-t-0">
                                                <input class="form-control" type="number"
                                                    id="quantity_{{ $item->ItemID }}" name="quantities[]"
                                                    value="{{ $item->Quantity }}" disabled>
                                            </div>
                                        </label>
                                    </td>
                                    <td id="purchasePrice_{{ $item->ItemID }}">{{ $item->UnitPrice }}</td>
                                    <td id="itemTotal_{{ $item->ItemID }}">0</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-center">صافي الفاتورة</td>
                                <td colspan="2">
                                    <div class="col-md-5 mg-t-5 mg-md-t-0">
                                        <label class="form-control" id="total_view" name="total_view"></label>
                                    </div>
                                </td>
                            </tr>

                        </tfoot>
                    </table>
                </div><!-- bd -->
            </div><!-- bd -->
            <!-- <form action="{{ url('/') }}" onsubmit="return confirmSubmit()"> -->

            <form class="d-inline-block"
                action="{{ $bill_details[0]->type === 'purch' ? url('/make_purchase_invoice') : url('/make_sales_invoice') }}">
                <div class=" mg-t-10 mg-md-t-0 m-2">
                    <button id="make" class="btn btn-success btn-block" type="submit">انشاء فاتورة جديدة</button>
                </div>
            </form>


            <form class="d-inline-block"
                action="{{ $bill_details[0]->type === 'purch' ? url('/edit_purchase_invoice/' . $bill_details[0]->BillID) : url('/edit_sales_invoice/' . $bill_details[0]->BillID) }}">
                <div class=" mg-t-10 mg-md-t-0 m-2">
                    <button id="edit" class="btn btn-warning btn-block" type="submit">تعديل</button>
                </div>
            </form>


            <form method="POST" class="d-inline-block"
                action="{{ $bill_details[0]->type === 'purch' ? url('/delete_purchase_invoice/' . $bill_details[0]->BillID) : url('/delete_sales_invoice/' . $bill_details[0]->BillID) }}"
                onsubmit="return confirmSubmit()">
                @csrf
                <div class=" mg-t-10 mg-md-t-0 m-2">
                    <button id="delete" class="btn btn-danger btn-block" type="submit">حذف</button>
                </div>
            </form>


            <form id="printForm" class="d-inline-block">
                <div class="mg-t-10 mg-md-t-0 m-2">
                    <button id="print" class="btn btn-primary btn-block" type="button"
                        onclick="print_invoice()">طباعة</button>
                </div>
            </form>

            <script>
                function calculateItemTotal(itemId) {
                    var quantityInput = document.getElementById('quantity_' + itemId);
                    var purchasePriceElement = document.getElementById('purchasePrice_' + itemId);
                    var itemTotalElement = document.getElementById('itemTotal_' + itemId);

                    var quantity = parseFloat(quantityInput.value) || 0;
                    var purchasePrice = parseFloat(purchasePriceElement.textContent) || 0;

                    var itemTotal = quantity * purchasePrice;
                    itemTotalElement.textContent = itemTotal.toFixed(2);
                }

                var quantityInputs = document.querySelectorAll('[id^="quantity_"]');

                quantityInputs.forEach(function(input) {
                    var itemId = input.id.split('_')[1];

                    input.addEventListener('input', function() {
                        calculateItemTotal(itemId);
                    });
                });

                quantityInputs.forEach(function(input) {
                    var itemId = input.id.split('_')[1];
                    calculateItemTotal(itemId);
                });
            </script>

            <script>
                function confirmSubmit() {
                    // Display a confirmation dialog
                    var confirmation = confirm("هل انت متأكد ؟");

                    // If the user clicks "OK" in the confirmation dialog, allow the form to be submitted
                    return confirmation;
                }



                function calculateTotal() {
                    var itemTotalCells = document.querySelectorAll('[id^="itemTotal_"]');
                    var totalViewInput = document.getElementById('total_view');
                    var totalInput = document.getElementById('total');
                    var total = 0;

                    itemTotalCells.forEach(function(itemTotalCell) {
                        var value = parseFloat(itemTotalCell.textContent) || 0;
                        total += value;
                    });

                    totalViewInput.textContent = total.toFixed(2); // Set the total to the input field
                }

                // Call the calculateTotal function whenever an input field changes (item quantity changes)
                var quantityInputs = document.querySelectorAll('[id^="quantity_"]');
                quantityInputs.forEach(function(input) {
                    input.addEventListener('input', calculateTotal);
                });

                // Initial calculation when the page loads
                window.addEventListener('load', calculateTotal);
            </script>
            <script>
                function print_invoice() {
                    var printContents = document.getElementById('printBody').innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    location.reload();
                }
            </script>


        </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
