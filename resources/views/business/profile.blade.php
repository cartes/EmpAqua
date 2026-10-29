@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    @php($meta = $business->business_meta)

    <div class="container business-page mt-5">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Encabezado: logo + nombre --}}
                <div class="card business-card business-header mb-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="business-logo-wrap">
                            <div class="container-logo-img">
                                @if($meta)
                                    <img class="logo-img h-100 w-auto" src="{{ $meta->pathAttachment() ?? '' }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="business-header-text">
                            @if($meta)
                                <h3 class="business-fantasy-name mb-1">{{ $meta->fantasy_name ?? '' }}</h3>
                                <p class="text-muted mb-0">{{ $meta->business_name }}</p>
                            @else
                                <h3 class="business-fantasy-name mb-1">No está configurada la información de empresa</h3>
                            @endif
                        </div>
                        <a href="{{ route('business.edit') }}" class="btn btn-outline-primary btn-sm ml-auto text-nowrap">
                            <i class="fas fa-pencil-alt mr-1"></i> Editar
                        </a>
                    </div>
                </div>

                {{-- Datos de la empresa --}}
                <div class="card business-card mb-4">
                    <div class="card-body">
                        <h4 class="business-subtitle">Datos de la empresa</h4>
                        <dl class="business-details">
                            <dt>RUT</dt>
                            <dd>{{ $meta->rut_business ?? '—' }}</dd>
                            <dt>Razón social</dt>
                            <dd>{{ $meta->business_name ?? '—' }}</dd>
                            <dt>Giro</dt>
                            <dd>{{ $meta->activity ?? '—' }}</dd>
                            <dt>Dirección comercial</dt>
                            <dd>{{ $meta->address ?? '—' }}</dd>
                            <dt>Comuna</dt>
                            <dd>{{ $meta->comune ?? '—' }}</dd>
                            <dt>Ciudad</dt>
                            <dd>{{ $meta->city ?? '—' }}</dd>
                            <dt>Región</dt>
                            <dd>{{ $meta->state ?? '—' }}</dd>
                            <dt>Email</dt>
                            <dd>{{ $meta->email ?? '—' }}</dd>
                            <dt>Teléfono</dt>
                            <dd>{{ $meta->phone ?? '—' }}</dd>
                            <dt>Cantidad de empleados</dt>
                            <dd>{{ $meta->employees ?? '—' }}</dd>
                        </dl>
                    </div>
                </div>

                {{-- Contacto --}}
                <div class="card business-card mb-4">
                    <div class="card-body">
                        <h4 class="business-subtitle">Información de contacto</h4>
                        <dl class="business-details">
                            <dt>Nombre</dt>
                            <dd>{{ trim($business->firstname . ' ' . $business->surname) ?: '—' }}</dd>
                            <dt>Email</dt>
                            <dd>{{ $business->email_user ?: '—' }}</dd>
                            <dt>Teléfono</dt>
                            <dd>{{ $business->phone_user ?: '—' }}</dd>
                            <dt>Cargo</dt>
                            <dd>{{ $business->position ?: '—' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="shadow-sm card-side-profile card business-card w-100 mb-4">
                    <div class="card-body py-3 px-4">
                        <div class="applications-badge">
                            <span class="applications-count">{{ $candidates }}</span>
                            <h3>Postulaciones los últimos 7 días</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .business-page .business-card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(50, 61, 126, .12);
        }
        .business-page .business-header .card-body { padding: 1.5rem; }
        .business-page .business-logo-wrap { margin-right: 1.25rem; flex: 0 0 auto; }
        .business-page .container-logo-img { margin: 0; background: #fff; }
        .business-page .business-fantasy-name {
            color: #323D7E;
            font-weight: 800;
            font-size: 1.6rem;
        }
        .business-page .business-subtitle {
            color: #323D7E;
            font-weight: 700;
            font-size: 1.1rem;
            padding-bottom: .6rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #f0e3cf;
        }
        .business-page .business-details {
            display: grid;
            grid-template-columns: minmax(150px, 220px) 1fr;
            gap: .65rem 1.25rem;
            margin: 0;
        }
        .business-page .business-details dt {
            color: #6c757d;
            font-weight: 600;
        }
        .business-page .business-details dd {
            margin: 0;
            color: #212529;
            overflow-wrap: anywhere;
        }
        @media (max-width: 575.98px) {
            .business-page .business-details { grid-template-columns: 1fr; gap: 0; }
            .business-page .business-details dt { margin-top: .75rem; }
            .business-page .business-header .card-body { flex-wrap: wrap; }
            .business-page .business-header .btn { margin: 1rem 0 0 0 !important; }
        }

        .card-side-profile .applications-badge {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .card-side-profile .applications-count {
            flex: 0 0 auto;
            min-width: 64px;
            height: 64px;
            padding: 0 0.6rem;
            border-radius: 32px;
            background: #fdf1e0;
            color: #d88f32;
            font-size: 1.9rem;
            font-weight: 900;
            line-height: 64px;
            text-align: center;
        }
        .card-side-profile .applications-badge h3 {
            margin: 0;
            font-size: 1.1rem;
            line-height: 1.3;
        }
    </style>
@endpush
