<div id="messageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
     aria-labelledby="messageModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="titleModal" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sendMessageForm" class="form" method="post" action="{{ route("message.send") }}">
                    @csrf
                    <input id="user_id_input" type="hidden" name="user_id" />
                    <input id="offer_id_input" type="hidden" name="offer_id" />
                    <div class="row form-group">
                        <label>Mensajes</label>
                        <ul id="messages_log" class="w-100"></ul>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 text-right">
                            <label>Mensaje: </label>
                        </div>
                        <input class="form-control col-md-8" type="text" id="message_content"
                               name="content"/>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
