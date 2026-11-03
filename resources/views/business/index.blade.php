@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form class="form-business p-5" method="post" action="{{route('business.login')}}">
                    @csrf
                    <h3 class="text-center mb-4">
                        Ingrese con su perfil de Empresa
                    </h3>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                   name="email" placeholder="Email usuario" value="{{old('email')}}"/>
                            @if($errors->has('email'))
                                <span class="invalid-feedback">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="input-group">
                                <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                                       name="password" id="passwordBusinessIndex" placeholder="Clave" value="{{old('password')}}"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#passwordBusinessIndex" tabindex="-1" title="Mostrar / ocultar clave">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @if($errors->has('password'))
                                <span class="invalid-feedback d-block">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
@endsection