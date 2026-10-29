@extends('layout.home')
@push('datatables')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@endpush
@section('robots', 'noindex, nofollow')

@section('content')
    <div class="container-fluid">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @php
        //dd($candidates);
        @endphp
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>Candidatos para oferta {{ $offer->title }}</h3>
                                <small>Id: {{ $offer->id }}</small>
                                <input type="hidden" id="offerId" name="ofeerId" value="{{ $offer->id }}" />
                            </div>
                            <div class="col-sm-6 text-right">
                                <div class="btn btn-empleos">
                                    <h3 data-toggle="collapse" href="#filterContainer" aria-expanded="false" aria-controls="filterContainer" style="cursor:pointer;">Filtros</h3>
                                    <div class="filtros-postulantes collapse" id="filterContainer">
                                        <div class="container-logo" style="padding: 20px 0; margin-bottom: 30px;">
                                            <img src="/images/1x/logo-empleos-aqua.png" style="width: 250px; height: auto; display: block; margin: 0 auto;" alt="Empleos Aqua logo" />
                                        </div>
                                        <ul class="lista-filtros">
                                            <li>
                                                <fieldset>
                                                    <legend data-toggle="collapse" href="#filterEducacion" aria-expanded="false" aria-controls="filterEducacion" style="cursor:pointer;">Antecedentes Académicos</legend>
                                                    <div class="collapse" id="filterEducacion">
                                                        <label><input type="checkbox" name="studies" class="filter" value="1"> Educación Media Completa</label><br>
                                                        <label><input type="checkbox" name="studies" class="filter" value="2"> Educación Superior Completa</label><br>
                                                        <label><input type="checkbox" name="studies" class="filter" value="2"> Técnico</label><br>
                                                        <label><input type="checkbox" name="studies" class="filter" value="3"> Universitario</label><br>
                                                        <label><input type="checkbox" name="studies" class="filter" value="5"> Postgrado</label><br>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <legend data-toggle="collapse" href="#filterRegion" aria-expanded="false" aria-controls="filterRegion" style="cursor:pointer;">Región de residencia</legend>
                                                    <div class="collapse" id="filterRegion">
                                                        <label><input type="checkbox" name="region" class="filter" value="15"> Región Arica y Parinacota</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="1"> Región Tarapacá</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="2"> Región Antofagasta</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="3"> Región Atacama</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="4"> Región Coquimbo</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="5"> Región Valparaíso</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="13"> Región Metropolitana</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="6"> Región de O'Higgins</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="7"> Región Curicó</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="8"> Región Biobío</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="9"> Región Araucanía</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="10"> Región Los Lagos</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="16"> Región Los Ríos</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="11"> Región Carlos Ibañez del Campo</label><br>
                                                        <label><input type="checkbox" name="region" class="filter" value="12"> Región Magallanes</label><br>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <legend data-toggle="collapse" href="#filterEdad" aria-expanded="false" aria-controls="filterEdad" style="cursor:pointer;">Rango de edad</legend>
                                                    <div class="collapse" id="filterEdad">
                                                        <label><input type="checkbox" name="ageRange" class="filter" value="20-30"> Entre 20 y 30 años</label><br>
                                                        <label><input type="checkbox" name="ageRange" class="filter" value="30-40"> Entre 30 y 40 años</label><br>
                                                        <label><input type="checkbox" name="ageRange" class="filter" value="40-50"> Entre 40 y 50 años</label><br>
                                                        <label><input type="checkbox" name="ageRange" class="filter" value="50-60"> Entre 50 y 60 años</label><br>
                                                        <label for="customAgeMin">Rango de edades personalizado:</label><br>
                                                        <input type="number" id="customAgeMin" class="filter" name=" customAgeMin" placeholder="Edad menor" min="0" max="100">
                                                        <input type="number" id="customAgeMax" class="filter" name=" customAgeMax" placeholder="Edad mayor" min="0" max="100">
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <legend data-toggle="collapse" href="#filterGenero" aria-expanded="false" aria-controls="filterGenero" style="cursor:pointer;">Género</legend>
                                                    <div class="collapse" id="filterGenero">
                                                        <label><input type="checkbox" class="filter" name="gender" value="1"> Masculino</label><br>
                                                        <label><input type="checkbox" class="filter" name="gender" value="2"> Femenino</label><br>
                                                        <label for="customGender">Personalizar:</label>
                                                        <input type="text" id="customGender" class="filter" name="filter customGender" placeholder="Ingresa tu género">
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <legend data-toggle="collapse" href="#filterUpdate" aria-expanded="false" aria-controls="filterUpdate" style="cursor:pointer;">Fecha Actualización CV</legend>
                                                    <div class="collapse" id="filterUpdate">
                                                        <label for="cvUpdateMinDate">Fecha Actualización CV Desde:</label>
                                                        <input type="date" id="cvUpdateMinDate" class="filter form-control" name="cvUpdateMinDate">
                                                        <label for="cvUpdateMaxDate">Hasta:</label>
                                                        <input type="date" id="cvUpdateMaxDate" class="filter form-control" name="cvUpdateMaxDate">
                                                    </div>
                                                </fieldset>
                                            </li>
                                        </ul>                  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="usersTable" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><p class="m-0 text-center">Nombre Postulante</p></th>
                                            <th><p class="m-0 text-center">Edad</p></th>
                                            <th><p class="m-0 text-center">Género</p></th>
                                            <th><p class="m-0 text-center">Estado Civil</p></th>
                                            <th><p class="m-0 text-center" data-orderable="false">Nivel educacional</p></th>
                                            <th><p class="m-0 text-center">Nacionalidad</p></th>
                                            <th><p class="m-0 text-center">Email</p></th>
                                            <th><p class="m-0 text-center">Región</p></th>
                                            <th><p class="m-0 text-center" data-orderable="false">Teléfono</p></th>
                                            <th><p class="m-0 text-right" data-orderable="false">CV</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.modals.message')
    </div>
