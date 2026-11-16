<div class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold m-0" style="color: #0D4A96;">
                <i class="fas fa-users mr-2" style="color: #D88F32;"></i> Postulaciones recibidas
            </h5>
            <small class="text-muted">Desplaza horizontalmente para ver toda la información de cada candidato.</small>
        </div>
        <div class="d-flex align-items-center mt-2 mt-sm-0">
            <label for="status-filter" class="mr-2 mb-0 small font-weight-bold text-muted text-uppercase">Filtrar por estado:</label>
            <select id="status-filter" class="custom-select custom-select-sm" style="min-width: 180px; border-radius: 20px;">
                <option value="">Todos los estados</option>
                <option value="Revisar">🔍 Revisar</option>
                <option value="Preselección">📋 Preselección</option>
                <option value="Selección">⭐ Selección</option>
                <option value="Entrevistado">🗣️ Entrevistado</option>
                <option value="Contratado">✅ Contratado</option>
                <option value="Sin perfil">⚪ Sin perfil</option>
            </select>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="candidate-table-scroll table-responsive">
            <table id="candidate-table" class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="col-fav text-center" data-orderable="false" style="width: 48px;" title="Marcar como favorito">
                            <i class="far fa-star"></i>
                        </th>
                        <th scope="col" class="col-name text-left">Nombre Postulante</th>
                        <th scope="col" class="text-center">Edad</th>
                        <th scope="col" class="text-center">Género</th>
                        <th scope="col" class="text-center">Fecha Postulación</th>
                        <th scope="col" class="text-left" data-orderable="false" style="min-width: 220px;">Nivel Educacional</th>
                        <th scope="col" class="text-center">Nacionalidad</th>
                        <th scope="col" class="text-left">Email</th>
                        <th scope="col" class="col-phone text-center" data-orderable="false">Teléfono</th>
                        <th scope="col" class="text-center" data-orderable="false">Curriculum</th>
                        <th scope="col" class="text-center" data-orderable="false">Mensajes</th>
                        <th scope="col" class="text-center" style="min-width: 175px;">Estado Proceso</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($candidates as $candidate)
                    @if ($candidate->user)
                    <tr class="candidate-row {{ $candidate->favorite == 1 ? 'table-favorite' : '' }}" data-id="{{ $candidate->user->id }}">
                        <td class="col-fav text-center align-middle">
                            <label class="custom-control custom-checkbox m-0 d-inline-block" style="cursor: pointer;" title="Marcar / desmarcar favorito">
                                <input type="checkbox"
                                    class="custom-control-input add-favorite"
                                    name="favorite" {{ $candidate->favorite == 1 ? 'checked' : '' }} />
                                <span class="custom-control-label"></span>
                            </label>
                            <input type="hidden" name="user" value="{{ $candidate->user->id }}"/>
                            <input type="hidden" name="offer" value="{{ $offer->id }}"/>
                        </td>
                        <td class="col-name align-middle">
                            <div class="font-weight-bold">
                                <a href="{{ route('user.file', [$candidate->user->id, $offer->id]) }}" class="text-dark hover-primary" title="Ver ficha completa">
                                    {{ $candidate->user->name ?? '' }} {{ $candidate->user->surname ?? '' }}
                                </a>
                            </div>
                            <div class="small text-muted">
                                RUT: {{ $candidate->user->rut_user ?? 'No registrado' }}
                            </div>
                        </td>
                        <td class="text-center align-middle font-weight-bold">
                            {{ $candidate->user->age ? $candidate->user->age . ' años' : '-' }}
                        </td>
                        <td class="text-center align-middle">
                            {{ $candidate->user->gender ?: '-' }}
                        </td>
                        <td class="text-center align-middle text-muted small">
                            {{ $candidate->date ?: ($candidate->created_at ? $candidate->created_at->format('d-m-Y') : '-') }}
                        </td>
                        <td class="align-middle">
                            @if($candidate->user->userEducation && $candidate->user->userEducation->count() > 0)
                                <ul class="education-list mb-0 pl-3 small">
                                    @foreach($candidate->user->userEducation as $education)
                                        <li><strong>{{ $education->title }}</strong> ({{ $education->condition }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted small">Sin información</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            {{ $candidate->user->nacionality ?: '-' }}
                        </td>
                        <td class="align-middle">
                            @if (!empty($candidate->user->email))
                                <a href="mailto:{{ $candidate->user->email }}" class="text-muted small" title="Enviar correo">
                                    <i class="far fa-envelope mr-1 text-primary"></i>{{ $candidate->user->email }}
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="col-phone text-center align-middle">
                            @php
                                $phones = array_filter(array_map('trim', preg_split(
                                    '/\s*[\/,;]\s*|\s+-\s+|\s{3,}|(?<=\d{8})\s*-\s*(?=[+(\d])/',
                                    $candidate->user->userMeta->phone ?? ''
                                )));
                            @endphp
                            @forelse($phones as $phone)
                                <a href="tel:{{ $phone }}" class="d-block small text-dark" title="Llamar">
                                    <i class="fas fa-phone-alt text-primary mr-1" style="font-size: 0.72rem;"></i>{{ $phone }}
                                </a>
                            @empty
                                <span class="text-muted small">-</span>
                            @endforelse
                        </td>
                        <td class="text-center align-middle">
                            @if (!empty(optional($candidate->user->userMeta)->path))
                                <a href="{{ route('user.resume', [$candidate->user->id, $offer->id]) }}" target="_blank" class="btn btn-sm btn-outline-danger font-weight-bold py-1 px-2" title="Ver / Descargar CV en PDF">
                                    <i class="fas fa-file-pdf mr-1"></i> Ver CV
                                </a>
                            @else
                                <span class="badge badge-light border text-muted">Sin CV</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @php
                                $lastMessage = \App\Models\Message::where([
                                    'user_id' => $candidate->user->id,
                                    'offer_id' => $offer->id
                                ])->where('sender_id', '!=', session()->get('id'))->latest()->first();
                            @endphp
                            <button type="button" class="btn btn-sm btn-outline-info py-1 px-2 submitSendMessage"
                                data-user="{{ $candidate->user->id }}"
                                data-offer="{{ $offer->id }}"
                                title="Enviar mensaje directo">
                                <i class="far fa-comment-alt"></i>
                                @if (isset($lastMessage->status) && $lastMessage->status == 3)
                                    <span class="badge badge-success ml-1">1</span>
                                @endif
                            </button>
                        </td>
                        <td class="text-center align-middle" style="min-width: 175px;">
                            <input type="hidden" name="statusValue" value="{{ optional($candidate->candidateStatus)->status ?: 'Sin estado' }}" />
                            @php
                                $curStatus = optional($candidate->candidateStatus)->status;
                                $statusClass = match($curStatus) {
                                    'Revisar' => 'border-info text-info',
                                    'Preselección' => 'border-primary text-primary',
                                    'Selección' => 'border-primary text-primary font-weight-bold',
                                    'Entrevistado' => 'border-warning text-dark font-weight-bold',
                                    'Contratado' => 'border-success text-success font-weight-bold',
                                    'Sin perfil' => 'border-secondary text-muted',
                                    default => 'border-secondary text-dark'
                                };
                            @endphp
                            <select class="custom-select custom-select-sm select-status {{ $statusClass }}"
                                data-candidate-id="{{ $candidate->user->id }}"
                                data-candidate-name="{{ $candidate->user->name }} {{ $candidate->user->surname }}"
                                data-offer-id="{{ $offer->id }}"
                                style="border-radius: 20px; font-size: 0.8rem; cursor: pointer;">
                                <option value="" {{ empty($curStatus) ? 'selected' : '' }}>Seleccione estatus</option>
                                <option value="Revisar" {{ $curStatus == 'Revisar' ? 'selected' : '' }}>🔍 Revisar</option>
                                <option value="Preselección" {{ $curStatus == 'Preselección' ? 'selected' : '' }}>📋 Preselección</option>
                                <option value="Selección" {{ $curStatus == 'Selección' ? 'selected' : '' }}>⭐ Selección</option>
                                <option value="Entrevistado" {{ $curStatus == 'Entrevistado' ? 'selected' : '' }}>🗣️ Entrevistado</option>
                                <option value="Contratado" {{ $curStatus == 'Contratado' ? 'selected' : '' }}>✅ Contratado</option>
                                <option value="Sin perfil" {{ $curStatus == 'Sin perfil' ? 'selected' : '' }}>⚪ Sin perfil</option>
                            </select>
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="12" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-3x mb-3 text-muted"></i>
                            <h5>Aún no hay candidatos postulados para esta oferta.</h5>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
