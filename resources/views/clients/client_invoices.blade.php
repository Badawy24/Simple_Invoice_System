@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">عميل رقم {{$client->ClientNumber}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{$client->ClientName}}</span>
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
            @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <h4 class="card-title mb-1 d-inline-block">
                اسم العميل : <span class="text-danger">{{$client->ClientName}}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                كود العميل : <span class="text-danger">{{$client->ClientNumber}}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                رقم الهاتف : <span class="text-danger">{{$client->ClientPhone}}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                عدد الفواتير : <span class="text-danger">{{$bills_num}}</span>
            </h4>
            <form id="printForm" class="d-inline-block">
                <div class="mg-t-10 mg-md-t-0 m-2">
                    <button class="btn btn-primary btn-block" type="button" onclick="print_invoice()">طباعة</button>
                </div>
            </form>
        </div>
        <div id="printable-content" class="card-body">
            <div class="table-responsive">
                <?php

                use Carbon\Carbon;
                ?>
                @foreach($invoicesWithItems as $invoice)
                <div class="card-header">
                    <h4 class="card-title mb-1">
                        <?php

                        $billDate = $invoice['BillDate'];
                        $carbonDate = Carbon::parse($billDate);
                        $formattedDate = $carbonDate->locale('ar')->isoFormat('dddd DD-MM-YYYY HH:mm');
                        ?>
                        <h4 class="mb-2">
                            فاتورة رقم: <span class="text-danger">{{$invoice['BillID']}}</span></h4>
                        تاريخ الفاتورة : <span class="text-danger"><?php echo $formattedDate; ?></span>

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        خصم الفاتورة : <span class="text-danger">{{$invoice['discount_bill']}} %</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        صافي الفاتورة : <span class="text-danger">{{$invoice['TotalAmount']}} جنيه</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        نوع الفاتورة : <span class="text-danger">{{ $invoice['type'] === 'purch' ? 'مشتريات' : ($invoice['type'] === 'sales' ? 'مبيعات' : 'نوع غير معروف')}}</span>

                    </h4>

                    <table class="table table-striped mg-b-0 text-md-nowrap mt-5">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الصنف</th>
                                <th>العدد </th>
                                <th>السعر</th>
                                <th> خصم</th>
                                <th>الاجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($invoice['items'] as $item)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item['ItemName'] }}</td>
                                <td>{{ $item['Quantity'] }}</td>
                                <td>{{ $item['UnitPrice'] }} جنيه</td>
                                <td>{{ $item['discount'] }} %</td>
                                <td>{{ $item['finalPrice'] }} جنيه</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <hr class="bg-primary">
                @endforeach


            </div><!-- bd -->
        </div><!-- bd -->
        <!-- <form action="{{url('/')}}" onsubmit="return confirmSubmit()"> -->



        <script>
            function confirmSubmit() {
                // Display a confirmation dialog
                var confirmation = confirm("هل انت متأكد ؟");

                // If the user clicks "OK" in the confirmation dialog, allow the form to be submitted
                return confirmation;
            }
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