<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    @hasSection('robots')
        <meta name="robots" content="@yield('robots')">
    @else
        {{-- Schema global: Organization + WebSite (no en áreas privadas) --}}
        {!! \App\Support\Schema::script([
            '@graph' => [\App\Support\Schema::organization(), \App\Support\Schema::website()],
        ]) !!}
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/Favicon-EmpleosAqua2.png" type="image/x-icon" />


    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <meta name="description"
        content="Ofertas de trabajo. Publique sus ofertas laborales con nosotros. Busque el puesto de trabajo que necesita. Tenemos experiencia como Bolsa de Empleos Aqua" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
    <link rel="preconnect" href="https://securepubads.g.doubleclick.net" crossorigin>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/jquery.min.js') }}?v={{ @filemtime(public_path('js/jquery.min.js')) }}"></script>
    <script src="{{ asset('js/jquery.offcanvas.min.js') }}?v={{ @filemtime(public_path('js/jquery.offcanvas.min.js')) }}">
    </script>
    @stack('datatables')

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-S6F0ZG7XWY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-S6F0ZG7XWY');
    </script>
    <!-- debug --->

    {{-- Los slots de GPT (defineSlot/enableServices) deben definirse en el head, antes de los display() del body --}}
    @stack('scripts')
    @stack('styles')

    @if (config('app.intersticial'))
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                googletag.defineSlot('/18588809/INTER_EMPLEOSAQUA', [750, 550], 'div-gpt-ad-1774017932964-0')
                    .addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
        </script>

        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                googletag.defineSlot('/18588809/INTER_MOVIL_EA', [300, 480], 'div-gpt-ad-1623195704652-0').addService(
                    googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
        </script>
    @endif

    <!-- DataTables -->
    {{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css"> --}}

    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey': '6Lc5wGwcAAAAAMgqHGq8JHvZ-bZCLEnAFS1Ppxkf'
            });
        };
    </script>

    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <style>
        #intersticial,
        #intersticialMovil {
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 10000;
        }
    </style>
</head>

<body id="home-page" class="p-0 m-0 home">
    <div class="container-fluid m-0 p-0">
        <header>
            <div class="container mx-auto p-0">
                <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
                    <a class="navbar-brand" href="{{ route('/') }}">Nombre de la empresa</a>
                    <button class="navbar-toggler d-lg-none" type="button" data-toggle="offcanvas"
                        data-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="menu-icon"></span>
                    </button>

                    <div class="d-block offcanvas-collapse d-sm-block" id="navbarMobile">
                        <div class="row min-vh-100">
                            <div class="col-8 col-sm-12">
                                <a class="navbar-brand d-sm-none" href="#">Nombre de la empresa</a>

                                @if (session()->has('role'))
                                    @include('partials.navigation.' . session()->get('role'))
                                @else
                                    @include('partials.navigation.guest')
                                @endif
                            </div>
                            <div class="col-4 close-zone d-md-none vh-100 ">
                                <span class="close-icon">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.navbar-toggler').on('click', function() {
                        $('#navbarMobile').toggleClass('active');
                    });

                    $('.close-icon').on('click', function() {
                        $('#navbarMobile').removeClass('active');
                    });
                });
            </script>
        </header>
        @if (config('app.intersticial'))
            <div id="intersticial"
                class="container-fluid d-none d-md-flex container-intesrticial fixed-top w-100 h-100 position-fixed"
                style="z-index: 10000; background-color: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center;">
                <div class="row fixed-top text-center py-3" style="background-color: #fff;">
                    <div class="col">
                        <div class="h5">
                            <a href="#" id="close-ads">
                                Cerrar Aviso <i class="far fa-regular fa-times-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /18588809/INTER_EMPLEOSAQUA -->
                    <div id='div-gpt-ad-1774017932964-0' style='min-width: 750px; min-height: 550px;'>
                        <script>
                            googletag.cmd.push(function() {
                                googletag.display('div-gpt-ad-1774017932964-0');
                            });
                        </script>
                    </div>
                </div>
            </div>
        @endif
        @if (config('app.intersticial_mobile'))
            <div id="intersticialMovil"
                class="container-fluid d-block d-md-none container-intesrticial fixed-top w-100 h-100 position-fixed">
                <div class="row fixed-top text-center py-3" style="background-color: #fff;">
                    <div class="col">
                        <div class="h5">
                            <a href="#" id="close-ads-movil">
                                Cerrar Aviso <i class="far fa-regular fa-times-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- /18588809/INTER_MOVIL_EA -->
                        <div id='div-gpt-ad-1623195704652-0' style='min-width: 300px; min-height: 480px;'>
                            <script>
                                googletag.cmd.push(function() {
                                    googletag.display('div-gpt-ad-1623195704652-0');
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <main>
            @yield('content')
        </main>

        @include('partials.footer')

        @stack('footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                let seg = 12; // segundos que dura visible el intersticial
                let ahora = Math.floor(Date.now() / 1000); // Tiempo actual en segundos
                let ultimaVez = localStorage.getItem('intersticial_last_show');
                let unaHora = 3600; // 60 min * 60 seg

                // SOLO si no se ha mostrado antes O si ya pasó más de una hora
                if (!ultimaVez || (ahora - ultimaVez) > unaHora) {

                    // 1. Mostrar el anuncio y guardar el tiempo actual
                    $("#intersticial").css({
                        'z-index': 3000,
                        'opacity': 1,
                        'display': 'block' // Nos aseguramos de que empiece visible
                    });
                    localStorage.setItem('intersticial_last_show', ahora);

                    // 2. Timer para ocultarlo automáticamente
                    setTimeout(function() {
                        $("#intersticial").fadeTo("slow", 0, function() {
                            $(this).attr('style', 'display: none !important');
                        });
                    }, seg * 1000);

                } else {
                    // Si no ha pasado la hora, nos aseguramos de que esté oculto
                    $("#intersticial").attr('style', 'display: none !important');
                }

                // Evento de cierre manual (siempre activo por si acaso)
                $("#close-ads").click(function(e) {
                    e.preventDefault();
                    $("#intersticial").attr('style', 'display: none !important');
                });

                // Lógica del scroll (se mantiene igual)
                $(window).scroll(function() {
                    let posTop = $(this).scrollTop();
                    if (posTop > 60) {
                        $("#nav-bolsa").addClass('fixed-top');
                    } else {
                        $("#nav-bolsa").removeClass('fixed-top');
                    }
                });
            });
        </script>
        @stack('scripts')

    </div>
</body>

</html>
