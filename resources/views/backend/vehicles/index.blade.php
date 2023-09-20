@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('vehicles.module_title') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('vehicles.module_title') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('vehicles.module_title') }}</h3>
                            <div class="card-tools">
                                <a class="btn btn-success fw-bold" href="{{ route('vehicles.add') }}"><i class="fa-duotone fa-grid-2-plus"></i> {{ __('vehicles.add_vehicle') }}</a>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered vehicle_datatable">
                                <thead>
                                <tr>
                                    <th width="20">
                                        <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input bulk-check-main" id="bulk_main">
                                          <label class="custom-control-label" for="bulk_main"></label>
                                        </div>
                                    </th>
                                    <th>{{ __('vehicles.plate_no') }}</th>
									<th>{{ __('vehicles.brand_name') }}</th>
									<th>{{ __('vehicles.model_name') }}</th>
									<th>{{ __('vehicles.maintenance_date') }}</th>
									<th>{{ __('vehicles.insurance_date') }}</th>
									<th>{{ __('vehicles.vehicle_type') }}</th>
                                    <th width="150px">Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button class="btn btn-danger btn-sm bulk-delete-button d-none" type="button" data-post="{{ route('vehicles.bulk_delete')  }}" token="{{ csrf_token() }}"><i class="icon-trash"></i>Bulk Delete</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('links')
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush
@push('scripts')
    <script src="{{ asset('/') }}back/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('/') }}back/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var table = $('.vehicle_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vehicles.index') }}",
                columns: [
                    {data: 'select_item', name: 'select_item', orderable: false, searchable: false},
                    {data: 'plate_no', name: 'plate_no'}, 
					{data: 'brand_name', name: 'brand_name'}, 
					{data: 'model_name', name: 'model_name'}, 
					{data: 'maintenance_date', name: 'maintenance_date'}, 
					{data: 'insurance_date', name: 'insurance_date'}, 
					{data: 'vehicle_type', name: 'vehicle_type'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
        @if (session()->has('flash_notification.message'))
        $(document).ready(function(){
            $(document).Toasts('create', {
                class: 'bg-{{ session()->get('flash_notification.level') }} w-250',
                title: 'Information about the last process',
                autohide: true,
                delay: 4000,
                body: '{!! session()->get('flash_notification.message') !!}'
              })
        });
        @endif
    </script>
@endpush
