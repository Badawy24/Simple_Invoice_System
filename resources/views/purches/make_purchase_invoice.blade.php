@extends('layouts.master')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">المشتريات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ انشاء فاتورة مشتريات</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<section class="row">
	<article class="panel panel-primary tabs-style-3">
		<div class="tab-menu-heading">
			<div class="tabs-menu ">
				<!-- Tabs -->
				<ul class="nav panel-tabs">
					<li class=""><a href="#tab11" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> عميل سابق</a></li>
					<li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> عميل جديد</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body tabs-menu-body">

			@error('client_name')
			<div class="alert alert-danger d-flex align-items-center" role="alert">
				<i class="fa-solid fa-triangle-exclamation"></i>
				<div>حدث خطأ في الاسم. الرجاء التوجه لصفحة عميل جديد لمعرفة المشكلة</div>
			</div>
			@enderror

			@error('client_code')
			<div class="alert alert-danger d-flex align-items-center" role="alert">
				<i class="fa-solid fa-triangle-exclamation"></i>
				<div>حدث خطأ في كود العميل. الرجاء التوجه لصفحة عميل جديد لمعرفة المشكلة</div>
			</div>
			@enderror

			@error('phone')
			<div class="alert alert-danger d-flex align-items-center" role="alert">
				<i class="fa-solid fa-triangle-exclamation"></i>
				<div>حدث خطأ في رقم الهاتف. الرجاء التوجه لصفحة عميل جديد لمعرفة المشكلة</div>
			</div>
			@enderror

			@if (Session::has('failed_code'))
			<div class="alert alert-danger col-md-5">{{ Session::get('failed_code') }}</div>
			@endif

			@if (Session::has('delete_done'))
			<div class="alert alert-danger col-md-5">{{ Session::get('delete_done') }}</div>
			@endif
			@if (Session::has('client_data_error'))
			<div class="alert alert-danger col-md-5">{{ Session::get('client_data_error') }}</div>
			@endif

			<div class="tab-content" style="width:1150px">
				<section class="tab-pane active" id="tab11">
					<form method="POST" action="insert_new_purchase_invoice_exist_client">
						@csrf
						<article class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="main-content-label mg-b-5 mb-3">
										بيانات العميل
									</div>
									<div class="row row-sm mg-b-20">
										<div class="col-lg-4">
											<p class="mg-b-10">اختر اسم العميل</p>

											<select class="form-control select2 col-md-9" name="client_name_select">
												<option label="اختر اسم العميل" disabled selected>
												</option>
												@foreach($clients as $client)
												<option value="{{ $client->ClientID}}">
													{{$client->ClientName}}
												</option>
												@endforeach
											</select>
											<!--  -->

										</div><!-- col-4 -->
										<div class="col-lg-4 mg-t-20 mg-lg-t-0">
											<p class="mg-b-10">اختر كود العميل</p>
											<select class="form-control select2 col-md-9" name="client_code_select">
												<option label="اختر كود العميل" disabled selected>
												</option>
												@foreach($clients as $client)
												<option value="{{ $client->ClientID}}">
													{{$client->ClientNumber}}
												</option>
												@endforeach
											</select>
										</div><!-- col-4 -->
										<div class="col-lg-4 mg-t-20 mg-lg-t-0">
											<p class="mg-b-10">اختر رقم هاتف العميل</p>
											<select class="form-control select2 col-md-9" name="client_phone_select">
												<option label="اختر رقم هاتف العميل" disabled selected>
												</option>
												@foreach($clients as $client)
												<option value="{{ $client->ClientID}}">
													{{$client->ClientPhone}}
												</option>
												@endforeach
											</select>
										</div><!-- col-4 -->
									</div>
								</div>
							</div>
						</article>
						<article class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="main-content-label mg-b-5 mb-3">
										الصنف
									</div>
									<div class="row row-sm mg-b-20">
										<div class="col-md-8">
											<style>
												.select2-container {
													width: 250px !important;
												}
											</style>
											<p class="mg-b-10">اختر اسم الصنف</p>

											<input list="dataList" id="selectItem" class="form-control  col-md-6" placeholder="اختر اسم الصنف">
											<datalist id="dataList">
												@foreach ($items as $item)
												<option value="{{ $item->ItemName }}">{{ $item->ItemName }}</option>
												@endforeach
											</datalist>

											<!--  -->
										</div><!-- col-4 -->
									</div>
								</div>
							</div>
						</article>
						<article>

							<table id="myTable" class="table table-striped mg-b-0 text-md-nowrap">
								<thead>
									<tr>
										<th>م</th>
										<th>الصنف</th>
										<th>عدد الشراء</th>
										<th>السعر</th>
										<th>الاجمالي</th>
										<th>الكمية المتاحة</th>

									</tr>
								</thead>
								<tbody>
									@foreach ($items as $item)
									<tr style="display: none;" data-value="{{ $item->ItemName }}" id="{{ $item->ItemID }}" class="item-row">
										<td><button class="btn btn-link btn-sm" onclick="hideRow('{{ $item->ItemName }}','{{ $item->ItemID }}')" type="button">الغاء</button></td>
										<td>{{ $item->ItemName }}</td>
										<td>
											<label for="quantity_{{ $item->ItemID }}">
												<div class="col-md-8 mg-t-5 mg-md-t-0">
													<input class="form-control" type="number" id="quantity_{{ $item->ItemID }}" name="quantities[]" value="0" placeholder="ادخل الكمية" oninput="calculateItemTotal('{{ $item->ItemID }}')">

												</div>
												<input type="hidden" name="items[]" value="{{ $item->ItemID }}">
											</label>
										</td>
										<td id="purchasePrice_{{ $item->ItemID }}">{{ $item->PurchPrice }}</td>
										<td id="itemTotal_{{ $item->ItemID }}">0</td>
										<td>{{ $item->Quantity }}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-center">صافي الفاتورة</td>
										<td colspan="2">
											<div class="col-md-5 mg-t-5 mg-md-t-0">
												<input disabled class="form-control" type="text" id="total_view" name="total_view">
											</div>
											<input type="hidden" id="total" name="total">
										</td>
									</tr>

								</tfoot>
							</table>
							<div class="col-sm-6 col-md-3 mg-t-10 mg-md-t-0">
								<button class="btn btn-success btn-block" type="submit">انشاء</button>
							</div>
						</article>
					</form>
				</section>
				<section class="tab-pane" id="tab12">
					<form method="POST" action="insert_new_purchase_invoice">
						@csrf
						<article class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="main-content-label mg-b-5 mb-3">
										بيانات العميل
									</div>
									<div class="row row-sm mg-b-20">
										<div class="col-lg-4">
											<p class="mg-b-10">ادخل اسم العميل</p>
											<div class=" form-group">
												<input value="{{ old('client_name') }}" type="text" class="form-control" id="inputName" placeholder="ادخل اسم العميل" name="client_name">
											</div>
											@error('client_name')
											<div class="alert alert-danger d-flex align-items-center" role="alert">
												<i class="fa-solid fa-triangle-exclamation"></i>
												<div> {{ $message }} </div>
											</div>
											@enderror
											<!--  -->

										</div><!-- col-4 -->
										<div class="col-lg-4 mg-t-20 mg-lg-t-0">
											<p class="mg-b-10">ادخل كود العميل</p>
											<div class=" form-group">
												<input value="{{ old('client_code') }}" type="text" class="form-control" id="inputName" placeholder="ادخل كود العميل" name="client_code">
											</div>
											@error('client_code')
											<div class="alert alert-danger d-flex align-items-center" role="alert">
												<i class="fa-solid fa-triangle-exclamation"></i>
												<div> {{ $message }} </div>
											</div>
											@enderror
											<!--  -->
										</div><!-- col-4 -->
										<div class="col-lg-4 mg-t-20 mg-lg-t-0">
											<p class="mg-b-10">ادخل رقم هاتف العميل <span class="text-danger text-small"> مكون من 11 رقم </span></p>
											<div class=" form-group">
												<input value="{{ old('phone') }}" type="text" class="form-control" id="inputName" placeholder="ادخل رقم هاتف العميل" name="phone">
											</div>
											@error('phone')
											<div class="alert alert-danger d-flex align-items-center" role="alert">
												<i class="fa-solid fa-triangle-exclamation"></i>
												<div> {{ $message }} </div>
											</div>
											@enderror
											<!--  -->
										</div><!-- col-4 -->
									</div>
								</div>
							</div>
						</article>
						<article class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="main-content-label mg-b-5 mb-3">
										الصنف
									</div>
									<div class="row row-sm mg-b-20">
										<div class="col-md-8">
											<style>
												.select2-container {
													width: 250px !important;
												}
											</style>
											<p class="mg-b-10">اختر اسم الصنف</p>

											<input list="dataList" id="selectItem_new_client" class="form-control col-md-6" placeholder="اختر اسم الصنف">
											<datalist id="dataList_new_client">
												@foreach ($items as $item)
												<option value="{{ $item->ItemName }}">{{ $item->ItemName }}</option>
												@endforeach
											</datalist>

											<!--  -->
										</div><!-- col-4 -->
									</div>
								</div>
							</div>
						</article>
						<article>
							<table id="myTable_new_client" class="table table-striped mg-b-0 text-md-nowrap">
								<thead>
									<tr>
										<th>م</th>
										<th>الصنف</th>
										<th>عدد الشراء</th>
										<th>السعر</th>
										<th>الاجمالي</th>
										<th>الكمية المتاحة</th>

									</tr>
								</thead>
								<tbody>
									@foreach ($items as $item)
									<tr style="display: none;" data-value="{{ $item->ItemName }}" id="{{ $item->ItemID }}_new_client" class="item-row">
										<td><button class="btn btn-link btn-sm" onclick="hideRow_new_client('{{ $item->ItemName }}','{{ $item->ItemID }}')" type="button">الغاء</button></td>
										<td>{{ $item->ItemName }}</td>
										<td>
											<label for="quantity_new_client{{ $item->ItemID }}">
												<div class="col-md-8 mg-t-5 mg-md-t-0">
													<input class="form-control" type="number" id="quantity_new_client{{ $item->ItemID }}" name="quantities[]" value="0" placeholder="ادخل الكمية" oninput="calculateItemTotal_new_client('{{ $item->ItemID }}')">

												</div>
												<input type="hidden" name="items[]" value="{{ $item->ItemID }}">
											</label>
										</td>
										<td id="purchasePrice_new_client{{ $item->ItemID }}">{{ $item->PurchPrice }}</td>
										<td id="itemTotal_new_client{{ $item->ItemID }}">0</td>
										<td>{{ $item->Quantity }}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-center">صافي الفاتورة</td>
										<td colspan="2">
											<div class="col-md-5 mg-t-5 mg-md-t-0">
												<input disabled class="form-control" type="text" id="total_view_new_client" name="total_view">
											</div>
											<input type="hidden" id="total_new_client" name="total">
										</td>
									</tr>

								</tfoot>
							</table>
							<div class="col-sm-6 col-md-3 mg-t-10 mg-md-t-0">
								<button class="btn btn-success btn-block" type="submit">انشاء</button>
							</div>
						</article>
					</form>
				</section>
			</div>
		</div>
	</article>

