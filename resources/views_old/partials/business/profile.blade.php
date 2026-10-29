@extends('layout.app')

@section('content')

    <div class="container">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center mt-4">
            <div class="col-md-2">
                <div class="container-logo-img">
                    <img class="logo-img h-100 w-auto" src="{{ $business->business_meta->pathAttachment() ?? '' }}">
                </div>
                <div class="container-edit">
                    <a href="{{ route('business.edit') }}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <h3 class="business-fantasy-name">{{ $business->business_meta->fantasy_name ?? '' }}</h3>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-8">
                        <h4 class="business-subtitle">Datos Empresa</h4>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route("business.edit") }}">Editar</a>
                    </div>
                </div>

                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">RUT:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->rut_business }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Razón social:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->business_name }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Giro:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->activity }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Dirección comercial:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->address }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Comuna:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->comune }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Ciudad:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->city }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Región:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->state }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Email:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->email }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Teléfono:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->phone }}
                    </div>
                </div>
                <div class="row business-data">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Cantidad de empleados:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->business_meta->employees }}
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <h4 class="business-subtitle">Información de contacto</h4>
                    </div>
                </div>

                <div class="row business-contact">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Nombre:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->firstname }} {{ $business->surname }}
                    </div>
                </div>
                <div class="row business-contact">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Email:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->email }}
                    </div>
                </div>
                <div class="row business-contact">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Teléfono:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->phone_user }}
                    </div>
                </div>
                <div class="row business-contact">
                    <div class="col-md-5">
                        <p class="m-0 p-0 business-item">Cargo:</p>
                    </div>
                    <div class="col-md-7">
                        {{ $business->position }}
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="shadow-sm card-side-profile card w-100">
                    <div class="card-body py-3 px-4">
                        <div class="row">
                            <div class="d-flex col-md-2 text-right">
                                <h2>{{ $candidates }}</h2>
                            </div>
                            <div class="d-flex col-md-10">
                                <h3>Postulaciones los últimos 7 días</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection
