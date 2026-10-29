@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('title', 'Mis Postulaciones')

@push('styles')
    @include('partials.profile.styles')
    <style>
        .post-item { display: flex; gap: 1rem; align-items: center; padding: 1rem 0; border-bottom: 1px solid #f0f0f0; }
        .post-item:last-child { border-bottom: 0; }
        .post-item .main { flex: 1; min-width: 0; }
        .post-item h3 { font-size: 1.05rem; margin: 0 0 .15rem; font-weight: 700; }
        .post-item h3 a { color: #323D7E; }
        .post-item .sub { color: #6B6B6B; font-size: .85rem; }
        .post-item .side { flex: none; text-align: right; }
        .status-pill { display: inline-block; padding: .25rem .7rem; border-radius: 2rem; font-size: .78rem; font-weight: 600; background: #eef0f4; color: #555; }
        .status-pill--seen { background: #e8f5fa; color: #1a6b8a; }
        .status-pill--interview { background: #e6f6ea; color: #1e7a3a; }
        .btn-msg { position: relative; background: none; border: 0; color: #0099CC; font-size: 1.25rem; padding: .25rem .5rem; }
        .btn-msg .badge { position: absolute; top: -2px; right: -2px; }
        @media (max-width: 575px) { .post-item { flex-wrap: wrap; } .post-item .side { text-align: left; width: 100%; } }
    </style>
@endpush

@section('content')
    <div class="container mt-4 profile-page">
        @if(session()->has('message'))
            <div class="alert alert-{{ session('message')[0] == 'error' ? 'danger' : session('message')[0] }}" role="alert">
                {{ session('message')[1] }}
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
                <h1>Hola {{ $user->name }}, bienvenido a Empleos MCH</h1>
                <div class="meta">Gestiona tu información, accede a las alertas de empleo y revisa tus postulaciones.</div>
                @unless($user->path)
                    <div class="photo-tip">
                        <i class="fas fa-camera mr-1"></i>Un perfil con foto es mejor.
                        <a href="{{ route('profile') }}#datos-personales">Sube tu imagen</a>
                    </div>
                @endunless
            </div>
            <a href="{{ route('profile') }}" class="btn btn-light btn-cv"><i class="fas fa-pen mr-1"></i> Editar perfil</a>
        </div>

        <section class="card p-card">
            <div class="card-header">
                <h2><i class="fas fa-paper-plane"></i>Mis postulaciones</h2>
                <span class="badge badge-light">{{ $candidates->count() }}</span>
            </div>
            <div class="card-body">
                @forelse($candidates as $candidate)
                    @php
                        $meta = \App\Models\BusinessMeta::where('id_business', $candidate->id_business)->first();
                        $status = $candidate->pivot->status;
                        [$statusLabel, $statusClass] = match ((int) $status) {
                            1 => ['Sin cambio', ''],
                            2 => ['CV visto', 'status-pill--seen'],
                            3 => ['Entrevista agendada', 'status-pill--interview'],
                            default => ['Sin información', ''],
                        };
                        $lastMessage = \App\Models\Message::where([
                            'user_id' => $candidate->pivot->id_user,
                            'offer_id' => $candidate->pivot->id_offer,
                        ])->latest()->first();
                    @endphp
                    <div class="post-item">
                        <div class="main">
                            <h3><a href="{{ route('offer.show', $candidate->slug) }}">{{ $candidate->title }}</a></h3>
                            <div class="sub">
                                @if($meta?->confidential)
                                    {{ $meta->fantasy_name }}
                                @else
                                    Prestigiosa Empresa
                                @endif
                                @if($meta?->comune)
                                    <span class="mx-1">·</span><i class="fas fa-map-marker-alt mr-1"></i>{{ $meta->comune }}
                                @endif
                            </div>
                            <div class="sub">
                                <i class="far fa-calendar-alt mr-1"></i>Postulaste el {{ \Carbon\Carbon::parse($candidate->pivot->created_at ?? $candidate->created_at)->translatedFormat('d \d\e F \d\e Y') }}
                            </div>
                        </div>
                        <div class="side">
                            <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                            @if($status == 1)
                                <span class="badge badge-success ml-1">Leído</span>
                            @endif
                            @if($lastMessage)
                                <form class="sendMessage d-inline" method="post">
                                    <input type="hidden" name="user" value="{{ $candidate->pivot->id_user }}"/>
                                    <input type="hidden" name="offer" value="{{ $candidate->pivot->id_offer }}"/>
                                    <input type="hidden" name="replyTo" value="{{ $lastMessage->id }}"/>
                                    <button type="submit" class="btn-msg submitSendMessage" title="Ver mensajes">
                                        <i class="far fa-comment-alt"></i>
                                        @if($lastMessage->status < 2)
                                            <span class="badge badge-pill badge-success">1</span>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-empty py-4">
                        <i class="far fa-folder-open fa-2x mb-2 d-block"></i>
                        No has postulado a ninguna oferta.
                        <div class="mt-3"><a href="{{ route('/') }}" class="btn btn-primary btn-sm">Ver ofertas de empleo</a></div>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    @include('partials.modals.reply')
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('.submitSendMessage').click(function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const user = form.find("input[name='user']").val();
                const offer = form.find("input[name='offer']").val();
                const replyTo = form.find("input[name='replyTo']").val();

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
                        'offer': offer,
                        'replyTo': replyTo,
                    },
                    success: function (resp) {
                        var titleModal = "Mensaje a " + resp.user.name + " " + resp.user.surname;
                        $("#titleModal").empty().append(titleModal);

                        $("#messageModal").modal("show");
                        $("#user_id_input").val(user);
                        $("#offer_id_input").val(offer);
                        $('#reply_to_input').val(replyTo);
                        $("#messages_log").empty();
                        let messages = resp.messages;
                        for (var i = 0; i < messages.length; i++) {
                            let tag;
                            if (resp.messages[i].sender_id == resp.reader) {
                                tag = "<li class='clearfix'><p class='message message-send float-left alert-success d-block'>";
                            } else {
                                tag = "<li class='clearfix'><p class='message message-reply float-right alert-secondary'>";
                            }
                            var html = tag + messages[i].content + "<small class='message-time'>" + messages[i].created_at + "</small>" + "</p></li>";
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
