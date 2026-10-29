@extends('layout.home')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container-fluid mt-5">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include('partials.business.candidatedetail')

        @include('partials.modals.message')
        
        <div class="toast fade top-50 left-50" id="successToast" role="alert" aria-live="assertive" aria-atomic="true"
             style="position: fixed; top: 45%; right: 40%; z-index: 9999; min-width: 300px;">
          <div class="toast-header bg-success text-white">
            <strong class="mr-auto">Éxito</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            Estado actualizado con éxito.
          </div>
        </div>
    
        </div>
    
@endsection

@push("styles")
    <style media="all">
        textarea#messages_log {
            overflow-y: scroll;
            height: 350px;
            resize: none;
        }
        .table {
            font-size: 0.75rem;
        }
        table.dataTable thead th {
        	background-repeat: no-repeat;
        	background-position: right 20px;
        	padding-right: 17px !important;
        }

        .table th, .table td {
        	padding: 0.25rem !important;
        }
        table.dataTable thead .sorting {
          background-image: url('{{url("images/sort_both.png")}}');
        }
        table.dataTable thead .sorting_asc {
          background-image: url('{{url("images/sort_asc.png")}}');
        }
        table.dataTable thead .sorting_desc {
          background-image: url('{{url("images/sort_desc.png")}}');
        }
        table.dataTable thead .sorting_asc_disabled {
          background-image: url('{{url("images/sort_asc_disabled.png")}}');
        }
        table.dataTable thead .sorting_desc_disabled {
          background-image: url('{{url("images/sort_desc_disabled.png")}}');
        }
        
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
            text-align: center;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #e6e6e6;         /* Gris claro para todos los botones */
            color: #888 !important;            /* Gris medio para el texto */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            margin: 0 8px;
            display: inline-block;
            cursor: pointer;
            user-select: none;
            font-weight: 600;
            border: 2px solid transparent !important;
            font-size: 1.2rem;
            text-align: center;
            vertical-align: middle;
            transition: background-color 0.3s, color 0.3s, border 0.3s;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #E0312B;      /* Rojo del logo */
            color: #fff !important;         /* Blanco en activo */
            border: 2px solid #a72118 !important; /* Sutil borde oscuro para resaltar */
            font-weight: 700;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background-color: #ffb3ad;    /* Rojo claro para hover */
            color: #E0312B !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background-color: #f1f1f1 !important;
            color: #ccc !important;
            border: 2px solid transparent !important;
            cursor: not-allowed !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .ellipsis {
            background: none !important;
            border: none !important;
            color: #888 !important;
            margin: 0 8px;
            width: auto;
            display: inline;
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {

            $('.add-favorite').on('change', function() {
                let user = $(this).parent().find("input[name='user']").val();
                let offer = $(this).parent().find("input[name='offer']").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: '{{ route('offer.addFavorite')}}',
                    data: {
                        'offer': offer,
                        'user': user
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });

            })



            $('.alert').stop();
            $('.submitSendMessage').click(function (e) {
                e.preventDefault();
                var user = $(this).parent().find("input[name='user']").val();
                var offer = $(this).parent().find("input[name='offer']").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: '{{ route('message.show') }}',
                    data: {
                        'user': user,
                        'offer': offer
                    },
                    success: function (resp) {
                        var titleModal = "Mensaje";
                        $("#titleModal").empty().append(titleModal);

                        $("#messageModal").modal("show");
                        $("#user_id_input").val(user);
                        $("#offer_id_input").val(offer);
                        $("#messages_log").empty();
                        let messages = resp.messages;
                        for (var i = 0; i < messages.length; i++) {
                            let tag;
                            if (resp.messages[i].sender_id == resp.reader) {
                                tag = "<li class='clearfix'><p class='message message-send float-left alert-success d-block'>";
                            } else {
                                tag = "<li class='clearfix'><p class='message message-reply float-right alert-secondary'>";
                            }
                            var html = tag + messages[i].content + "<small class='message-time'>" + messages[i].created_at + "</small>" + "</p></div>";
                            $("#messages_log").append(html);
                        }
                    },
                    error: function (resp) {
                        console.error(resp)
                    }
                })
            });
        })
    </script>
@endpush