@endsection

@push("styles")
    <style media="all">
        .btn.btn-empleos {
        	position: relative;
        }
        .btn.btn-empleos h3 {
        	font-size: 20px;
        	background-color: #f19001;
        	padding: 10px 0;
        	color: #fff;
        	border-radius: 30px;
        	width: 180px;
        }
        .lista-filtros {
        	padding: 0;
        	margin: 0;
        	text-align: left;
        }
        .lista-filtros li {
        	list-style: none;
        }
        .lista-filtros legend {
        	font-size: 16px;
        	padding: 3px 20px;
        }
        .lista-filtros fieldset div.collapse, .lista-filtros fieldset div.collapsing {
            padding: 5px 20px !important;
        }
        .lista-filtros li:nth-child(2n) legend {
            background-color: #ccc;
        }
        .filtros-postulantes {
        	width: 300px;
        	padding: 10px 0;
        	font-size: 13px;
        	border: 2px solid #ccc;
        	position: absolute;
        	background-color: #fff;
        	top: 60px;
        	left: -30%;
        	z-index: 150;
        }        
        textarea#messages_log {
            overflow-y: scroll;
            height: 350px;
            resize: none;
        }
        .table {
            font-size: 0.75rem;
        }
        table.dataTable thead th {
        	background-repeat: no-repeat;
        	background-position: right 20px;
        	padding-right: 17px !important;
        }

        .table th, .table td {
        	padding: 0.25rem !important;
        }
        table.dataTable thead .sorting {
          background-image: url('{{url("images/sort_both.png")}}');
        }
        table.dataTable thead .sorting_asc {
          background-image: url('{{url("images/sort_asc.png")}}');
        }
        table.dataTable thead .sorting_desc {
          background-image: url('{{url("images/sort_desc.png")}}');
        }
        table.dataTable thead .sorting_asc_disabled {
          background-image: url('{{url("images/sort_asc_disabled.png")}}');
        }
        table.dataTable thead .sorting_desc_disabled {
          background-image: url('{{url("images/sort_desc_disabled.png")}}');
        }
        
        .paginate_button {
        	padding: 7px;
        	color: #3c3c3c;
        	cursor: pointer;
        }
        
        .paginate_button.disabled {
            cursor: none;
        }
        
        .dataTables_filter {
        	margin: 10px 0;
        }

        .dataTables_info,
        .paging_simple_numbers {
            margin-top: 20px;
        }
        #usersTable tr {
        	border-bottom: 2px solid #ccc;
        }
        #usersTable tr td {
        	padding: 8px 0;
        }
    </style>
@endpush

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function() {
        let tabla = $('#usersTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [], // Dejar vacío para no aplicar ordenación inicial en DataTables
            "ajax": {
                url: "{{ route('offer.all_data') }}",
                type: 'POST',
                data: function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content'); // Incluye el token CSRF
                    // Recoger datos adicionales del formulario de filtro
                    d.studies = $('input[name="studies"]:checked').map(function() {
                        return this.value;
                    }).get(); // Recoge todos los checkboxes de estudios que están marcados
                    d.region = $('input[name="region"]:checked').map(function() {
                        return this.value;
                    }).get(); // Recoge todos los checkboxes de región que están marcados
                    d.ageRange = $('input[name="ageRange"]:checked').map(function() {
                        return this.value;
                    }).get(); // Recoge todos los checkboxes de rango de edad que están marcados
                    d.gender = $('input[name="gender"]:checked').map(function() {
                        return this.value;
                    }).get(); // Recoge todos los checkboxes de género que están marcados
                    d.cvMin = $("input[name='cvUpdateMinDate']").val(); 
                    d.cvMax = $("input[name='cvUpdateMaxDate']").val();
                    d.customGender = $('#customGender').val(); // Valor del campo de género personalizado
                    d.customAgeMin = $('#customAgeMin').val(); // Valor del campo de edad mínima personalizado
                    d.customAgeMax = $('#customAgeMax').val(); // Valor del campo de edad máxima personalizado
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "age" },
                { "data": "gender" },
                { "data": "marital_status" },
                { "data": "education_level" },
                { "data": "nationality" },
                { "data": "email" },
                { "data": "region" },
                { "data": "phone" },
                { "data": "CV" },
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
    
        // Detectar cambios en cualquier input del formulario de filtros y recargar DataTables
        $('.filter').on('change', function() {
            tabla.ajax.reload(); // Recargar los datos de DataTables
        });
        
        
        $('#usersTable').on('change', '.id-candidate', function() {
            let offerId = $('#offerId').val();  // Obtiene el valor del input oculto que contiene el ID de la oferta
            console.log($(this).val());
            
            $.ajax({
                url: "{{ route('offer.all_data') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // Incluye el token CSRF
                    idCandidate: $(this).val(),  // Asegúrate de que 'idCandidate' es el nombre del parámetro esperado por tu controlador
                    offerId: offerId  // ID de la oferta de trabajo
                },
                success: function(response) {
                    // Recargar DataTables
                    tabla.ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud: " + status + ", " + error);
                }
            });
        });
        
    });

</script>
@endpush
