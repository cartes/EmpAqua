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
                        <h3 class="text-center">Ingrese una nueva contraseña</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="form-login py-5" action="{{ route('sendNewPasswword') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form-group">
                                <label for="password">Ingrese una nueva contraseña</label>
                                <input type="password" name="password" class="form-control"/>
                                @if ($errors->has("password"))
                                    <div class="alert alert-danger">{{ $errors->first("password") }}</div>
                                @endif

                            </div>
                            <div class="form-group">
                                <label for="password">Confirme su contra</label>
                                <input type="password" name="password_confirmation" class="form-control"/>
                                @if ($errors->has("password_confirmation"))
                                    <div class="alert alert-danger">{{ $errors->first("password_confirmation") }}</div>
                                @endif

                            </div>
                            <div class="form-group">
                                <input type="submit" value="enviar" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


@endsection
