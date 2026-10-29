<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Candidatos para oferta {{ $offer->title }}</h3>
                        <small>Id: {{ $offer->id }}</small>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-end">
                    <div class="col-sm-4">
                        <label for="status-filter">Filtrar por Estado:</label>
                        <select id="status-filter" class="form-control">
                            <option value="">Todos</option>
                            <option value="Revisar">Revisar</option>
                            <option value="Preselección">Preselección</option>
                            <option value="Selección">Selección</option>
                            <option value="Entrevistado">Entrevistado</option>
                            <option value="Contratado">Contratado</option>
                            <option value="Sin perfil">Sin perfil</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <table id="candidate-table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th scope="col"><p class="m-0 text-center">Nombre Postulante</p></th>
                                <th scope="col"><p class="m-0 text-center">Edad</p></th>
                                <th scope="col"><p class="m-0 text-center">Género</p></th>
                                <!-- Estado Civil columna removida -->
                                <th scope="col"><p class="m-0 text-center">Fecha de Postulación</p></th>
                                <th scope="col"><p class="m-0 text-center" data-orderable="false">Nivel educacional</p></th>
                                <th scope="col"><p class="m-0 text-center">Nacionalidad</p></th>
                                <th scope="col"><p class="m-0 text-center">Email</p></th>
                                <th scope="col"><p class="m-0 text-center" data-orderable="false">Teléfono</p></th>
                                <th data-orderable="false"></th>
                                <th data-orderable="false"></th>
                                <th scope="col">Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($candidates as $candidate)
                                @if ($candidate->user)
                                <tr @if($candidate->favorite == 1) class="table-light"  @endif>
                                    <td>
                                        <input type="checkbox" 
                                            class="form-check-input add-favorite" 
                                            style="margin-left: 0;"
                                            name="favorite" @if($candidate->favorite == 1) checked  @endif />
                                        <input type="hidden" name="user" value="{{ $candidate->user->id }}"/>
                                        <input type="hidden" name="offer" value="{{ $offer->id }}"/>
                                    </td>
                                    <td>
                                        <p class="m-0">
                                            @if (!is_null($candidate->user))
                                                <a href="{{ route('user.file', [$candidate->user->id, $offer->id]) }}">
                                                    {{ $candidate->user->name ?? '' }} {{ $candidate->user->surname ?? '' }}
                                                </a>
                                            @endif
                                        </p>
                                    </td>
                                    <td><p class="m-0 text-center">{{ $candidate->user->age ?? '' }}</p></td>
                                    <td><p class="m-0 text-left">{{ $candidate->user->gender ?? '' }}</p></td>

                                    <!-- Nueva columna: Fecha de Postulación -->
                                    <td><p class="m-0 text-center">{{ $candidate->date ?? '' }}</p></td>

                                    <td>
                                        <ul>
                                        @foreach($candidate->user->userEducation as $education)
                                            <li>{{$education->title}} ({{$education->condition}})</li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td><p class="m-0 text-left">{{ $candidate->user->nacionality ?? '' }}</p></td>
                                    <td><p class="m-0 text-left">{{ $candidate->user->email ?? '' }}</p></td>
                                    <td><p class="m-0 text-right">{{ $candidate->user->userMeta->phone ?? '' }}</p></td>
                                    @if($candidate->user->userMeta)
                                    <td class="text-center">
                                        <p>
                                            @if (!is_null($candidate->user->userMeta->path))
                                            <a href="{{asset( 'storage/resume/' . $candidate->user->userMeta->path )}}">
                                                <i style="font-size: 20px;" class="far fa-file-alt"></i>
                                            </a>
                                            @else
                                                Sin CV
                                            @endif
                                        </p>
                                    </td>
                                    @else
                                        <td>
                                            <p>Sin CV</p>
                                        </td>
                                    @endif
                                    <td>
                                        <form class="sendMessage">
                                            @php(
                                                $lastMessage = \App\Message::where([
                                                    'user_id' => $candidate->user->id,
                                                    'offer_id' => $offer->id
                                                ])->where('sender_id', '!=', session()->get('id') )->latest()->first()
                                            )
                                            <input type="hidden" name="user" value="{{ $candidate->user->id }}"/>
                                            <input type="hidden" name="offer" value="{{ $offer->id }}"/>
                                            <button type="submit" class="submitSendMessage"
                                                    style="background: none; padding: 0; border: none;">
                                                <i style="font-size: 20px;" class="far fa-comment-alt"></i>
                                                @isset ($lastMessage->status)
                                                    {!! $lastMessage->status == 3 ? "<span class='badge badge-pill badge-success'>1</span>" : ""  !!}
                                                @endisset
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <input type="hidden" id="statusValue" name="statusValue" value="{{optional($candidate->candidateStatus)->status}}" />
                                        <select class="form-control select-status" data-candidate-id="{{ $candidate->user->id }}" data-offer-id="{{ $offer->id }}">
                                            <option>Seleccione un estatus</option>
                                            <option value="Revisar" {{ optional($candidate->candidateStatus)->status == 'Revisar' ? 'selected' : '' }}>Revisar</option>
                                            <option value="Preselección" {{ optional($candidate->candidateStatus)->status == 'Preselección' ? 'selected' : '' }}>Preselección</option>
                                            <option value="Selección" {{ optional($candidate->candidateStatus)->status == 'Selección' ? 'selected' : '' }}>Selección</option>
                                            <option value="Entrevistado" {{ optional($candidate->candidateStatus)->status == 'Entrevistado' ? 'selected' : '' }}>Entrevistado</option>
                                            <option value="Contratado" {{ optional($candidate->candidateStatus)->status == 'Contratado' ? 'selected' : '' }}>Contratado</option>
                                            <option value="Sin perfil" {{ optional($candidate->candidateStatus)->status == 'Sin perfil' ? 'selected' : '' }}>Sin perfil</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    jQuery(document).ready(function ($) {
        var table = $('#candidate-table').DataTable({
            language: {
                paginate: {
                    previous: '<span aria-hidden="true">&larr;</span>', // Flecha izquierda
                    next: '<span aria-hidden="true">&rarr;</span>'     // Flecha derecha
                },
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                search: "Buscar:",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                emptyTable: "No hay datos disponibles en la tabla"
            }
            
    });

    // Filtro personalizado por estado
    $('#status-filter').on('change', function () {
        var selectedStatus = $(this).val();
        $.fn.dataTable.ext.search = [];

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var row = table.row(dataIndex).node();
            var estadoHidden = $(row).find('input[name="statusValue"]').val();
            return selectedStatus === "" || estadoHidden === selectedStatus;
        });

        table.draw();
    });

    // Actualización de estado por fila
    $('.select-status').on('change', function () {
        let candidateId = $(this).data('candidate-id');
        let offerId = $(this).data('offer-id');
        let status = $(this).val();
        let $row = $(this).closest('tr');

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
                    // Muestra el toast
                    $('#successToast').toast({ delay: 4000 }).toast('show');

                    // Actualiza el input oculto de la fila
                    $row.find('input[name="statusValue"]').val(status);

                    // Vuelve a aplicar el filtro si está activo
                    $('#status-filter').trigger('change');
                }
            }
        });
    });
});
</script>

<style>
  #candidate-table td, #candidate-table th {
      border-right: 1px solid #ddd;
  }
  
  #candidate-table th:last-child, #candidate-table td:last-child {
      border-right: none;
  }
</style>
