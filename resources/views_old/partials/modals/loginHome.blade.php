<div class="modal fade" id="loginUserModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if(!session()->has('id'))
                <div class="modal-header">
                    <h4 class="modal-title">Ingreso a <strong>{{config('app.name')}}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="my-3" method="post" action="{{route('login')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Email usuario</label>
                                <input class="form-control" type="text" id="email" name="email" required/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Contraseña</label>
                                <input class="form-control" type="password" id="password" name="password" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-right">
                                <a class="forgot-password" href="{{ route('resetPasswordForm') }}">
                                    Olvidaste tu contraseña
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 text-right">
                                <button type="button" class="w-100 w-50 btn btn-secondary" data-dismiss="modal"
                                        aria-label="Close">Cancelar
                                </button>
                            </div>
                            <div class="col-6 col-md-6">
                                <button type="submit" class="w-100 w-50 btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <p class="m-0 p-0">¿No estás registrado?</p>
                            <p><a data-toggle="modal" data-target="#registerModal" href="#" data-dismiss="modal">Registrate
                                    Aquí</a></p>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
