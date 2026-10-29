@extends('layout.home')

@section('content')
    <div class="container-fluid">
        @if(null!==session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif
        
        <div class="row">
            <div class="col-6 mb-3">
                <form id="form_membership" action="{{route('business.membership')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Seleccione una membresía: </label>

                        <select id="membership" name="membership" class="form-control">
                            <option value="-1">Todas las membresías</option>
                            <option value="90">Gratis</option>
                            <option value="10">Básica</option>
                            <option value="11">Premium</option>
                            <option value="16">Gold</option>
                            <option value="12">Corporativa 1</option>
                            <option value="13">Corporativa 2</option>
                            <option value="14">Corporativa 3</option>
                            <option value="15">Corporativa 4</option>
                            <option value="17">Corporativa Premium</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table id="tabla-ajax">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Rut</th>
                        <th>Rut Negocio</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Empresa</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>

    <script>
        jQuery(document).ready(function($) {
           $('#form_membership').on('change', function() {
               table.ajax.reload();
           }) 
        })
        var table = $('#tabla-ajax').DataTable({
            ordering: true,
            bProcessing: true,
            bServerSide: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('members.roles') }}",
                data: function(d) {
                    d.role = $('#membership').val();
                },
            }, 
            columns: [
                {data: 'id', name: 'id', title: 'id'},
                {data: 'rut_user', name: 'rut_user', title: 'Rut'},
                {data: 'rut_business', name: 'rut_business', title: 'Rut Negocio'},
                {data: 'firstname', name: 'firstname', title: 'Nombre'},
                {data: 'surname', name: 'surname', title: 'Apellido'},
                {data: 'business_name', name: 'business_name', title: 'Empresa'},
                {data: 'email_user', name: 'email_user', title: 'Email'},
                {data: 'updated_at', name: 'updated_at', title: 'Fecha'},
                {data: 'action', name:'action', title: 'Acción'}
            ],
            initComplete: function (settings, json) {
            }
        });
    </script>
@endsection
