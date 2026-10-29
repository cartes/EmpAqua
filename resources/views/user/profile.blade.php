@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('title', 'Perfil de Usuario')

@php
    $meta = $user->userMeta;
    $checklist = [
        ['label' => 'Datos personales', 'anchor' => 'datos-personales', 'done' => filled($meta?->phone) && filled($meta?->address) && filled($meta?->comune) && filled($user->birthday)],
        ['label' => 'Objetivos laborales', 'anchor' => 'datos-personales', 'done' => filled($meta?->objectives)],
        ['label' => 'Experiencia laboral', 'anchor' => 'experiencia', 'done' => count($experiences ?? []) > 0],
        ['label' => 'Formación académica', 'anchor' => 'educacion', 'done' => count($education ?? []) > 0],
        ['label' => 'Habilidades', 'anchor' => 'habilidades', 'done' => $user->userSkills->count() > 0],
        ['label' => 'Referencias', 'anchor' => 'referencias', 'done' => $user->userReferences->count() > 0],
        ['label' => 'Currículum adjunto', 'anchor' => 'documentos', 'done' => filled($meta?->path)],
    ];
    $doneCount = collect($checklist)->where('done', true)->count();
    $progress = (int) round($doneCount / count($checklist) * 100);
@endphp

@push('styles')
    @include('partials.profile.styles')
@endpush

@section('content')

    <div class="container mt-4 profile-page">
        @if(session()->has('message'))
            @php($message = session('message')[0] == 'error' ? 'danger' : session('message')[0] )
            <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-{{ $message }} text-white">
                        <strong class="mr-auto">Notificación</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ session('message')[1] }}
                    </div>
                </div>
            </div>
        @endif

        <div class="profile-hero mb-4">
            <div class="avatar">
                @if ($user->path)
                    <img src="{{ $user->profileAttachment() }}" alt="Foto de perfil">
                @else
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1) . mb_substr($user->surname, 0, 1)) }}
                @endif
            </div>
            <div>
                <h1>{{ $user->name }} {{ $user->surname }}</h1>
                <div class="meta">
                    <i class="far fa-envelope mr-1"></i>{{ $user->email }}
                    @if($meta?->comune)
                        <span class="mx-2">·</span><i class="fas fa-map-marker-alt mr-1"></i>{{ $meta->comune }}
                    @endif
                </div>
                @unless($user->path)
                    <div class="photo-tip">
                        <i class="fas fa-camera mr-1"></i>Un perfil con foto es mejor.
                        <a href="#datos-personales">Sube tu imagen</a>
                    </div>
                @endunless
            </div>
            <a href="{{ route('profile.view') }}" class="btn btn-light btn-cv">
                <i class="far fa-eye mr-1"></i> Ver mi CV
            </a>
        </div>

        <div class="row">
            <aside class="col-lg-3">
                <nav class="profile-nav">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <strong>Tu perfil</strong>
                                <span class="text-muted small">{{ $progress }}%</span>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <ul>
                                @foreach($checklist as $item)
                                    <li class="{{ $item['done'] ? 'done' : '' }}">
                                        <a href="#{{ $item['anchor'] }}">
                                            <span class="dot"><i class="{{ $item['done'] ? 'fas fa-check-circle' : 'far fa-circle' }}"></i></span>
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>
            </aside>

            <div class="col-lg-9">
                @include('partials.profile.personal')
                @include('partials.profile.experience')
                @include('partials.profile.education')
                @include('partials.profile.skills')
                @include('partials.profile.references')
                @include('partials.profile.resume')
                {{--@include('partials.profile.contact')--}}
            </div>
        </div>
        {{--@include('partials.profile.languages')--}}

    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.toast').toast('show');
    });
</script>

<script>
    jQuery(document).ready(function($) {
        $(".badge-skills").click(function (event) {

            event.preventDefault();
            if (confirm('¿Desea borrar esta habilidad de su listado?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseSkill',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            }
        })
        $(".erase-experience").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta experiencia laboral?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseExp',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            }
        });

        $(".erase-education").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta información académica?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseEducation',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            };
        });

        $(".erase-reference").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta referencia?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseReference',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            };
        });
    })
</script>
@endpush
