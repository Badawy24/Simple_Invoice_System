@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/فواتير </span>
        </div>
    </div>

</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->

<div class="row row-sm">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">الفواتير الحالية</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    @if (Session::has('delete_done'))
                    <div class="alert alert-danger col-lg-4">{{ Session::get('delete_done') }}</div>
                    @endif
                    @if (Session::has('failed'))
                    <div class="alert alert-danger col-lg-4">{{ Session::get('failed') }}</div>
                    @endif
                    @if (Session::has('success'))
                    <div class="alert alert-success col-lg-4">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('del_failed'))
                    <div class="alert alert-danger col-lg-4">{{ Session::get('del_failed') }}</div>
                    @endif
                    @if (Session::has('del_success'))
                    <div class="alert alert-success col-lg-4">{{ Session::get('del_success') }}</div>
                    @endif
                    <table class="table text-md-nowrap" id="example">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                <th class="wd-15p border-bottom-0">اسم العميل</th>
                                <th class="wd-15p border-bottom-0">كود العميل</th>
                                <th class="wd-15p border-bottom-0">رقم تيلفون العميل</th>
                                <th class="wd-15p border-bottom-0">اجمالي الفاتورة</th>
                                <th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
                                <th class="wd-15p border-bottom-0">نوع الفاتورة</th>
                                <th class="wd-15p border-bottom-0 text-center">عرض الفاتورة</th>
                            </tr>
                        </thead>
                        <?php

                        use Carbon\Carbon;
                        ?>

                        <tbody>
                            @foreach( $bills as $bill)
                            <?php
                            $billDate = $bill->BillDate;
                            $carbonDate = Carbon::parse($billDate);
                            $formattedDate = $carbonDate->locale('ar')->isoFormat('dddd DD-MM-YYYY HH:mm');

                            ?>
                            <tr>
                                <td>فاتورة رقم {{$bill->BillID}}</td>
                                <td>{{$bill->ClientName}}</td>
                                <td>{{$bill->ClientNumber}}</td>
                                <td>{{$bill->ClientPhone}}</td>
                                <td>{{$bill->TotalAmount}} جنيه</td>
                                <td><?php echo $formattedDate; ?></td>
                                <td><?php if ($bill->type == "purch") {
                                        echo "مشتريات";
                                    } else {
                                        echo "مبيعات";
                                    } ?> </td>
                                <td class="text-center">
                                    <form method="get" action="/<?php if ($bill->type == "purch") {
                                                                    echo "view_purch_invoice";
                                                                } else {
                                                                    echo "view_sales_invoice";
                                                                } ?>/{{$bill->BillID}}">

                                        <button class="btn btn-md btn-info" type="submit"> فتح</button>

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script>
    function confirmSubmit() {
        // Display a confirmation dialog
        var confirmation = confirm("هل انت متأكد ؟");

        // If the user clicks "OK" in the confirmation dialog, allow the form to be submitted
        return confirmation;
    }
</script>
@endsection