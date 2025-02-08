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
            <h4 class="content-title mb-0 my-auto">المشتريات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فاتورة المشتريات </span>
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
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                <th class="wd-15p border-bottom-0">اسم العميل</th>
                                <th class="wd-15p border-bottom-0" style="display: none;">اسم العميل</th>
                                <th class="wd-15p border-bottom-0" style="display: none;">اسم العميل</th>
                                <th class="wd-15p border-bottom-0">اجمالي الفاتورة</th>
                                <th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
                                <th class="wd-15p border-bottom-0 text-center">عرض الفاتورة</th>
                                <th class="wd-15p border-bottom-0 text-center">حذف الفاتورة</th>
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
                                <td>{{$bill->BillID}}</td>
                                <td>{{$bill->ClientName}}</td>
                                <td style="display: none;">{{$bill->ClientNumber}}</td>
                                <td style="display: none;">{{$bill->ClientPhone}}</td>
                                <td>{{$bill->TotalAmount}} جنيه</td>
                                <td><?php echo $formattedDate; ?></td>
                                <td class="text-center">
                                    <form method="get" action="/view_purch_invoice/{{$bill->BillID}}">

                                        <button class="btn btn-md btn-info" type="submit"> فتح</button>

                                    </form>

                                </td>
                                <td class="text-center">
                                    <form method="POST" action="/delete_purchase_invoice/{{$bill->BillID}}" onsubmit="return confirmSubmit()">
                                        @csrf
                                        <button class="btn btn-md btn-danger" type="submit"> حذف</button>

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
<!-- Modal Edit -->
<div class="modal" id="exampleModal4">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل الصنف</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card-body pt-2">
                        <form method="POST" action="edit_new_data_item" id="edit-form" autocomplete="off" enctype="multipart/form-data">
                            @if (Session::has('failed'))
                            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                            @endif
                            @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif
                            @csrf
                            <input type="hidden" name="item_id" id="edit_id">
                            <div class=" form-group">
                                <label for="edit_item_name">اسم الصنف</label>
                                <input type="text" class="form-control" placeholder="ادخل اسم الصنف" name="item_name" id="edit_item_name">
                            </div>
                            @error('item_name')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror

                            <div class=" form-group">
                                <label for="edit_item_purch_price"> سعر الشراء</label>
                                <input type="number" class="form-control" placeholder="ادخل سعر الشراء" name="purchase_price" id="edit_item_purch_price">
                            </div>
                            @error('purchase_price')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror

                            <div class=" form-group">
                                <label for="edit_item_sale_price"> سعر البيع</label>

                                <input type="number" class="form-control" placeholder="ادخل سعر البيع" name="sales_price" id="edit_item_sale_price">
                            </div>
                            @error('sales_price')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-success" type="submit" href="/edit_new_data_item" onclick="event.preventDefault(); document.getElementById('edit-form').submit();">
                    حفظ التغييرات</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit-->


<!-- Modal Delete -->
<div class="modal" id="exampleModal5">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف الصنف</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card-body pt-2">
                        <form method="POST" action="delete_item" id="delete-form" autocomplete="off" enctype="multipart/form-data">
                            @if (Session::has('del_failed'))
                            <div class="alert alert-danger">{{ Session::get('del_failed') }}</div>
                            @endif
                            @if (Session::has('del_success'))
                            <div class="alert alert-success">{{ Session::get('del_success') }}</div>
                            @endif
                            @csrf
                            <input type="hidden" name="item_id" id="delete_id">
                            <div class=" form-group">
                                <label for="delete_item_name">اسم الصنف</label>
                                <input disabled type="text" class="form-control" placeholder="ادخل اسم الصنف" name="item_name" id="delete_item_name">
                            </div>
                            @error('item_name')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror

                            <div class=" form-group">
                                <label for="delete_item_purch_price"> سعر الشراء</label>
                                <input disabled type="number" class="form-control" placeholder="ادخل سعر الشراء" name="purchase_price" id="delete_item_purch_price">
                            </div>
                            @error('purchase_price')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror

                            <div class=" form-group">
                                <label for="delete_item_sale_price"> سعر البيع</label>

                                <input disabled type="number" class="form-control" placeholder="ادخل سعر البيع" name="sales_price" id="delete_item_sale_price">
                            </div>
                            @error('sales_price')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div> {{ $message }} </div>
                            </div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="submit" href="/delete_item" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                    حذف الصنف</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete-->
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