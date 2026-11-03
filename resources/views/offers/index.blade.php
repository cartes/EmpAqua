@extends('layout.app')
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

        .subscription-card {
            border-width: 2px;
            border-radius: 12px;
        }

        .subscription-days {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            margin: .25rem 0;
        }

        .offers-file {
            overflow-x: auto;
        }

        .table-offers {
            border-radius: 8px;
            overflow: hidden;
        }

        .table-offers thead {
            background-color: #0D4A96;
            color: #fff;
        }

        .table-offers th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: .75rem;
            letter-spacing: .5px;
            border: none;
        }

        .table-offers td {
            white-space: nowrap;
            vertical-align: middle;
            padding: .65rem .5rem;
            font-size: .82rem;
        }

        .table-offers td:nth-child(3) {
            white-space: normal;
            min-width: 160px;
        }

        .table-offers form {
            display: inline-block;
            margin: 0;
        }

        .table-offers td.ofertas-activas .row {
            flex-wrap: nowrap;
            margin: 0;
        }

        .table-offers td.ofertas-activas [class^="col-"] {
            flex: 0 0 auto;
            width: auto;
            padding: 0 .25rem;
        }

        .badge-status-active {
            background-color: #eafaf1;
            color: #28a745;
            font-weight: 600;
            padding: .35rem .6rem;
            border-radius: 20px;
            font-size: .75rem;
        }

        .badge-status-hidden {
            background-color: #fff3cd;
            color: #856404;
            font-weight: 600;
            padding: .35rem .6rem;
            border-radius: 20px;
            font-size: .75rem;
        }
    </style>
@endpush

