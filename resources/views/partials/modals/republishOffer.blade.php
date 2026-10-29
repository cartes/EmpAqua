<div class="modal fade" id="republishOffer" role="dialog" aria-labelledby="republishOfferLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-3 px-4">
            <div class="modal-header">
                <h4>¿Deseas republicar tu oferta por 30 días más?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-6 text-right">
                        <a class="btn btn-light" href="#">Cancelar</a>
                    </div>
                    <div class="col-6">
                        <form id="republish-link" method="post" action="">
                            @csrf
                            @method("PUT")
                            <button type="submit" class="btn btn-primary">
                                Publicar nuevamente
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
