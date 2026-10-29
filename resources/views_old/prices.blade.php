@extends("layout.app")

@section("content")
    <div class="container">
        @if(null!==session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include('partials.modals.loginHome')
        @include('partials.modals.loginBusiness')
        @include("partials.modals.register")
        @include('partials.modals.registerBusiness')
        @include('partials.modals.loginBusinessToPost')
    </div>

    <div class="container">
        <div class="mb-3">
            <div class="row justify-content-center">
                <div class="col-md-4 d-flex">
                    <img class="mx-auto text-center w-75" src="{{asset('/images/1x/logo-empleos.png')}}">
                </div>
            </div>
        </div>
        <div class="mt-3 mt-md-5 prices-table row justify-content-center">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                
                            </th>
                            <th>
                                
                            </th>
                            <th class="text-center" colspan="8"
                                style="background-color: #ffcc00; color: #fff; font-weight: 700;">
                                PAGADO
                            </th>
                            
                        </tr>
                        <tr>
                            <th scope="col" style=" font-weight: 700;">
                                Plan
                            </th>
                            <th scope="col" class="text-center"
                                style="background-color: #ffcc00; color: #fff; font-weight: 700;">
                                GRATIS
                            </th>
                            <th scope="col" class="text-center"
                                style="background-color: #29abe2; color: #fff; font-weight: 700;">
                                BÁSICO
                            </th>
                            <th scope="col" class="text-center"
                                style="background-color: #0071bc; color: #fff; font-weight: 700;">
                                PREMIUM
                            </th>
                            <th scope="col" class="text-center"
                                style="background-color: #002b62; color: #fff; font-weight: 700;">
                                GOLD
                            </th>
                            <th colspan="4" scope="col" class="text-center"
                                style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                                CORPORATIVO
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">
                            Meses
                        </th>
                        <td class="text-center">
                            1 Mes
                        </td>
                        <td class="text-center">
                            1 Mes
                        </td>
                        <td class="text-center">
                            1 Mes
                        </td>
                        <td class="text-center">
                            1 Mes
                        </td>
                        <td class="text-center">
                            3 Meses
                        </td>
                        <td class="text-center">
                            6 Meses
                        </td>
                        <td class="text-center">
                            9 Meses
                        </td>
                        <td class="text-center">
                            12 Meses
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Avisos básicos
                        </th>
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center">
                            Ilimitado
                        </td>
                        <td class="text-center">
                            Ilimitado
                        </td>
                        <td class="text-center">
                            Ilimitado
                        </td>
                        <td colspan="4" class="text-center">
                            Ilimitado
                        </td>
                    </tr>
                    <tr style="background-color: #f29100">
                        <th style="color: #fff;" scope="row">
                            Avisos destacados
                        </th>
                        <td style="color: #fff;" class="text-center">
                            <i class="fas fa-times"></i>
                        </td>
                        <td style="color: #fff;" class="text-center">
                            2
                        </td>
                        <td style="color: #fff;" class="text-center">
                            3
                        </td>
                        <td style="color: #fff;" class="text-center">
                            6
                        </td>
                        <td style="color: #fff;" class="text-center">
                            10
                        </td>
                        <td style="color: #fff;" class="text-center">
                            12
                        </td>
                        <td style="color: #fff;" class="text-center">
                            15
                        </td>
                        <td style="color: #fff;" class="text-center">
                            30
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Descargar CV
                        </th>
                        <td class="text-center">
                            3
                        </td>
                        <td class="text-center">
                            15
                        </td>
                        <td class="text-center">
                            30
                        </td>
                        <td class="text-center">
                            45
                        </td>
                        <td colspan="4" class="text-center">
                            Ilimitado
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Cuentas corporativas
                        </th>
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center">
                            1
                        </td>
                        <td colspan="4" class="text-center">
                            1
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Dashboard de administración
                        </th>
                        <td class="text-center">
                            <i class="fas fa-times"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td colspan="4" class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Chat con postulantes
                        </th>
                        <td class="text-center">
                            <i class="fas fa-times"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td colspan="4" class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Reportes
                        </th>
                        <td class="text-center">
                            <i class="fas fa-times"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td colspan="4" class="text-center">
                            <i class="fas fa-check"></i>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            Ejecutivo Asignado
                        </th>
                        <td class="text-center">
                            <i class="fas fa-times"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                        <td colspan="4" class="text-center">
                            <i class="fas fa-check"></i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Valor Neto
                        </th>
                        <td class="text-center" style="background-color: #ffcc00; color: #fff; font-weight: 700;">
                            Sin Costo
                        </td>

                        <td class="text-center" style="background-color: #29abe2; color: #fff; font-weight: 700;">
                            $55.000
                        </td>
                        <td class="text-center" style="background-color: #0071bc; color: #fff; font-weight: 700;">
                            $90.000
                        </td>
                        <td class="text-center" style="background-color: #002b62; color: #fff; font-weight: 700;">
                            $150.000
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $750.000
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $1.350.000
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $1.690.000
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $1.890.000
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Valor con IVA incluido
                        </th>
                        <td class="text-center" style="background-color: #ffcc00; color: #fff; font-weight: 700;">
                            Sin Costo
                        </td>

                        <td class="text-center" style="background-color: #29abe2; color: #fff; font-weight: 700;">
                            $65.450
                        </td>
                        <td class="text-center" style="background-color: #0071bc; color: #fff; font-weight: 700;">
                            $107.100
                        </td>
                        <td class="text-center" style="background-color: #002b62; color: #fff; font-weight: 700;">
                            $178.500
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $892.500
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $1.606.500
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $2.011.100
                        </td>
                        <td class="text-center" style="background-color: #2f2f2f; color: #fff; font-weight: 700;">
                            $2.249.100
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-12 col-sm-12 justify-content-center text-center">
                <a role="button" href="{{ route('contactPage') }}" class="btn btn-lg btn-primary px-5">Contáctanos</a>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <style>
        .col-gratis .table thead, .col-gratis .bg-custom {
            background-color: #D88F32;
            color: #fff;
        }

        .col-basico .table thead, .col-basico .bg-custom {
            background-color: #78acd8;
            color: #fff;
        }

        .col-premium .table thead, .col-premium .bg-custom {
            background-color: #223278;
            color: #fff;
        }

        .col-corporativo .table thead, .col-corporativo .bg-custom {
            background-color: #070d39;
            color: #fff;
        }

        .table thead {
            text-transform: uppercase;
        }

        .back-orange {
            background-color: #D88F32;
            color: #fff;
        }

        .fas {
            font-size: 17px;
        }

        .fa-check-circle {
            color: #168507;
        }

        .fa-times-circle {
            color: #dd3f4d;
        }
    </style>
@endpush

