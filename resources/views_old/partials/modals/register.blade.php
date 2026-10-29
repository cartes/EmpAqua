<div class="modal fade" id="registerModal" role="dialog" aria-labelledby="registerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-3 px-4">
            @if(!session()->has('id'))
                <div class="modal-header">
                    <h4 class="modal-title">Crea tu Perfil y únete a <strong>{{config('app.name')}}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('store')}}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Nombres(*)</label>
                                <input type="text"
                                       class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                                       id="name" name="name" value="{{old('name')}}"/>
                                @if($errors->has('name'))
                                    <span class="invalid-feedback">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>Apellidos(*)</label>
                                <input type="text" class="form-control {{$errors->has('surname') ? 'is-invalid' : ''}}"
                                       id="surname" name="surname" value="{{old('surname')}}"/>
                                @if($errors->has('surname'))
                                    <span class="invalid-feedback">{{$errors->first('surname')}}</span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Email(*)</label>
                                <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                       id="email" name="email" value="{{old('email')}}"/>
                                @if($errors->has('email'))
                                    <span class="invalid-feedback">{{$errors->first('email')}}</span>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <label>Teléfono(*)</label>
                                <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}"
                                       id="phone" name="phone" value="{{old('phone')}}"/>
                                @if($errors->has('phone'))
                                    <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Rut(*)</label>
                                <input type="text" class="form-control {{$errors->has('rut_candidate') ? 'is-invalid' : ''}}"
                                       id="rut_candidate"
                                       name="rut_candidate" value="{{old('rut_candidate')}}"/>
                                @if($errors->has('rut_candidate'))
                                    <span class="invalid-feedback">{{$errors->first('rut_candidate')}}</span>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <label>Contraseña(*)</label>
                                <input type="password"
                                       class="form-control {{$errors->has('passwordUser') ? 'is-invalid' : ''}}"
                                       id="passwordUser" name="passwordUser" value="{{old('passwordUser')}}"/>
                                @if($errors->has('passwordUser'))
                                    <span class="invalid-feedback">{{$errors->first('passwordUser')}}</span>
                                @endif

                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col col-md-12">
                                recaptcha
                              <div id="html_element"></div>
                            </div>
                            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                                async defer>
                            </script>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    Al hacer clic en CREAR CUENTA, aceptas las Condiciones de uso y la Política de
                                    privacidad de Empleos Aqua
                                </small>
                            </div>
                            <div class="col-md-12">
                                <p style="color: #212529;">
                                <input type="checkbox" class="d-inline-block mr-1" name="newsletter" id="newsletter"
                                       checked/>
                                    Acepto recibir newsletters con novedades, promociones y actualizaciones.
                                </p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 text-right">
                                <button type="button" class="w-50 btn btn-secondary" data-dismiss="modal"
                                        aria-label="Close">Cancelar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">CREAR CUENTA</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@if (!empty($errors->hasAny(['name', 'surnam', 'email', 'phone', 'rut_candidate', 'passwordUser'])))
    <script>
        jQuery(document).ready(function ($) {
            $('#registerModal').modal('show');
        })
    </script>
@endif
