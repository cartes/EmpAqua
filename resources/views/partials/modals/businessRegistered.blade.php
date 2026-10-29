<div class="modal fade" id="registeredBusinessModal"
     role="dialog"
     aria-labelledby="registeredBusinessModalLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-3 px-4">
            <div class="modal-header">
                <h4>Ya estás registrado en <strong>Empleos Aqua</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>¡Ahora puedes comenzar a publicar tus ofertas en nuestro portal!</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button data-dismiss="modal" aria-label="Close" class="btn btn-primary">Perfil Cuenta</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <a href="{{ route('post.create') }}" class="btn btn-primary">Publicar Oferta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
