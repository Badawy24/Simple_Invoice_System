@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">فاتورة {{$bill_details[0]->BillID}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المبيعات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card-header">
            <h4 class="card-title mb-1">
                اسم العميل : <span class="text-danger">{{$bill_details[0]->ClientName}}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                كود العميل : <span class="text-danger">{{$bill_details[0]->ClientNumber}}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                رقم الهاتف : <span class="text-danger">{{$bill_details[0]->ClientPhone}}</span>
            </h4>
            <h4 class="card-title mb-1 mt-4">
                <?php

                use Carbon\Carbon;

                $billDate = $bill_details[0]->BillDate;
                // $dateTime = new DateTime($billDate);
                $carbonDate = Carbon::parse($billDate);
                // Format the date to display the name of the day and hours and minutes
                // $formattedDate = $dateTime->format('l d-m-Y H:i');
                $formattedDate = $carbonDate->locale('ar')->isoFormat('dddd DD-MM-YYYY HH:mm');
                // Output the formatted date

                ?>
                تاريخ الفاتورة : <span class="text-danger"><?php echo $formattedDate; ?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                رقم الفاتورة : <span class="text-danger">{{$bill_details[0]->BillID}}</span>
            </h4>
        </div>
        <div id="printable-content" class="card-body">
            <div class="table-responsive">
                <form method="POST" action="/confirm_edit_sales_invoice/{{$bill_details[0]->BillID}}">
                    @csrf

                    <table class="table table-striped mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الصنف</th>
                                <th>عدد الشراء</th>
                                <th>السعر</th>
                                <th>خصم</th>
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
                                            <input type="hidden" name="real_quantities[]" value="{{ $item->Quantity }}">
                                            <input class="form-control" type="number" id="quantity_{{ $item->ItemID }}" name="edit_quantities[]" value="{{ $item->Quantity }}">
                                            <input type="hidden" name="items[]" value="{{ $item->ItemID }}">
                                        </div>
                                    </label>
                                </td>
                                <td id="purchasePrice_{{ $item->ItemID }}">{{ $item->UnitPrice }}</td>
                                <td>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <input class="form-control" type="number" id="discount_{{ $item->ItemID }}" name="discounts[]" value="{{ $item->discount }}">
                                    </div>
                                </td>
                                <td id="itemTotal_{{ $item->ItemID }}">0</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center">صافي الفاتورة</td>

                                <td>
                                    <div class="col-md-5 mg-t-5 mg-md-t-0">
                                        <label class="form-control" id="total_view" name="total_view"></label>
                                        <input hidden id="total" name="new_total">
                                    </div>
                                </td>
                                <td colspan="2" class="text-center">خصم الفاتورة</td>
                                <td>
                                    <div class="col-md-5 mg-t-5 mg-md-t-0">
                                        <!-------------------------------------------------------------  -->
                                        <input class="form-control" type="number" id="discount_view" name="discount_view" value="{{ $item->discount_bill }}">
                                        <!-- ------------------------------------------------------------ -->
                                    </div>
                                    <!-- ----------------------------------------------------------- -->
                                    <input type="hidden" id="discount_total" name="discount_total" value="0">
                                    <!-- ------------------------------------------------------------ -->
                                </td>
                            </tr>

                        </tfoot>
                    </table>
                    <div class=" mg-t-10 mg-md-t-0 m-2 col-md-4">
                        <button class="btn btn-success btn-block" type="submit">تأكيد التعديل</button>
                    </div>

                    <div id="printForm" class="mg-t-10 mg-md-t-0 m-2 col-md-4">
                        <button class="btn btn-primary btn-block" type="button" onclick="print_invoice()">طباعة</button>
                    </div>
                </form>

            </div><!-- bd -->
        </div><!-- bd -->
        <!-- <form action="{{url('/')}}" onsubmit="return confirmSubmit()"> -->






        <script>
            function calculateItemTotal(itemId) {
                var quantityInput = document.getElementById('quantity_' + itemId);
                var purchasePriceElement = document.getElementById('purchasePrice_' + itemId);
                var itemTotalElement = document.getElementById('itemTotal_' + itemId);
                var discountInput = document.getElementById('discount_' + itemId);


                var quantity = parseFloat(quantityInput.value) || 0;
                var purchasePrice = parseFloat(purchasePriceElement.textContent) || 0;
                var discountValue = parseFloat(discountInput.value) || 0;
                var itemTotal = quantity * purchasePrice;
                var discountAmount = (itemTotal * discountValue) / 100;
                var itemTotalElementValue = itemTotal - discountAmount;
                itemTotalElement.textContent = itemTotalElementValue.toFixed(2);
            }

            var quantityInputs = document.querySelectorAll('[id^="quantity_"]');
            var discountInput = document.querySelectorAll('[id^="discount_"]');

            quantityInputs.forEach(function(input) {
                var itemId = input.id.split('_')[1];

                input.addEventListener('input', function() {
                    calculateItemTotal(itemId);
                });
            });
            discountInput.forEach(function(input) {
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
                var discount_view = document.getElementById('discount_view');
                var discount_total = document.getElementById('discount_total');
                var total = 0;

                var discountValue = parseFloat(discount_view.value) || 0;
                var discountAmountTotal = 0;

                itemTotalCells.forEach(function(itemTotalCell) {
                    var value = parseFloat(itemTotalCell.textContent) || 0;
                    total += value;
                });
                discountAmountTotal = (total * discountValue) / 100;
                var realprice = total - discountAmountTotal;
                totalViewInput.textContent = realprice.toFixed(2); // Set the total to the input field
                totalInput.value = realprice.toFixed(2); // Set the total to the input field
            }

            // Call the calculateTotal function whenever an input field changes (item quantity changes)
            var quantityInputs = document.querySelectorAll('[id^="quantity_"]');
            var discountInputs = document.querySelectorAll('[id^="discount_"]');
            quantityInputs.forEach(function(input) {
                input.addEventListener('input', calculateTotal);
            });
            discountInputs.forEach(function(input) {
                // ------------------------------------------------------------
                input.addEventListener('input', calculateTotal);
            });

            // Initial calculation when the page loads
            window.addEventListener('load', calculateTotal);
        </script>
        <script>
            function print_invoice() {
                window.print();
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