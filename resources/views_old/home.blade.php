@extends('layout.home')

@section('content')

    <div class="container">
        @if(null!==session('message'))
            <div class="row justify-content-center">
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

    <div id="popup" class="modal hide fade">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 783px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- /18588809/INTER_EMPLEOSAQUA -->
                    <div id='div-gpt-ad-1623195634540-0' style='min-width: 750px; min-height: 550px;'>
                        <script>
                            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1623195634540-0'); });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal popup de empleos -->
    <script>
        jQuery(document).ready(function (a) {
            a("#popup").modal('hide');
        })
    </script>

    <div class="container-fluid">
        <div class="row justify-content-center mb-4">

            <div id="search-container" class="col-md-8">
                <div class="row row-form position-relative overflow-hidden" style="min-height: 550px;">
                    <div class="col-md-12 position-absolute m-0 p-0" style="bottom: -40%; left: 0">
                        <video width="1700" height="1050" autoplay muted loop controls style="pointer-events: none;">
                            <source src="/images/video-aqua.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="col-md-6 form-search position-absolute">
                        <div class="row ">
                            <div class="col-12">
                                <form method="post" action="{{ route('search') }}">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="query"
                                                   placeholder="Busca tu nuevo trabajo"/>
                                            <span class="input-group-btn input-group-append">
                                            <button class="btn" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row d-block d-sm-none">
                            <div class="col-12 text-center">
                                <a class="btn btn-access-border ml-4" href="#" data-toggle="modal" data-target="#loginUserModal">
                                    Acceso Postulante
                                </a>
                            </div>
                            <div class="col-6"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <a href="{{ route('offer.list') }}" class="btn btn-control d-inline-block">Todas las
                                    Ofertas</a>
                                <a href="{{ route('offer.featured') }}" class="btn btn-control d-inline-block">Ofertas destacadas</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                @if (session()->get('id'))
                                    <a href="{{ route('profile') }}" class="w-100 btn btn-control" type="submit">Crea tu
                                        currículum</a>
                                @else
                                    <button type="button" class="w-100 btn btn-control" data-toggle="modal"
                                            data-target="#loginUserModal">Crea
                                        tu currículum
                                    </button>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if (session()->get('role') == 'business')
                                    <a href="{{ route('post.create') }}" class="w-100 btn-control btn">
                                        Publica una oferta
                                    </a>
                                @else
                                    <a href="{{ route('prices') }}" class="w-100 btn btn-control">
                                        Publica una oferta
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container d-none d-md-block">
                    <div class="row">
                        <div class="col-12">
                            <img class="w-100 h-auto mx-auto" src="{{ asset("/images/data_empleos_aqua.png") }}" alt="Data Empleos Aqua" />
                        </div>
                    </div>
                    <div class="row p-md-5 row-eq-height">
                        <div class="col-md-4">
                            <div class="text-center py-2 mb-4">
                                <img src="{{ asset("/images/1x/home-profile.png") }}" alt="Quienes Somos"/>
                            </div>
                            <h2 class="text-center">TU PERFIL GRATIS</h2>
                            <div class="text-justify">
                                Somos el portal de empleos líder de la industria acuícola que opera en las regiones del
                                sur
                                de Chile. Somos especialistas en publicaciones de ofertas laborales vinculadas al
                                sector,
                                con más de diez años en el mercado. Al día de hoy, más de 3.500 empresas utilizan
                                nuestra
                                plataforma, publicando más de 800 avisos al mes. ¡Regístrate y póstula!
                            </div>
                            <div class="row align-bottom mt-5 d-md-none">
                                <div class="col-12 text-center">
                                    @if (session()->get('role') == 'user')
                                        <a href="{{ route("profile") }}" class="w-75 btn btn-control">Crea tu
                                            currículum</a>
                                    @elseif (!session()->get('id'))
                                        <button data-toggle="modal" data-target="#loginUserModal"
                                                class="w-75 btn btn-control">
                                            Crea tu currículum
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center py-2 mb-4">
                                <img src="{{ asset("/images/1x/home-us.png") }}" alt="Quienes Somos"/>
                            </div>
                            <h2 class="text-center">POR QUÉ NOSOTROS?</h2>
                            <div class="text-justify">
                                Somos parte del B2B Group Media SPA, así que muchos ya nos conocen. Llevamos más de
                                diez
                                años prestando, a través de nuestra bolsa de trabajo, un importante servicio a la
                                comunidad.
                                Ahora, queremos avanzar hacia un portal de empleos más completo y con nuevos servicios
                                para
                                los avisadores, quienes podrán tener procesos de selección mucho más rápidos y
                                eficientes.
                                Si antes era bueno, ¡ahora es mejor!
                            </div>
                            <div class="row align-bottom mt-5 d-md-none">
                                <div class="col-12 text-center">
                                    @if (session()->get('role') == 'business')
                                        <button data-toggle="modal" data-target="#loginBusiness"
                                                class="w-75 btn btn-control">
                                            Publica una oferta
                                        </button>
                                    @elseif (!session()->get('id'))
                                        <a class="w-75 btn btn-control" href="{{ route("post.create") }}">
                                            Publica una oferta
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center py-2 mb-4">
                                <img src="{{ asset("/images/1x/home-who.png") }}" alt="Quienes Somos"/>
                            </div>
                            <h2 class="text-center">QUIENES SOMOS</h2>
                            <div class="text-justify">
                                www.empleosaqua.cl es una iniciativa del B2B Group Media SPA, casa editorial de
                                revista
                                AQUA y el portal www.aqua.cl. Nos hemos
                                propuesto convertirnos en la plataforma de empleo líder en el sector acuícola y pesquero
                                nacional, ofreciendo un eficiente punto de encuentro entre empleadores y potenciales
                                trabajadores de este dinámico sector.
                            </div>
                            <div class="row align-bottom mt-5 d-md-none">
                                <div class="col-12 text-center">
                                    <a class="w-75 btn btn-control" href="{{ route("prices") }}">
                                        Nuestras tarifas
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row px-md-5 mb-4 d-none d-md-flex">
                        <div class="col-4 text-center">
                            @if (session()->get('role') == 'user')
                                <a href="{{ route("profile") }}" class="w-75 btn btn-control">Crea tu
                                    currículum</a>
                            @elseif (!session()->get('id'))
                                <button data-toggle="modal" data-target="#loginUserModal"
                                        class="w-75 btn btn-control">
                                    Crea tu currículum
                                </button>
                            @endif
                        </div>
                        <div class="col-4 text-center">
                            @if (session()->get('role') == 'business')
                                <a class="w-75 btn btn-control" href="{{ route("post.create") }}">
                                    Publica una oferta
                                </a>
                            @elseif (!session()->get('id'))
                                <button data-toggle="modal" data-target="#loginBusiness"
                                        class="w-75 btn btn-control">
                                    Publica una oferta
                                </button>
                            @endif
                        </div>
                        <div class="col-4 text-center">
                            <a class="w-75 btn btn-control" href="{{ route("prices") }}">
                                Nuestras tarifas
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Columna ofertas de trabajo --}}
            <div class="col-md-4">
                @forelse($offers as $offer)
                    <div class="row job-container px-2 py-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    @if ($offer->businessMeta)
                                        @if(!$offer->confidential)
                                        <img class="w-100 h-auto" src="{{ $offer->businessMeta->pathAttachment() }}"
                                             alt="{{ $offer->businessMeta->business_name }}"
                                        />
                                        @else
                                        <img class="w-100 h-auto" src="https://www.empleosaqua.cl/images/1x/logo-empleos-aqua.png"
                                             width="170" alt="{{ $offer->businessMeta->business_name }}"
                                        />
                                        @endif
                                        <small class="mt-1 d-block text-white">{{ $offer->publication }}</small>
                                    @endif
                                </div>
                                <div class="col-6 col-md-8">
                                    <h2>
                                        <a class="text-white text-capitalize"
                                           href="{{ route("offer.show", $offer->slug) }}">
                                            {{ $offer->title }}@if($offer->experience != '')
                                                | @endif{{ $offer->experience }} @if($offer->handicapped)<i
                                                class="fas fa-wheelchair"></i>@endif
                                        </a>
                                    </h2>
                                    @if ($offer->businessMeta)

                                        <h3 class="text-white mb-0"></h3>
                                        <h4 class="text-white mb-0">{{ $offer->position }}</h4>
                                        <h4 class="text-white p-0">{{ $offer->businessMeta->comune }}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay ofertas de trabajo publicadas!</p>
                @endforelse
                <div class="d-block d-sm-none row text-center py-3">
                    <div class="col-12">
                        <a href="{{ route('offer.list') }}" class="btn btn-control d-inline-block">Todas las
                            Ofertas</a>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@push('scripts')
<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

<script>
  window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/18588809/EAHA1_N', [940, 90], 'div-gpt-ad-1666795994590-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>
@endpush

@push('top-ads')
<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<!-- INTERSTICIAL -->
<script>
  window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/18588809/INTER_EMPLEOSAQUA', [750, 550], 'div-gpt-ad-1666875910612-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>

<!-- /18588809/EAHA1_N -->
    <div id='div-gpt-ad-1666795994590-0' style='min-width: 940px; min-height: 90px;'>
      <script>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1666795994590-0'); });
      </script>
    </div>
@endpush
