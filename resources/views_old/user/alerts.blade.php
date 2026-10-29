@extends('layout.app')

@section('content')
    @if(session()->get('role') == 'user')
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
                    <p>Gestiona tu información, accede a las alertas de empleo y revisa tus postulaciones.</p>
                </div>

                {{-- Perfil del usuario --}}
                @include('partials.user.sideprofile')

                {{-- Listado de alertas de ofertas de trabajo, segun las busquedas del usuario--}}
                <div class="col-md-8">
                    <div class="row">
                        @if (!$alerts->isEmpty())
                            <div class="col-12">
                                <h5>Mis alertas de empleo</h5>
                                @foreach($alerts as $alert)
                                    <div class="row mb-3 job-alert-file">
                                        <div class="col-12 p-3 border-left border-orange">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    {{ \Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}
                                                </div>
                                                <div class="col-md-8">
                                                    <h4>
                                                        <a href="{{ route('offer.show', $alert->slug) }}">{{ $alert->title }}</a>
                                                    </h4>
                                                    <p class="m-0 p-0">{{ $alert->businessMeta->business_name }}</p>
                                                    <p class="m-0 p-0">{{ $alert->businessMeta->comune }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (!$postulated->isEmpty())
                            <div class="col-12">
                                <h5>Tus postulaciones</h5>
                                <table class="table-post table table-borderless">
                                    <thead>
                                    <tr>
                                        <th class="text-left">Ofertas</th>
                                        <th class="text-center">fecha de postulación</th>
                                        <th class="text-center">estado de la postulación</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($postulated as $post)
                                        <tr>
                                            <td>
                                                <p class="m-0">
                                                    <a href="{{ route("offer.show", $post->slug) }}">
                                                        <strong>{{ $post->title }}</strong>
                                                    </a>
                                                </p>
                                                <p class="m-0">{{ $post->fantasy_name }}</p>
                                                <p class="m-0">{{ $post->comune }}</p>
                                            </td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($post->created_at)->format("d \\d\\e F \\d\\e Y") }}
                                            </td>
                                            <td class="text-center">
                                                {{ $post->status['text'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
