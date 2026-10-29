@extends('layout.app')

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12 mt-4 mb-3">
                <h4 class="text-left">Hola {{ $user->name }}, bienvenido a Aqua Empleos</h4>
                <p>Acá puedes ver las ofertas que marcaste como Favoritos.</p>
            </div>

            {{-- Perfil del usuario --}}
            @include('partials.user.sideprofile')


            @if($user->name)
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table my-4">
                                <thead>
                                <tr>
                                    <th scope="col"><p class="m-0 text-center">Oferta</p></th>
                                    <th scope="col"><p class="m-0 text-center">Fecha de Postulación</p></th>
                                    <th scope="col"><p class="m-0 text-center">Estado de la publicación</p></th>
                                    <th scope="col">Mensajes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($candidates as $candidate)
                                    <tr>
                                        <td>
                                            <a href="{{ route("offer.show", $candidate->slug) }}">
                                                <p class="m-0 text-left">
                                                    {{ $candidate->title }}
                                                </p>
                                            </a>
                                            <p class="m-0 text-left">
                                                @php( $meta = \App\Models\BusinessMeta::where('id_business', '=', $candidate->id_business)->first() )
                                                @if ( $meta->confidential )
                                                    {{ $meta->fantasy_name }}
                                                @else
                                                    <span>Prestigiosa Empresa</span>
                                                @endif
                                            </p>
                                            <p class="m-0 text-left">
                                                {{ $meta->comune }}
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="m-0 text-center">
                                                {{ \Carbon\Carbon::parse($candidate->created_at)->format("d \\d\\e F \\d\\e Y") }}
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="m-0 text-center">
                                                @switch($candidate->pivot->status)
                                                    @case (1)
                                                        Sin Cambio
                                                        @break
                                                    @case (2)
                                                        CV Visto
                                                        @break
                                                    @case (3)
                                                        Entrevista agendada
                                                        @break
                                                    @default
                                                        Sin información
                                                @endswitch
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <form class="sendMessage" method="post">
                                                @php(
                                                $lastMessage = \App\Models\Message::where([
                                                    'user_id' => $candidate->pivot->id_user,
                                                    'offer_id' => $candidate->pivot->id_offer])
                                                    ->latest()
                                                    ->first()
                                                )

                                                @if ($lastMessage)
                                                    <input type="hidden" name="user"
                                                           value="{{ $candidate->pivot->id_user }}"/>
                                                    <input type="hidden" name="offer"
                                                           value="{{ $candidate->pivot->id_offer }}"/>
                                                    <input type="hidden" name="replyTo"
                                                           value="{{ $lastMessage->id ?? '' }}"/>
                                                    <button type="submit" class="submitSendMessage"
                                                            style="background: none; padding: 0; border: none;">
                                                        <i style="font-size: 20px;" class="far fa-comment-alt"></i>
                                                        {!! $lastMessage->status < 2 ? "<span class='badge badge-pill badge-success'>1</span>" : ""  !!}
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No has postulado a ninguna oferta</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        @endif
    </div>
    @include('partials.modals.reply')


@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('.submitSendMessage').click(function (e) {
                e.preventDefault();
                var user = $("input[name='user']").val();
                var offer = $("input[name='offer']").val();
                var replyTo = $("input[name='replyTo']").val();

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
                        console.log(resp);
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
