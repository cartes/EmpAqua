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

        @include('partials.modals.loginHome')
        @include('partials.modals.loginBusiness')
        @include("partials.modals.register")
        @include('partials.modals.registerBusiness')

    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Ingrese su email para cambiar su contraseña</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="form-login py-5" action="{{ route('resetPassword') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-text">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="enviar" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
