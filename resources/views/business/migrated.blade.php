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

        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cambia tu contraseña</h4>
                    </div>
                    <div class="body">
                        <form class="form" method="post" action="{{route("business.passchange")}}">
                            @csrf
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input name="password"
                                       class="form-control{{ $errors->has("password") ? ' is-invalid' : '' }}"
                                       type="password" placeholder="Ingrese una contraseña">
                                @if ($errors->has("password"))
                                    <div class="alert alert-danger">{{ $errors->first("password") }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Confirme su contraseña</label>
                                <input name="password_confirmation"
                                       class="form-control{{ $errors->has("password_confirmation") ? ' is-invalid' : '' }}"
                                       type="password" placeholder="Ingrese la contraseña otra vez">
                                @if ($errors->has("password_confirmation"))
                                    <div class="alert alert-danger">{{ $errors->first("password_confirmation") }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection