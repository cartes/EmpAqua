@extends('layout.home')

@section('content')

    <div class="container">
        @if(null!==session('message'))
            <div class="row justify-content-center mt-4">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include('partials.modals.loginHome')
        @include('partials.modals.loginBusiness')
        @include("partials.modals.register")
        @include('partials.modals.registerBusiness')
        @include("partials.ads.intersticial")

    </div>

    <section id="content-container" class="container-fluid p-0">
        <div id="row-search" class="row pt-4 px-3 px-sm-0">
            <div class="col-12 col-lg-8 mx-auto">
                <h1 class="text-center">Busca tu empleo aquí</h1>
                <form class="form-inline my-4 my-lg-0" method="post" action="{{ route('search') }}">
                    <div class="input-group mx-auto">
                        <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                        <input class="form-control" type="text" name="query" placeholder="Buscar ofertas de empleo."
                               aria-label="Search">
                        <button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div class="row-buttons row mt-2 mb-4">
                    <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-md-0">
                        <a href="{{ route('offer.list') }}" class="btn btn-primary btn-block">Todas las ofertas</a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 mb-md-0">
                        <a href="{{route('offer.featured')}}" class="btn btn-primary btn-block">Ofertas destacadas</a>
                    </div>
                    <div class="col-12 col-md-3 d-none d-lg-block">
                        @if(session()->get('id'))
                            <a href="{{route('post.create')}}" class="btn btn-secondary btn-block">Publicar Oferta</a>
                        @else
                            <a href="#" data-toggle="modal" data-target="#loginBusiness" class="btn btn-secondary btn-block">Publicar Oferta</a>
                        @endif
                    </div>
                    <div class="col-12 col-md-3 d-none d-lg-block">
                        @if(session()->get('id'))
                            <a href="{{route('profile')}}" class="btn btn-secondary btn-block">Crea tu Currículum</a>
                        @else
                            <a href="#" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#loginUserModal">Crea tu Currículum</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="background: #E4E4E4">
            <div class="col-12 d-none d-md-block text-center py-md-3">
                <!-- /18588809/EAHA1_N -->
                <div id='div-gpt-ad-1666795994590-0' style='min-width: 940px; min-height: 90px;'>
                    <script>
                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1666795994590-0'); });
                    </script>
                </div>
            </div>
        </div>

        <div id="row-buttons" class="container-fluid">
            <div class="container-fluid p-0">
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-left superior position-absolute" style="left: 101%">
                        <!-- /18588809/EASKHIS -->
                        <div id='div-gpt-ad-1620410792403-0' style='min-width: 120px; min-height: 600px;'>
                            <script>
                                googletag.cmd.push(function () {
                                    googletag.display('div-gpt-ad-1620410792403-0');
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-left inferior position-absolute" style="left: 101%">
                        <!-- /18588809/EASKHII -->
                        <div id='div-gpt-ad-1620410914897-0' style='min-width: 120px; min-height: 600px;'>
                            <script>
                                googletag.cmd.push(function () {
                                    googletag.display('div-gpt-ad-1620410914897-0');
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-right superior position-absolute" style="left: -18%">
                        <!-- /18588809/EASKHDS -->
                        
                        <div class="position-absolute" id='div-gpt-ad-1620410987480-0'
                             style='min-width: 120px; min-height: 600px;'>
                            <script>
                                googletag.cmd.push(function () {
                                    googletag.display('div-gpt-ad-1620410987480-0');
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-right inferior position-absolute" style="left: -18%">
                        <!-- /18588809/EASKHDI -->
                        <div id='div-gpt-ad-1620411032581-0'
                             style='min-width: 120px; min-height: 600px;'>
                            <script>
                                googletag.cmd.push(function () {
                                    googletag.display('div-gpt-ad-1620411032581-0');
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row row-ofertas pt-4 mt-0 d-none d-sm-block">
                    <div class="col-md-12 mx-auto">
                        <div class="d-flex d-flex-title">
                            <h2 class="d-inline-flex">¿Por qué publicar con nosotros?</h2>
                            <div class="border-fill"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mx-auto">
                        <p class="p-0">¡Somos parte de B2B Media Group así que muchos ya nos conocen! Ahora, estamos avanzando hacia un portal de empleos más completo para que los procesos de reclutamiento sean mucho más eficientes y los postulantes tengan más oportunidades laborales.</p>
                    </div>
                    <div class="col-md-12 mx-auto">
                        <div class="row ">
                            <div class="col-4 text-center">
                                @if(session()->get('id'))
                                    <a href="{{route('post.create')}}" class="btn btn-primary">Publicar Oferta</a>
                                @else
                                    <a href="#" data-toggle="modal" data-target="#loginBusiness" class="btn btn-primary">Publicar Oferta</a>
                                @endif
                            </div>
                            <div class="col-4 text-center">
                                @if(session()->get('id'))
                                    <a href="{{route('profile')}}" class="btn btn-primary">Crea tu Currículum Gratis</a>
                                @else
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#loginUserModal">Crea tu Currículum Gratis</a>
                                @endif
                            </div>
                            <div class="col-4 text-center"><a href="{{ route('prices') }}" class="btn btn-primary">Ver Tarífas</a></div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4 mt-0">

                    <div class="col-md-12 mx-auto">
                        <div class="d-flex d-flex-title">
                            <h2 class="d-inline-flex">Últimas Ofertas al día de hoy</h2>
                            <div class="border-fill"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mx-auto">

                        @forelse($offers as $offer)
                            <div class="card mb-4{{ $offer->featured ? ' back-orange' : '' }}">
                                <div class="card-body row">
                                    <div class="col-12">
                                        <h3 class="card-title h5 py-0">
                                            <a href="{{ route("offer.show", $offer->slug) }}">{{ $offer->title }}@if($offer->handicapped)  &nbsp;<i class="fas fa-wheelchair"></i>  @endif</a>
                                        </h3>
                                    </div>
                                    <div class="col-12 col-sm-7 border-bottom mb-3 pb-3">
                                        @if ($offer->businessMeta)
                                            @if(!$offer->confidential)
                                                <div class="h6"><strong>{{$offer->businessMeta->business_name}}</strong>
                                                    - {{ $offer->publication }}</div>
                                            @else
                                                <div class="h6"><strong>Confidencial</strong> - {{ $offer->publication }}</div>
                                            @endif

                                        @endif
                                        @if ($offer->businessMeta)
                                            <div class="d-block d-sm-none">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="h6"><i class="fas fa-map-marker-alt"></i> &nbsp;<span
                                                                    class="text-capitalize">{{ $offer->businessMeta->comune }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <i class="far fa-building"></i> &nbsp;<span
                                                                class="text-capitalize">{{ $offer->position }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none d-sm-block">
                                                {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($offer->description)), 150)}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-5 d-block d-sm-block position-relative">
                                        @if ($offer->businessMeta)
                                            <div class="d-none d-sm-block">
                                                <div class="row">
                                                    <div class="col-6 col-sm-12">
                                                        <div class="h6"><i class="fas fa-map-marker-alt"></i> &nbsp;<span
                                                                    class="text-capitalize">{{ $offer->businessMeta->comune }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-12">
                                                        <i class="far fa-building"></i> &nbsp;<span
                                                                class="text-capitalize">{{ $offer->position }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="position-absolute badge-destacado d-block d-md-block">
                                            @if ($offer->featured)
                                                <span class="badge">Destacada</span>
                                            @endif
                                            @if (session()->get('id'))
                                                @isset($offer->candidates)
                                                    @php($textStatus = '')
                                                    @foreach($offer->candidates as $candidate)
                                                        @if (session()->get('id') == $candidate->id_user)
                                                            @php($textStatus = $candidate->status['text'])
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if ($textStatus == 'favorite')
                                                        <a class="post-add-fav d-block d-sm-inline-block" href="#" data-favorite="true" data-slug="{{$offer->slug}}">
                                                            <i class="fas fa-bookmark"></i>
                                                        </a>
                                                    @else
                                                        <a class="post-add-fav d-block d-sm-inline-block" href="#" data-favorite="false" data-slug="{{$offer->slug}}">
                                                            <i class="far fa-bookmark"></i>
                                                        </a>
                                                    @endif
                                                @endisset
                                            @endif
                                        </div>

                                    </div>
                                    <p class="card-text">
                                    <p class="p-0 m-0 d-block d-sm-none">
                                        {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($offer->description)), 150)}}
                                    </p>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p>No hay ofertas de trabajo publicadas!</p>

                        @endforelse
                        <!-- Agrega más ofertas de trabajo aquí -->

                        <div class="row-buttons row mt-2 mb-4">
                            <div class="col-12">
                                <a href="{{route('offer.list')}}" class="btn btn-primary btn-block">Ir a ver todas las ofertas</a>
                            </div>
                        </div>

                        <h2>Nuestras estadísticas</h2>

                        <div class="row estadisticas my-sm-5">
                            <div class="col-12 col-sm-4 text-center">
                                <img class="icon" src="/images/icon-visitas.png" alt="Visitas" width="51" height="51" loading="lazy" decoding="async">
                                <h3 class="h4">
                                    <span class="d-block mb-2">RECIBIMOS MÁS DE</span>
                                    <span class="cifra d-block mb-2">3.000.000</span>
                                    <span class="d-block">VISITAS AL AÑO</span>
                                </h3>
                            </div>
                            <div class="col-12 col-sm-4 text-center">
                                <img class="icon" src="/images/icon-ofertas.png" alt="Ofertas" width="51" height="51" loading="lazy" decoding="async">
                                <h3 class="h4">
                                    <span class="d-block mb-2">PUBLICAMOS</span>
                                    <span class="cifra d-block mb-2">MÁS DE 500</span>
                                    <span class="d-block">OFERTAS MENSUALMENTE</span>
                                </h3>
                            </div>
                            <div class="col-12 col-sm-4 text-center">
                                <img class="icon" src="/images/icon-postulante.png" alt="Postulantes" width="52" height="51" loading="lazy" decoding="async">
                                <h3 class="h4">
                                    <span class="d-block mb-2">REGISTRAMOS MÁS DE</span>
                                    <span class="cifra d-block mb-2">22.000</span>
                                    <span class="d-block">POSTULANTES</span>
                                </h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!is_null($offers[0]))
        <script>
            window.googletag = window.googletag || {cmd: []};
            googletag.cmd.push(function() {
                googletag.defineSlot('/18588809/EACIZ_N', [330, 100], 'div-gpt-ad-1633611877658-0').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
            jQuery(document).ready( function($) {
                // Boton de favoritos id post-add-fav, peticion via ajax para agregar o quitar favorito

                $('.post-add-fav').click(function(e) {
                    var $this = $(this);
                    var slug = $this.data('slug');
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route('offer.favorite') }}',
                        type: 'POST',
                        data: {
                            id_offer: slug,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                if (data.isFavorite == '4') {
                                    $this.data('favorite', 'true');
                                    $this.find('i').removeClass('far').addClass('fas');
                                } else if(data.isFavorite == '0' || data.fav == '1') {
                                    $this.data('favorite', 'false');
                                    $this.find('i').removeClass('fas').addClass('far');
                                }
                            }
                        }
                    });
                });
            })
        </script>
    @endif
@endsection

@push('meta')
    <link rel="canonical" href="{{ route('/') }}" />

    <meta property="og:image" content="{{ asset('images/1x/logo-empleos-aqua.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Empleos Aqua | Ofertas de trabajo" />

    {{-- Home: listado de ofertas (los JobPosting van solo en cada ficha) --}}
    {!! \App\Support\Schema::script(\App\Support\Schema::itemList($offers)) !!}

@endpush

@push('styles')
    <style>
        .skyscrapper.superior {
            z-index: 3000;
        }
        /* Los skyscrapers publicitarios no deben ensanchar la página (scroll horizontal) */
        html, body { overflow-x: clip; }
        .skyscrapper { width: 120px; max-width: 120px; padding: 0; }
        .skyscrapper > div, .skyscrapper iframe { max-width: 120px; overflow: hidden; }
        .post-add-fav i {
            font-size: 24px;
        }
    </style>
@endpush

@push('scripts')
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EAHA1_N', [940, 90], 'div-gpt-ad-1666795994590-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>
    
            <!-- Banner superior -->
            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHDS', [120, 600], 'div-gpt-ad-1620410987480-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>

            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHIS', [120, 600], 'div-gpt-ad-1620410792403-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>
            <!-- Fin Banner Superior -->

            <!-- Banner Inferior -->

            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHDI', [120, 600], 'div-gpt-ad-1620411032581-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>


            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHII', [120, 600], 'div-gpt-ad-1620410914897-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>
            <!-- Fin banner Inferior -->

    <script>
        jQuery(document).ready(function (a) {
            var faded = false;
            a(window).scroll(function fix_element() {
                let position = a(window).scrollTop();
                let container = a('.skyscrapper.superior').find('div').css({
                    'z-index': '3000'
                });
                let cuerpo = a('body');
                let halfBody = parseInt(cuerpo.height() / 2) + 400;

                if (position > 503) {
                    a('.skyscrapper').find('div').css({
                        'position': 'fixed',
                        'top': '120px'
                    });
                } else {
                    a('.skyscrapper').find('div').css({
                        'position': 'absolute',
                        'top': 'auto'
                    });
                }

                if (!faded) {
                    if (halfBody < position) {
                        container.fadeOut(150);
                        faded = true;
                    }
                }

                if (halfBody > position) {
                    if (faded) {
                        container.fadeIn(100);
                        faded = false;
                    }
                }

                console.log(halfBody, position);

            });
        });
    </script>
@endpush