@section('content')
    <div class="container container-admin mt-4 mb-5">

        {{-- Modals --}}
        @include('partials.modals.republishOffer')

        {{-- Hero / Zona de información de administración de empresa --}}
        <div class="card hero-admin-card mb-4 border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 text-center mb-3 mb-md-0">
                        <div class="container-logo-img mx-auto mb-2"
                            style="width: 96px; height: 96px; border: 3px solid #D88F32; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #fff;">
                            @if (optional($business->business_meta)->path)
                                <img class="logo-img" style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                    src="{{ $business->business_meta->pathAttachment() }}"
                                    alt="{{ $business->business_meta->business_name ?? 'Logo' }}">
                            @else
                                <i class="fas fa-building fa-2x text-muted"></i>
                            @endif
                        </div>
                        <h4 class="h5 font-weight-bold text-uppercase mb-1" style="color: #0D4A96;">
                            {{ optional($business->business_meta)->fantasy_name ?: (optional($business->business_meta)->business_name ?: 'Mi Empresa') }}
                        </h4>
                        <div class="mb-2">
                            <span class="badge badge-pill badge-primary px-3 py-1 font-weight-bold"
                                style="background-color: #0D4A96;">
                                Plan
                                {{ $role ?: (session()->get('role_id') ? 'Membresía ' . session()->get('role_id') : 'Empresa') }}
                            </span>
                        </div>
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('business.profile') }}">
                            <i class="fas fa-user-edit mr-1"></i> Actualizar mi perfil
                        </a>
                    </div>

                    <div class="col-lg-5 col-md-4 border-left-md pl-lg-4 mb-3 mb-md-0">
                        <div class="mb-2">
                            <h6 class="font-weight-bold text-dark mb-1">
                                <i class="fas fa-user-circle text-primary mr-1"></i> Información de contacto
                            </h6>
                            <p class="py-0 my-0 small text-muted">
                                <strong>Nombre:</strong> {{ $business->firstname }} {{ $business->surname }}
                            </p>
                            <p class="py-0 my-0 small text-muted">
                                <strong>Email:</strong> {{ $business->email_user }}
                            </p>
                            <p class="pt-0 my-0 small text-muted">
                                <strong>Teléfono:</strong> {{ $business->phone_user ?: 'No registrado' }}
                            </p>
                        </div>
                        <hr class="my-2">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1">
                                <i class="fas fa-building text-primary mr-1"></i> Información de empresa
                            </h6>
                            <p class="py-0 my-0 small text-muted">
                                <strong>Email:</strong>
                                {{ optional($business->business_meta)->email ?: $business->email_user }}
                            </p>
                            <p class="pt-0 my-0 small text-muted">
                                <strong>Teléfono:</strong>
                                {{ optional($business->business_meta)->phone ?: ($business->phone_user ?: 'No registrado') }}
                            </p>
                            <p class="pt-0 my-0 small text-muted">
                                <strong>Rubro:</strong> {{ optional($business->business_meta)->activity ?: 'General' }}
                            </p>
                            <p class="pt-0 my-0 small text-muted">
                                <strong>Dirección:</strong>
                                {{ optional($business->business_meta)->address ?: 'No configurada' }}
                                @if (optional($business->business_meta)->comune)
                                    , {{ $business->business_meta->comune }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 text-center text-md-right">
                        @if (session()->has('exp_role'))
                            @php
                                $days = (int) session('exp_role');
                                $tone = $days <= 5 ? 'danger' : ($days <= 15 ? 'warning' : 'success');
                            @endphp
                            <div class="card border-{{ $tone }} subscription-card shadow-sm mb-3 text-center mx-auto ml-md-auto"
                                style="max-width: 240px;">
                                <div class="card-body p-3">
                                    <div class="small text-uppercase text-muted font-weight-bold">Tu suscripción vence en
                                    </div>
                                    <div class="subscription-days text-{{ $tone }}">{{ $days }}</div>
                                    <div class="font-weight-bold small text-muted">
                                        {{ $days === 1 ? 'día restante' : 'días restantes' }}</div>
                                    @if ($days <= 15)
                                        <a href="{{ route('prices') }}"
                                            class="btn btn-xs btn-{{ $tone }} mt-2 px-3 py-1">Renovar
                                            suscripción</a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('post.create') }}"
                            class="btn btn-lg btn-warning text-white font-weight-bold shadow px-4 py-3 d-inline-block"
                            style="background-color: #F08F01; border-color: #F08F01; border-radius: 8px;">
                            <i class="fas fa-plus-circle mr-2 fa-lg align-middle"></i> Publicar Nueva Oferta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección de Avisos Destacados & Ofertas Activas --}}
        <div class="row align-items-center mb-3 mt-4">
            <div class="col-12">
                @if (session()->has('ads') && session()->get('role_id') != '90')
                    <p class="mb-1">
                        Te quedan <span id="featured"
                            style="color: #D88F32; font-weight: 700; font-size: 1.1rem;">{{ session()->get('ads') }}</span>
                        avisos destacados
                    </p>
                @else
                    <p class="mb-1 text-muted">Tu membresía no tiene avisos destacados</p>
                @endif
                <h5 class="p-0 m-0 font-weight-bold" style="color: #0D4A96;">Ofertas activas</h5>
            </div>
        </div>

        @if ($offers->count() > 0)
            <div class="card border-0 shadow-sm mb-5" style="border-radius: 8px; overflow: hidden;">
                <div class="card-body p-0 offers-file">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <table class="table-offers table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 70px;">Destacado</th>
                                <th scope="col" class="text-center" style="width: 50px;">ID</th>
                                <th scope="col" class="text-left">Nombre de la oferta</th>
                                <th scope="col" class="text-center">Visualizaciones</th>
                                <th scope="col" class="text-center">Candidatos</th>
                                <th scope="col" class="text-center">Estatus</th>
                                <th scope="col" class="text-center">Fecha inicio</th>
                                <th scope="col" class="text-center">Fecha termino</th>
                                <th scope="col" class="text-center" style="width: 40px;">Editar</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                if (session()->get('role_id') == '90' || is_null(session()->get('role_id'))) {
                                    $i = 0;
                                } else {
                                    $i = 1;
                                }
                            @endphp
                            @foreach ($offers as $of)
                                <tr @if ($of->published == '0') class="table-warning" @endif
                                    @php
