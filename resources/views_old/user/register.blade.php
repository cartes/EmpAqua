@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Regístrate</h2>
                <form class="form-login p-5 my-5" method="post" action="{{route('store')}}">
                    @csrf
                    <h3 class="text-center">Únete a {{config('app.name')}}</h3>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                                   id="name" name="name" value="{{old('name')}}"
                                   placeholder="Nombres"/>
                            @if($errors->has('name'))
                                <span class="invalid-feedback">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{$errors->has('surname') ? 'is-invalid' : ''}}"
                                   id="surname" name="surname" value="{{old('surname')}}"
                                   placeholder="Apellidos"/>
                            @if($errors->has('surname'))
                                <span class="invalid-feedback">{{$errors->first('surname')}}</span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control {{$errors->has('rut_user') ? 'is-invalid' : ''}}" id="rut"
                                   name="rut_user" placeholder="Rut" value="{{old('rut_user')}}"/>
                            @if($errors->has('rut_user'))
                                <span class="invalid-feedback">{{$errors->first('rut_user')}}</span>
                            @endif

                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                   id="email" name="email" placeholder="Email" value="{{old('email')}}"/>
                            @if($errors->has('email'))
                                <span class="invalid-feedback">{{$errors->first('email')}}</span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                                   id="password" name="password" value="{{old('password')}}"
                                   placeholder="Clave"/>
                            @if($errors->has('password'))
                                <span class="invalid-feedback">{{$errors->first('password')}}</span>
                            @endif

                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" class="d-inline-block" id="password" name="password"/>
                            <p class="d-inline-block">Mostrar clave</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
