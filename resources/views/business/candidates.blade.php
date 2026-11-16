@extends('layout.app')
@section('title', '- Candidatos: ' . $offer->title)
@section('robots', 'noindex, nofollow')

@push('styles')
    <style>
        .container.container-admin {
            width: 100% !important;
            max-width: 1320px !important;
        }

        .hero-admin-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        /* Contenedor responsivo con scroll horizontal suave */
        .candidate-table-scroll {
            position: relative;
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        #candidate-table {
            min-width: 1420px;
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            font-size: 0.84rem;
            margin: 0 !important;
        }

        #candidate-table thead th {
            background-color: #0D4A96 !important;
            color: #ffffff !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.74rem;
            letter-spacing: 0.5px;
            border-top: none;
            border-bottom: 2px solid #083266;
            padding: 0.75rem 0.65rem;
            white-space: nowrap;
            vertical-align: middle;
        }

        #candidate-table tbody td {
            padding: 0.65rem 0.65rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
            background-color: #ffffff;
        }

        /* Destacado de fila favorita */
        #candidate-table tbody tr.table-favorite td {
            background-color: #fff9e6 !important;
        }

        /* Hover consistente */
        #candidate-table tbody tr:hover td {
            background-color: #f0f4f9 !important;
        }

        /* ========================================================
           COLUMNAS FIJAS / FREEZE PANE (FAVORITO + NOMBRE)
           ======================================================== */
        /* Columna 1: Favorito (estrella / checkbox) */
        #candidate-table .col-fav {
            position: sticky !important;
            left: 0 !important;
            width: 48px !important;
            min-width: 48px !important;
            max-width: 48px !important;
            text-align: center;
            z-index: 5;
        }

        #candidate-table thead th.col-fav {
            z-index: 15 !important;
            background-color: #0D4A96 !important;
            color: #ffffff !important;
        }

        /* Columna 2: Nombre Postulante fija a continuación */
        #candidate-table .col-name {
            position: sticky !important;
            left: 48px !important;
            width: 220px !important;
            min-width: 220px !important;
            max-width: 260px !important;
            z-index: 5;
            border-right: 2px solid #cbd5e0 !important;
            box-shadow: 4px 0 8px -2px rgba(13, 74, 150, 0.14);
        }

        #candidate-table thead th.col-name {
            z-index: 15 !important;
            background-color: #0D4A96 !important;
            color: #ffffff !important;
        }

        /* Fondos sólidos para columnas fijas para que el contenido no transparente al scroll */
        #candidate-table tbody td.col-fav,
        #candidate-table tbody td.col-name {
            background-color: #ffffff;
        }

        #candidate-table tbody tr:nth-of-type(even) td.col-fav,
        #candidate-table tbody tr:nth-of-type(even) td.col-name {
            background-color: #fafbfc;
        }

        #candidate-table tbody tr.table-favorite td.col-fav,
        #candidate-table tbody tr.table-favorite td.col-name {
            background-color: #fff9e6 !important;
        }

        #candidate-table tbody tr:hover td.col-fav,
        #candidate-table tbody tr:hover td.col-name {
            background-color: #f0f4f9 !important;
        }

        /* ========================================================
           ESTILOS DATATABLES CORPORATIVOS (AZUL & NARANJA EMPLEOS AQUA)
           ======================================================== */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            padding: 0.85rem 1.25rem;
            font-size: 0.85rem;
            color: #495057;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 20px;
            padding: 0.3rem 0.85rem;
            margin-left: 0.5rem;
            outline: none;
            font-size: 0.85rem;
            transition: border-color 0.2s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #0D4A96;
            box-shadow: 0 0 0 0.2rem rgba(13, 74, 150, 0.15);
        }

        .dataTables_wrapper .dataTables_info {
            padding: 1rem 1.25rem;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 0.85rem 1.25rem;
            text-align: right;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 50% !important;
            width: 34px;
            height: 34px;
            line-height: 34px;
            padding: 0 !important;
            margin: 0 3px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid transparent !important;
            background: #e9ecef;
            color: #495057 !important;
            transition: all 0.2s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #0D4A96 !important;
            color: #ffffff !important;
            border-color: #0D4A96 !important;
            box-shadow: 0 2px 6px rgba(13, 74, 150, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: #d8e5f7 !important;
            color: #0D4A96 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #f8f9fa !important;
            color: #ced4da !important;
            cursor: not-allowed !important;
        }

        /* Indicadores de orden DataTables */
        table.dataTable thead th.sorting,
        table.dataTable thead th.sorting_asc,
        table.dataTable thead th.sorting_desc {
            cursor: pointer;
            position: relative;
            padding-right: 22px !important;
        }

        table.dataTable thead th.sorting:after {
            content: "↕";
            position: absolute;
            right: 8px;
            opacity: 0.45;
            color: #fff;
            font-size: 0.75rem;
        }

        table.dataTable thead th.sorting_asc:after {
            content: "▲";
            position: absolute;
            right: 8px;
            opacity: 1;
            color: #F08F01;
            font-size: 0.75rem;
        }

        table.dataTable thead th.sorting_desc:after {
            content: "▼";
            position: absolute;
            right: 8px;
            opacity: 1;
            color: #F08F01;
            font-size: 0.75rem;
        }

        textarea#messages_log {
            overflow-y: scroll;
            height: 350px;
            resize: none;
        }
    </style>
