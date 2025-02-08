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
			<h4 class="content-title mb-0 my-auto">تسجيل أصناف </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تسجيل اصناف جديدة</span>
		</div>
	</div>

</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->

<div class="row row-sm">
	<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
		<div class="card  box-shadow-0">
			<div class="card-header">
				<h4 class="card-title mb-1">اضافة الصنف</h4>
			</div>
			<div class="card-body pt-0">
				<form class="form-horizontal" action="insert_new_item" method="post">
					@if (Session::has('failed'))
					<div class="alert alert-danger">{{ Session::get('failed') }}</div>
					@endif
					@if (Session::has('success'))
					<div class="alert alert-success">{{ Session::get('success') }}</div>
					@endif
					@csrf
					<div class=" form-group">
						<input type="text" class="form-control" id="inputName" placeholder="ادخل اسم الصنف" name="item_name">
					</div>
					@error('item_name')
					<div class="alert alert-danger d-flex align-items-center" role="alert">
						<i class="fa-solid fa-triangle-exclamation"></i>
						<div> {{ $message }} </div>
					</div>
					@enderror

					<div class=" form-group">
						<input type="number" class="form-control" id="purchase_price" placeholder="ادخل سعر الشراء" name="purchase_price">
					</div>
					@error('purchase_price')
					<div class="alert alert-danger d-flex align-items-center" role="alert">
						<i class="fa-solid fa-triangle-exclamation"></i>
						<div> {{ $message }} </div>
					</div>
					@enderror

					<div class=" form-group">
						<input type="number" class="form-control" id="sales_price" placeholder="ادخل سعر البيع" name="sales_price">
					</div>
					@error('sales_price')
					<div class="alert alert-danger d-flex align-items-center" role="alert">
						<i class="fa-solid fa-triangle-exclamation"></i>
						<div> {{ $message }} </div>
					</div>
					@enderror

					<div>
						<button type="submit" class="btn btn-success">حفظ</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-0">الاصناف الحالية</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table text-md-nowrap" id="example1">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">م</th>
								<th class="wd-15p border-bottom-0">اسم الصنف</th>
								<th class="wd-15p border-bottom-0">سعر الشراء</th>
								<th class="wd-20p border-bottom-0">سعر البيع</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							@foreach( $exist_items as $item)
							<tr>
								<td>{{$i}}</td>
								<td>{{$item->ItemName}}</td>
								<td>{{$item->PurchPrice}} جنيه</td>
								<td>{{$item->SalePrice}} جنيه</td>
							</tr>
							<?php $i++; ?>
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
@endsection