</section>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')


<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script>
	var selectedItems = new Map();

	document.getElementById("selectItem").addEventListener("input", function() {

		var selectedValue = this.value;

		var tableRows = document.getElementById("myTable").getElementsByTagName("tr");
		for (var i = 0; i < tableRows.length; i++) {
			var dataValue = tableRows[i].getAttribute("data-value");
			if (dataValue === selectedValue) {
				tableRows[i].style.display = "table-row";
			}
		}
	});

	function hideRow(value, itemId) {
		var tableRows = document.getElementById("myTable").getElementsByTagName("tr");
		for (var i = 0; i < tableRows.length; i++) {
			var dataValue = tableRows[i].getAttribute("data-value");
			if (dataValue === value) {
				tableRows[i].style.display = "none";
			}

			var quantityInput = document.getElementById('quantity_' + itemId);
			var quantity = parseInt(quantityInput.value) || 0;

			selectedItems.set(itemId, quantity);

			quantityInput.value = 0;

			var itemTotalCell = document.getElementById('itemTotal_' + itemId);
			if (itemTotalCell) {
				itemTotalCell.textContent = 0;
			}

			calculateTotal();
		}

	}

	function calculateItemTotal(itemId) {
		var quantityInput = document.getElementById('quantity_' + itemId);
		var itemTotalCell = document.getElementById('itemTotal_' + itemId);
		var purchasePriceCell = document.getElementById('purchasePrice_' + itemId);

		if (quantityInput && itemTotalCell && purchasePriceCell) {
			var quantity = parseInt(quantityInput.value) || 0;
			var purchasePrice = parseFloat(purchasePriceCell.textContent) || 0;
			var total = quantity * purchasePrice;
			itemTotalCell.textContent = total;
		}
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

		totalViewInput.value = total.toFixed(2);
		totalInput.value = total.toFixed(2);
	}

	var quantityInputs = document.querySelectorAll('[id^="quantity_"]');
	quantityInputs.forEach(function(input) {
		input.addEventListener('input', calculateTotal);
	});


	window.addEventListener('load', calculateTotal);
