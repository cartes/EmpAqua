<div class="modal fade" id="loginBusiness" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if(!session()->has('id'))
                <div class="modal-header">
                    <h4 class="modal-title">Ingresa con tu usuario de empresa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="far fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="my-3" method="post" action="{{ route('business.login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                       name="email" placeholder="Email usuario" value="{{old('email')}}"/>
                                @if($errors->has('email'))
                                    <span class="invalid-feedback">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                                       name="password" placeholder="Clave" value="{{old('password')}}"/>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-right">
                                <a class="forgot-password" href="{{ route('resetPasswordBusinessForm') }}">
                                    Olvidaste tu contraseña
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <button type="button" class="w-50 btn btn-secondary" data-dismiss="modal"
                                        aria-label="Close">Cancelar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="w-50 btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>

                    <hr />

                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <p class="m-0 p-0">¿Tú empresa no estas registrada?</p>
                            <p>
                                <a data-toggle="modal" data-target="#registerBusiness" href="#" data-dismiss="modal">
                                    Registrala Aquí
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
