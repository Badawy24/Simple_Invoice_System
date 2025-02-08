<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">

	<div class="main-sidemenu">
		<div class="app-sidebar__user clearfix">
			<div class="dropdown user-pro-body">
				<div class="">
					<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/Arabian.png')}}"><span class="avatar-status profile-status bg-green"></span>
				</div>
				<div class="user-info">
					<h4 class="font-weight-semibold mt-3 mb-0">Badawy Invoice System</h4>
				</div>
			</div>
		</div>
		<ul class="side-menu">
			<!-- Stores  -->
			<li class="side-item side-item-category"> المخزن</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> عرض المخزن </span></a>
			</li>
			<hr>
			<!-- ******************** -->
			<!-- Items  -->
			<li class="side-item side-item-category">تسجيل اصناف</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/add_new_item') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;">تسجيل صنف جديد</span></a>
			</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/edit_item') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;">تعديل الاصناف</span></a>
			</li>
			<hr>
			<!-- ******************** -->
			<!-- Purchases  -->
			<li class="side-item side-item-category"> المشتريات</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/make_purchase_invoice') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> انشاء فاتورة مشتريات</span></a>
			</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_edit_purchase_invoice') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> تعديل فاتورة مشتريات</span></a>
			</li>
			<hr>
			<!-- ******************** -->
			<!-- Sales  -->
			<li class="side-item side-item-category"> المبيعات</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/make_sales_invoice') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> انشاء فاتورة مبيعات </span></a>
			</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_edit_sales_invoice') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;">تعديل فاتورة مبيعات</span></a>
			</li>
			<hr>
			<!-- ******************** -->
			<!-- Invoices  -->

			<li class="side-item side-item-category"> الفواتير</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_all_invoices') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> كل الفواتير </span></a>
			</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_purches_invoices') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> فواتير مشتريات </span></a>
			</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_sales_invoices') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> فواتير مبيعات</span></a>
			</li>
			<hr>
			<!-- ******************** -->
			<!-- Clients  -->
			<li class="side-item side-item-category"> العملاء</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ url('/view_clients_data') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label" style="font-size: 14px; color:#000;"> بيانات العملاء</span></a>
			</li>
			<hr>
			<!-- ******************** -->

		</ul>
	</div>
</aside>
<!-- main-sidebar -->