if(session()->get('role_id') == '90' || is_null(session()->get('role_id'))) {
                                        if ($i > 0) {
                                            echo 'class="text-muted" style="opacity: 0.6;"';
                                        }
                                    } @endphp>
                                    <td class="text-center align-middle">
                                        @if ($of->published == '1')
                                            @if (session()->get('role_id') != '90' || is_null(session()->get('role_id')))
                                                <input type="checkbox" class="featured"
                                                    {{ $of->featured === 1 ? 'checked="checked"' : '' }} />
                                                <input type="hidden" name="id" value="{{ $of->id }}" />
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center align-middle font-weight-bold text-muted">
                                        {{ $of->id }}
                                    </td>
                                    <td class="align-middle">
                                        @if (session()->get('role_id') == '90' || is_null(session()->get('role_id')))
                                            @if ($i > 0)
                                                <span class="font-weight-bold text-dark">{{ $of->title }}</span>
                                            @else
                                                <a class="font-weight-bold text-dark"
                                                    href="{{ route('offer.detail', $of->slug) }}">
                                                    {{ $of->title }}
                                                </a>
                                            @endif
                                        @else
                                            <a class="font-weight-bold text-dark"
                                                href="{{ route('offer.detail', $of->slug) }}">
                                                {{ $of->title }}
                                            </a>
                                        @endif
                                        <div class="small">
                                            <a href="{{ route('offer.show', $of->slug) }}" target="_blank"
                                                class="text-muted">
                                                <i class="fas fa-external-link-alt mr-1"></i> Ver en portal
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-light px-2 py-1">{{ $of->visit ?? '0' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($of->candidates_count > 0)
                                            <a href="{{ route('offer.candidates', $of->slug) }}"
                                                class="btn btn-sm btn-outline-success font-weight-bold py-1 px-2">
                                                <i class="fas fa-users mr-1"></i> {{ $of->candidates_count }}
                                            </a>
                                        @else
                                            <span class="text-muted small">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($of->published == '1')
                                            <span class="badge-status-active">Activa</span>
                                        @else
                                            <span class="badge-status-hidden">Oculta</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        {{ $of->date }}
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        {{ $of->expiration_date }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('offer.detail', $of->slug) }}"
                                            class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td class="ofertas-activas align-middle">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                @if ($of->published == '1')
                                                    <form method="post"
                                                        action="{{ route('offer.unpublish', $of->slug) }}">
                                                        @csrf
                                                        <button class="btn btn-xs btn-outline-warning text-dark"
                                                            type="submit" title="Ocultar de la búsqueda">
                                                            <i class="far fa-eye-slash mr-1"></i> Ocultar
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="post"
                                                        action="{{ route('offer.republish', $of->slug) }}">
                                                        @csrf
                                                        <button class="btn btn-xs btn-outline-success" type="submit"
                                                            title="Mostrar en la búsqueda">
                                                            <i class="far fa-eye mr-1"></i> Mostrar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                <form method="post" action="{{ route('offer.delete', $of->slug) }}"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-xs btn-outline-danger" type="submit"
                                                        title="Eliminar oferta">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @if (session()->get('role_id') == '17')
                                                <div class="col-auto">
                                                    <a href="{{ route('offer.allcandidates', $of->slug) }}"
                                                        class="btn btn-xs btn-info" title="Biblioteca CV">
                                                        <i class="fas fa-folder-open mr-1"></i> CVs
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center mb-5">
                {{ $offers->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm p-5 text-center text-muted mb-5" style="border-radius: 8px;">
                <i class="fas fa-briefcase fa-3x mb-3 text-muted"></i>
                <h5 class="font-weight-bold">No tienes ofertas activas actualmente</h5>
                <p>Comienza a recibir postulantes publicando una oferta de trabajo en el portal.</p>
                <div class="mt-2">
                    <a href="{{ route('post.create') }}" class="btn btn-warning text-white font-weight-bold px-4 py-2"
                        style="background-color: #F08F01;">
                        <i class="fas fa-plus-circle mr-1"></i> Publicar Oferta
                    </a>
                </div>
            </div>
        @endif

        {{-- Tabla de Ofertas Cerradas / Expiradas --}}
        @if ($expired->count() > 0)
            <div class="row justify-content-between align-items-center mb-2 mt-4">
                <div class="col-md-7">
                    <h5 class="p-0 m-0 font-weight-bold text-secondary">
                        <i class="fas fa-archive mr-1"></i> Ofertas cerradas
                    </h5>
                    <small class="text-muted">Avisos finalizados. Puedes republicarlos por 30 días adicionales.</small>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px; overflow: hidden;">
                <div class="card-body p-0 offers-file">
                    <table class="table-offers table table-striped table-hover mb-0">
                        <thead style="background-color: #64748b;">
                            <tr>
                                <th scope="col" class="text-left">Nombre de la oferta</th>
                                <th scope="col" class="text-center">Visualizaciones</th>
                                <th scope="col" class="text-center">Candidatos</th>
                                <th scope="col" class="text-center">Estatus</th>
                                <th scope="col" class="text-center">Fecha inicio</th>
                                <th scope="col" class="text-center">Fecha termino</th>
                                <th scope="col" class="text-center" style="width: 50px;">Republicar</th>
                                <th scope="col" class="text-center" style="width: 50px;">Candidatos</th>
                                <th scope="col" class="text-center" style="width: 50px;">Editar</th>
                                <th scope="col" class="text-center" style="width: 50px;">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expired as $exp)
                                <tr @if ($exp->published == '0') class="table-warning" @endif>
                                    <td class="align-middle font-weight-bold">
                                        {{ $exp->title }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <span
                                            class="badge badge-light px-2 py-1">{{ $exp->views ?? ($exp->visit ?? 0) }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($exp->candidates_count > 0)
                                            <a href="{{ route('offer.candidates', $exp->slug) }}"
                                                class="btn btn-sm btn-outline-secondary font-weight-bold py-1 px-2">
                                                <i class="fas fa-users mr-1"></i> {{ $exp->candidates_count }}
                                            </a>
                                        @else
                                            <span class="text-muted small">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-secondary px-2 py-1">Vencida</span>
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        {{ $exp->date }}
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        {{ $exp->expiration_date }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm btn-outline-success btn-republish"
                                            data-link="{{ route('offer.republish', $exp->slug) }}" href="#"
                                            title="Republicar por 30 días">
                                            <i class="fas fa-history"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('offer.candidates', $exp->slug) }}"
                                            class="btn btn-sm btn-outline-info" title="Ver postulantes que quedaron">
                                            <i class="fas fa-users"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('offer.detail', $exp->slug) }}"
                                            class="btn btn-sm btn-outline-primary" title="Editar oferta">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <form method="post" action="{{ route('offer.delete', $exp->slug) }}"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit"
                                                title="Eliminar oferta">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center">
                {{ $expired->links() }}
            </div>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();

            $('.btn-republish').click(function(e) {
                e.preventDefault();
                var url = $(this).data('link');
                $('#republishOffer').modal('show');
                $('#republish-link').attr('action', url);
            });

            $('.featured').change(function(e) {
                let container = $(this).closest('td');
                let adId = container.find('[name="id"]').val();
                let _token = $('meta[name="csrf-token"]').attr('content') || $("[name='_token']").val();
                let action = e.currentTarget.checked;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                });
                $.ajax({
                    type: 'post',
                    url: "{{ route('offer.featured') }}",
                    data: {
                        id: adId,
                        feature: action
                    },
                    success: function(json) {
                        if (json.code == 200) {
                            window.location.reload();
                        }
                    },
                    error: function(json) {
                        $('.featured').prop('checked', false);
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endpush