</script>

<!-- for new clients -->
<script>
	var selectedItems_new_client = new Map();

	document.getElementById("selectItem_new_client").addEventListener("input", function() {

		var selectedValue_new_client = this.value;

		var tableRows_new_client = document.getElementById("myTable_new_client").getElementsByTagName("tr");
		for (var i = 0; i < tableRows_new_client.length; i++) {
			var dataValue_new_client = tableRows_new_client[i].getAttribute("data-value");
			if (dataValue_new_client === selectedValue_new_client) {
				tableRows_new_client[i].style.display = "table-row";
			}
		}
	});

	function hideRow_new_client(value, itemId) {
		var tableRows_new_client = document.getElementById("myTable_new_client").getElementsByTagName("tr");
		for (var i = 0; i < tableRows_new_client.length; i++) {
			var dataValue_new_client = tableRows_new_client[i].getAttribute("data-value");
			if (dataValue_new_client === value) {
				tableRows_new_client[i].style.display = "none";
			}

			var quantityInput = document.getElementById('quantity_new_client' + itemId);
			var quantity = parseInt(quantityInput.value) || 0;

			selectedItems_new_client.set(itemId, quantity);

			quantityInput.value = 0;

			var itemTotalCell = document.getElementById('itemTotal_new_client' + itemId);
			if (itemTotalCell) {
				itemTotalCell.textContent = 0;
			}

			calculateTotal_new_client();
		}

	}

	function calculateItemTotal_new_client(itemId) {
		var quantityInput = document.getElementById('quantity_new_client' + itemId);
		var itemTotalCell = document.getElementById('itemTotal_new_client' + itemId);
		var purchasePriceCell = document.getElementById('purchasePrice_new_client' + itemId);

		if (quantityInput && itemTotalCell && purchasePriceCell) {
			var quantity = parseInt(quantityInput.value) || 0;
			var purchasePrice = parseFloat(purchasePriceCell.textContent) || 0;
			var total = quantity * purchasePrice;
			itemTotalCell.textContent = total;
		}
	}

	function calculateTotal_new_client() {
		var itemTotalCells = document.querySelectorAll('[id^="itemTotal_new_client"]');
		var totalViewInput = document.getElementById('total_view_new_client');
		var totalInput = document.getElementById('total_new_client');
		var total = 0;

		itemTotalCells.forEach(function(itemTotalCell) {
			var value = parseFloat(itemTotalCell.textContent) || 0;
			total += value;
		});

		totalViewInput.value = total.toFixed(2);
		totalInput.value = total.toFixed(2);
	}

	var quantityInputs_new_client = document.querySelectorAll('[id^="quantity_new_client"]');
	quantityInputs_new_client.forEach(function(input) {
		input.addEventListener('input', calculateTotal_new_client);
	});


	window.addEventListener('load', calculateTotal_new_client);
</script>





@endsection