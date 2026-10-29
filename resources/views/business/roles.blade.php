@extends('layout.home')
@push('datatables')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@endpush
@section('robots', 'noindex, nofollow')

@push('styles')
    <style>
        .roles-page { max-width: 1320px; margin: 2rem auto; padding: 0 1rem; }
        .roles-page .card-header { background: #fff; }
        .roles-scroll { overflow-x: auto; }
        .roles-table { width: 100% !important;  }
        .roles-table th, .roles-table td { white-space: nowrap; }
        .roles-table thead th { white-space: nowrap; font-size: .85rem; text-transform: uppercase; letter-spacing: .03em; color: #6c757d; }
        .roles-table th, .roles-table td { padding: .85rem 1rem; }
        .roles-table td { vertical-align: middle; font-size: .9rem; }
        .roles-table td form { display: flex; align-items: center; margin: 0; gap: .35rem; }
        .roles-table td form .form-control { min-width: 170px; width: auto; }
        .roles-table td form .btn { margin: 0 !important; }
        .roles-table td .p-3 { padding: .4rem .75rem !important; font-size: .8rem; white-space: nowrap; }
        .roles-page .dataTables_wrapper .dataTables_length select { width: auto; display: inline-block; }
        .roles-page .dataTables_wrapper .dataTables_filter input { width: auto; display: inline-block; margin-left: .5rem; }
        .roles-table th:nth-child(-n+3), .roles-table td:nth-child(-n+3) { position: sticky; background: #fff; z-index: 1; }
        .roles-table th:nth-child(1), .roles-table td:nth-child(1) { left: 0; min-width: 70px; width: 70px; }
        .roles-table th:nth-child(2), .roles-table td:nth-child(2) { left: 70px; min-width: 130px; width: 130px; }
        .roles-table th:nth-child(3), .roles-table td:nth-child(3) { left: 200px; min-width: 130px; width: 130px; box-shadow: 2px 0 4px -2px rgba(0,0,0,.2); }
        .roles-table th:nth-child(6), .roles-table td:nth-child(6) { width: 180px; min-width: 180px; max-width: 180px; white-space: normal; }
        .roles-table.table-hover tbody tr:hover td:nth-child(-n+3) { background: #f2f2f2; }
        .roles-page .dataTables_wrapper .dataTables_info { padding-top: 1rem; color: #6c757d; font-size: .85rem; }
        .roles-page .dataTables_wrapper .dataTables_paginate { padding-top: .75rem; display: flex; justify-content: flex-end; flex-wrap: wrap; gap: .25rem; }
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button { display: inline-block; min-width: 2.25rem; padding: .35rem .7rem; margin: 0; border: 1px solid #dee2e6; border-radius: .25rem; background: #fff; color: #007bff !important; text-align: center; cursor: pointer; box-shadow: none; }
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #e9ecef !important; border-color: #dee2e6; color: #0056b3 !important; }
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #007bff !important; border-color: #007bff; color: #fff !important; }
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .roles-page .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover { background: #fff !important; color: #adb5bd !important; cursor: default; }
        .roles-page .dataTables_wrapper .dataTables_paginate .ellipsis { padding: .35rem .4rem; color: #6c757d; }
    </style>
@endpush

@section('content')
    <div class="roles-page">
        @if(session()->has('message'))
            <div class="alert alert-{{ session('message')[0] }}" role="alert">
                {{ session('message')[1] }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <div class="form-row align-items-end">
                    <div class="col-12 col-md-6">
                        <h3 class="mb-0">Membresías de empresas</h3>
                        <small class="text-muted">Revisa el plan de cada empresa y cámbialo cuando corresponda.</small>
                    </div>
                    <div class="col-12 col-md-6 mt-3 mt-md-0">
                        <label for="membership" class="small text-muted mb-1">Filtrar por membresía</label>
                        <select id="membership" class="form-control">
                            <option value="-1">Todas las membresías</option>
                            @foreach(\App\Enums\Membership::assignable() as $plan)
                                <option value="{{ $plan->value }}">{{ $plan->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div>
                    <table id="tabla-ajax" class="table table-hover roles-table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Rut</th>
                            <th>Rut negocio</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Empresa</th>
                            <th>Email</th>
                            <th>Vencimiento</th>
                            <th>Plan</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(function ($) {
            var table = $('#tabla-ajax').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                pageLength: 25,
                autoWidth: false,
                dom: 'lf<"roles-scroll"rt>ip',
                pagingType: 'simple_numbers',
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                ajax: {
                    url: "{{ route('members.roles') }}",
                    data: function (d) {
                        d.role = $('#membership').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'rut_user', name: 'rut_user'},
                    {data: 'rut_business', name: 'rut_business'},
                    {data: 'firstname', name: 'firstname'},
                    {data: 'surname', name: 'surname'},
                    {data: 'business_name', name: 'business_name'},
                    {data: 'email_user', name: 'email_user'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#membership').on('change', function () {
                table.ajax.reload();
            });
        });
    </script>
@endsection
