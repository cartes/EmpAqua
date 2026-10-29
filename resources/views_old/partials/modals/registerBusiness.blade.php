<div class="modal fade" id="registerBusiness" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-3 px-4">
            @if (!session()->has('id'))
                <div class="modal-header">
                    <h4 style="font-size: 0,9rem;">Crea tu usuario y administra tu Empresa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="far fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="my-3" method="post" action="{{ route('business.register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Nombre (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                       id="firstname" name="firstname" value="{{ old('firstname') }}"/>
                                @if ($errors->has('firstname'))
                                    <span class="invalid-feedback">{{ $errors->first('firstname') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Apellido (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                       id="surname" name="surname" value="{{ old('surname') }}"/>
                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback">{{ $errors->first('surname') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Email (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('email_business') ? ' is-invalid' : '' }}"
                                       id="email_business" name="email_business" value="{{ old('email_business') }}"/>
                                @if ($errors->has('email_business'))
                                    <span class="invalid-feedback">{{ $errors->first('email_business') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Teléfono (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('phone_business') ? ' is-invalid' : '' }}"
                                       id="phone_business" name="phone_business" value="{{ old('phone_business') }}"/>
                                @if ($errors->has('phone_business'))
                                    <span class="invalid-feedback">{{ $errors->first('phone_business') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>RUT del usuario (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('rut_user') ? ' is-invalid' : '' }}"
                                       id="rut_user" name="rut_user" value="{{ old('rut_user') }}"/>
                                @if ($errors->has('rut_user'))
                                    <span class="invalid-feedback">{{ $errors->first('rut_user') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Cargo (*)</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                       id="position" name="position" value="{{ old('position') }}"/>
                                @if ($errors->has('position'))
                                    <span class="invalid-feedback">{{ $errors->first('position') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Contraseña (*)</label>
                                <input type="password"
                                       class="form-control{{ $errors->has('passbusiness') ? ' is-invalid' : '' }}"
                                       id="passbusiness" name="passbusiness" />
                                @if ($errors->has('passbusiness'))
                                    <span class="invalid-feedback">{{ $errors->first('passbusiness') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Confirmar Contraseña (*)</label>
                                <input type="password"
                                       class="form-control{{ $errors->has('passbusiness_confirmation') ? ' is-invalid' : '' }}"
                                       id="passbusiness_confirmation" name="passbusiness_confirmation" />
                                @if ($errors->has('passbusiness_confirmation'))
                                    <span class="invalid-feedback">{{ $errors->first('passbusiness_confirmation') }}</span>
                                @endif
                            </div>
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
                                <button type="submit" class="btn-register-business btn btn-primary">CREAR CUENTA</button>
                            </div>
                        </div>

                    </form>
                </div>
            @endif
        </div>
    </div>
</div>


@if (!empty($errors->hasAny(['firstname', 'surname', 'email_business', 'phone_business', 'rut_user', 'position', 'passbusiness'])))
    <script>
        jQuery(document).ready(function ($) {
            $('#registerBusiness').modal('show')
        })
    </script>
@endif
