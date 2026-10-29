@extends('layout.app')

@section('content')
    <div class="container container-contact">
        @if (null !== session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-10">

                <div class="card card-user">
                    <div class="card-header">
                        <h3 class="card-title">
                            Contáctanos
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{route('contact')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Nombres y apellidos" name="name" value="{{old('name')}}"/>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Email" name="email" value="{{old('email')}}"/>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="Teléfono" name="phone" value="{{old('phone')}}">

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Asunto</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                               placeholder="Asunto" name="subject" value="{{old('subject')}}" />

                                        @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mensaje</label>
                                        <textarea type="text" class="form-control @error('message_user') is-invalid @enderror"
                                                name="message_user" placeholder="Mensaje">{{old('message_user')}}</textarea>

                                        @error('message_user')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary btn-round">Enviar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection