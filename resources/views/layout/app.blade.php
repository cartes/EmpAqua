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
        {!! \App\Support\Schema::script(['@graph' => [\App\Support\Schema::organization(), \App\Support\Schema::website()]]) !!}
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/Favicon-EmpleosAqua2.png" type="image/x-icon" />

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <meta name="description" content="@yield('description', 'Ofertas de trabajo. Publique sus ofertas laborales con nosotros. Busque el puesto de trabajo que necesita. Tenemos experiencia como Bolsa de Empleos Aqua')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
    <link rel="preconnect" href="https://securepubads.g.doubleclick.net" crossorigin>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
    <script src="{{ asset('js/jquery.offcanvas.min.js') }}"></script>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS después -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FK34TS8HZR"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-FK34TS8HZR');
    </script>
    <style>
        #container-offer-display p {
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            /* permite wrapping pero respeta saltos */
        }
    </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

    @if (app()->environment('production'))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8544975266159001"
            crossorigin="anonymous"></script>
    @endif
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey': '6Lc5wGwcAAAAAMgqHGq8JHvZ-bZCLEnAFS1Ppxkf'
            });
        };
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    @stack('styles')

    <style>
        @media (min-width: 960px) {
            .container-app {
                width: 1300px;
                max-width: 1300px !important;
            }
        }
    </style>

    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

    @if (config('interticial'))
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                googletag.defineSlot('/18588809/INTER_EMPLEOSAQUA', [750, 550], 'div-gpt-ad-1666875910612-0')
                    .addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
        </script>
    @endif

    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EAHA1_N', [940, 90], 'div-gpt-ad-1666795994590-0').addService(googletag
                .pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>

</head>

<body id="app-page" class="p-0 m-0 home">
    <!-- app layout -->
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

        <main>
            @yield('content')
        </main>

        @include('partials.footer')

        @stack('footer')
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                let seg = 12; // segundos intersticial
                $("#intersticial").css({
                    'z-index': 3000,
                    'opacity': 1
                });
                setTimeout(function() {
                    $("#intersticial").fadeTo("slow", 0, function() {
                        $(this).hide();
                    });
                }, seg * 1000)

                $("#close-ads").click(function(e) {
                    e.preventDefault();
                    $("#intersticial").hide();
                })

                $(window).scroll(function() {
                    let posTop = $(this).scrollTop();
                    if (posTop > 60) {
                        $("#nav-bolsa").addClass('fixed-top');
                    } else {
                        $("#nav-bolsa").removeClass('fixed-top');
                    }
                })

            });
        </script>
        @stack('scripts')

    </div>
</body>