@endpush

@section('content')
    <div class="container container-admin mt-4 mb-5">
        {{-- Breadcrumb / Botón volver --}}
        <div class="mb-3">
            <a href="{{ route('offer.admin') }}" class="btn btn-sm btn-outline-primary font-weight-bold">
                <i class="fas fa-arrow-left mr-1"></i> Volver a mis ofertas
            </a>
        </div>

        {{-- Hero Header de la oferta --}}
        <div class="card hero-admin-card border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                        <div class="d-flex align-items-center flex-wrap mb-2">
                            <span class="badge badge-pill badge-primary mr-2 px-3 py-1 font-weight-bold" style="background-color: #0D4A96;">
                                Oferta #{{ $offer->id }}
                            </span>
                            @if ($offer->published == 1)
                                <span class="badge badge-pill badge-success px-3 py-1 font-weight-bold">
                                    <i class="fas fa-check-circle mr-1"></i> Activa
                                </span>
                            @elseif ($offer->published == 0)
                                <span class="badge badge-pill badge-warning px-3 py-1 font-weight-bold text-dark">
                                    <i class="fas fa-pause-circle mr-1"></i> Inactiva
                                </span>
                            @else
                                <span class="badge badge-pill badge-secondary px-3 py-1 font-weight-bold">
                                    <i class="fas fa-lock mr-1"></i> Cerrada
                                </span>
                            @endif
                            @if ($offer->featured == 1)
                                <span class="badge badge-pill badge-warning px-3 py-1 font-weight-bold ml-2 text-white" style="background-color: #F08F01;">
                                    <i class="fas fa-star mr-1"></i> Destacada
                                </span>
                            @endif
                        </div>

                        <h3 class="h4 font-weight-bold mb-1" style="color: #0D4A96;">{{ $offer->title }}</h3>

                        <div class="text-muted small">
                            <span class="mr-3"><i class="far fa-calendar-alt mr-1"></i> Publicada: <strong>{{ $offer->date }}</strong></span>
                            <span><i class="far fa-clock mr-1"></i> Vence: <strong>{{ $offer->expiration_date }}</strong></span>
                            @if (!empty($offer->comune) || !empty($offer->city))
                                <span class="ml-3"><i class="fas fa-map-marker-alt mr-1"></i> {{ $offer->comune ?: $offer->city }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5 text-md-right">
                        <div class="d-inline-flex align-items-center">
                            <div class="text-center bg-light p-3 rounded mr-3 border" style="min-width: 120px;">
                                <div class="h3 font-weight-bold mb-0" style="color: #0D4A96;">{{ $candidates->count() }}</div>
                                <small class="text-muted text-uppercase font-weight-bold" style="font-size: 0.7rem;">Postulantes</small>
                            </div>
                            <div class="d-flex flex-column text-left">
                                <a href="{{ route('offer.detail', $offer->slug) }}" class="btn btn-sm btn-outline-primary mb-2 text-nowrap">
                                    <i class="fas fa-pencil-alt mr-1"></i> Editar oferta
                                </a>
                                <a href="{{ route('offer.show', $offer->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary text-nowrap">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ver en portal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de candidatos --}}
        @include('partials.business.candidatedetail')

        {{-- Modales --}}
        @include('partials.modals.message')
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        jQuery(document).ready(function ($) {
            // Inicializar DataTables
            var table = $('#candidate-table').DataTable({
                language: {
                    paginate: {
                        previous: '<span aria-hidden="true">&larr;</span>',
                        next: '<span aria-hidden="true">&rarr;</span>'
                    },
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron candidatos",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ candidatos",
                    infoEmpty: "Mostrando 0 a 0 de 0 candidatos",
                    infoFiltered: "(filtrado de _MAX_ candidatos totales)",
                    search: "Buscar postulante:",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    emptyTable: "No hay postulaciones registradas en esta oferta"
                },
                pageLength: 25,
                order: [[1, 'asc']], // Ordenar por nombre por defecto
                dom: '<"d-flex flex-wrap justify-content-between align-items-center"lf>t<"d-flex flex-wrap justify-content-between align-items-center"ip>'
            });

            // Filtro personalizado por estado
            $('#status-filter').on('change', function () {
                var selectedStatus = $(this).val();
                $.fn.dataTable.ext.search = [];

                if (selectedStatus !== "") {
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                        var row = table.row(dataIndex).node();
                        var estadoHidden = $(row).find('input[name="statusValue"]').val();
                        return estadoHidden === selectedStatus;
                    });
                }

                table.draw();
            });

            // Helper para Toast flotante dinámico
            function showCandidateToast(message, type) {
                type = type || 'success';
                var icon = type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
                var headerBg = type === 'success' ? 'bg-success text-white' : 'bg-primary text-white';
                var title = type === 'success' ? 'Éxito' : 'Notificación';

                var toastHtml = `
                    <div class="toast shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000" style="border: 0; border-radius: 8px; overflow: hidden; background: #fff; min-width: 300px;">
                        <div class="toast-header ${headerBg} py-2 px-3 border-0 d-flex align-items-center">
                            <i class="fas ${icon} mr-2"></i>
                            <strong class="mr-auto font-weight-bold" style="font-size: 0.9rem;">${title}</strong>
                            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Cerrar" style="outline: none; opacity: 0.85; text-shadow: none;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body py-2 px-3 text-dark font-weight-normal" style="font-size: 0.9rem; background: #fff;">
                            ${message}
                        </div>
                    </div>
                `;

                var $container = $('#candidateToastContainer');
                if (!$container.length) {
                    $container = $('<div id="candidateToastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 10500; max-width: 380px;"></div>').appendTo('body');
                }

                var $newToast = $(toastHtml).appendTo($container);
                $newToast.toast({ delay: 4000, autohide: true }).toast('show');
                $newToast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }

            // Actualización de estado del postulante vía AJAX
            $(document).on('change', '.select-status', function () {
                let $select = $(this);
                let candidateId = $select.data('candidate-id');
                let candidateName = $select.data('candidate-name') || 'el postulante';
                let offerId = $select.data('offer-id');
                let status = $select.val();
                let $row = $select.closest('tr');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('candidate.updateStatus') }}',
                    data: {
                        'candidate_id': candidateId,
                        'offer_id': offerId,
                        'status': status
                    },
                    success: function (data) {
                        if (data.success) {
                            $row.find('input[name="statusValue"]').val(status);

                            // Actualizar bordes visuales
                            $select.removeClass('border-info text-info border-primary text-primary font-weight-bold border-warning text-dark border-success text-success border-secondary text-muted');
                            if (status === 'Contratado') {
                                $select.addClass('border-success text-success font-weight-bold');
                            } else if (status === 'Preselección' || status === 'Selección') {
                                $select.addClass('border-primary text-primary font-weight-bold');
                            } else if (status === 'Entrevistado') {
                                $select.addClass('border-warning text-dark font-weight-bold');
                            } else if (status === 'Revisar') {
                                $select.addClass('border-info text-info');
                            } else {
                                $select.addClass('border-secondary text-muted');
                            }

                            showCandidateToast('Estado de <strong>' + candidateName + '</strong> actualizado a <strong>' + (status || 'Sin estado') + '</strong>.');

                            // Re-aplicar filtro si está activo
                            if ($('#status-filter').val() !== "") {
                                table.draw();
                            }
                        }
                    },
                    error: function () {
                        showCandidateToast('Error al actualizar el estado del postulante.', 'danger');
                    }
                });
            });

            // Toggle de favoritos
            $(document).on('change', '.add-favorite', function () {
                let $checkbox = $(this);
                let user = $checkbox.closest('td').find("input[name='user']").val();
                let offer = $checkbox.closest('td').find("input[name='offer']").val();
                let $row = $checkbox.closest('tr');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('offer.addFavorite') }}',
                    data: {
                        'offer': offer,
                        'user': user
                    },
                    success: function (data) {
                        if (data.favorite) {
                            $row.addClass('table-favorite');
                            showCandidateToast('Postulante marcado como favorito.');
                        } else {
                            $row.removeClass('table-favorite');
                            showCandidateToast('Postulante removido de favoritos.', 'info');
                        }
                    },
                    error: function() {
                        $checkbox.prop('checked', !$checkbox.prop('checked'));
                        showCandidateToast('No se pudo actualizar el estado de favorito.', 'danger');
                    }
                });
            });

            // Modal de mensajes
            $(document).on('click', '.submitSendMessage', function (e) {
                e.preventDefault();
                var user = $(this).data('user');
                var offer = $(this).data('offer');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('message.show') }}',
                    data: {
                        'user': user,
                        'offer': offer
                    },
                    success: function (resp) {
                        $("#titleModal").text("Mensajes con el postulante");
                        $("#messageModal").modal("show");
                        $("#user_id_input").val(user);
                        $("#offer_id_input").val(offer);
                        $("#messages_log").empty();

                        let messages = resp.messages;
                        if (messages && messages.length > 0) {
                            for (var i = 0; i < messages.length; i++) {
                                let isSender = resp.messages[i].sender_id == resp.reader;
                                let tagClass = isSender ? 'alert-success float-left' : 'alert-secondary float-right';
                                var html = "<li class='clearfix mb-2'><p class='message d-inline-block p-2 rounded " + tagClass + "'>" +
                                    resp.messages[i].content +
                                    "<small class='message-time d-block text-muted' style='font-size: 0.7rem;'>" + resp.messages[i].created_at + "</small>" +
                                    "</p></li>";
                                $("#messages_log").append(html);
                            }
                        } else {
                            $("#messages_log").append("<li class='text-muted small text-center py-4'>No hay mensajes previos con este candidato. ¡Escribe el primero!</li>");
                        }
                    },
                    error: function () {
                        showCandidateToast('No se pudieron cargar los mensajes.', 'danger');
                    }
                });
            });
        });
    </script>
@endpush
