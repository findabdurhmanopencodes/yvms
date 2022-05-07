@extends('layouts.session_layout')
@section('action_title','Quota Allocation')
@section('title','Quota Allocation')
@section('breadcrumbTitle','Quota Allocation')
@section('breadcrumbList')
<li class="breadcrumb-item">
    <a  href="{{ route('training_session.index', []) }}">All Program</a>
</li>
<li class="active">Quota Allocation</li>
@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <!--end::Page Scripts-->~
@endpush

@section('action_content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Youth Volunteer 
                <span class="d-block text-muted pt-2 font-size-sm">Youth Volunteer Qouta</span></h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
@endsection

@push('js')
<script>

    var sub_column = [
				{
					field: 'id',
					title: 'ID',
					// template: function(row) {
					// 	return '<span>' + row.b + ' - ' + row.c + '</span>';
					// },
				}, 
				{
					field: 'region_name',
					title: 'Name',
					width: 100
				},
				{
					field: 'quantity',
					title: 'Quantity',
					width: 100
				}, 
            ];

     var main_column = [
				{
					field: 'id',
					title: '',
					sortable: false,
					width: 30,
					textAlign: 'center',
				}, 
				{
					field: 'key',
					title: '#',
				}, 
				{
					field: 'name',
					title: 'Region',
				},
                {
					field: 'region_quantity',
					title: 'Quantity',
				},
                
			];

            var aa = @json($regions);
            // console.log(DATAS);
            // var DATAS;
            var DATAS = [];
            var a = [];
            var SUB_DATAS = [];

            aa.forEach(element => {
                element.zones.forEach(ele => {
                    SUB_DATAS.push({"id":ele.id, "region_name":ele.name, "quantity":600});
                });

                DATAS.push({"id":1, "key": element.id, "name":element.name, "region_quantity":3000, "zone":SUB_DATAS});

                // SUB_DATAS = [];
            });

            
</script>
<script src="{{ asset('assets/js/pages/crud/ktdatatable/child/data-local.js') }}"></script>
@endpush