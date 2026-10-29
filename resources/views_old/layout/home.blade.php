<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/Favicon-EmpleosAqua2.png" type="image/x-icon"/>


    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <meta name="description"
          content="Ofertas de trabajo. Publique sus ofertas laborales con nosotros. Busque el puesto de trabajo que necesita. Tenemos experiencia como Bolsa de Empleos Aqua"/>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-184220893-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-184220893-1');
    </script>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">


    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6Lc5wGwcAAAAAMgqHGq8JHvZ-bZCLEnAFS1Ppxkf'
        });
      };
    </script>
    
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

    @if(env('INTERSTICIAL'))
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/INTER_EMPLEOSAQUA', [750, 550], 'div-gpt-ad-1666875910612-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>
    @endif
    
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EAHA1_N', [940, 90], 'div-gpt-ad-1666795994590-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>
    


    @stack('scripts')

    @stack('styles')
</head>

<body class="home">
<div class="page-container" style="margin-top: 10px;">
     <div id="app" style="max-width: 100%;">
        @if(env('INTERSTICIAL'))

        <div id="intersticial" class="container-fluid container-intesrticial fixed-top w-100 h-100 position-fixed">
            <div class="row fixed-top text-center py-3" style="background-color: #fff;">
                <h5>
                    <a href="#" id="close-ads">
                        Cerrar Aviso <i class="fa-regular fa-circle-xmark"></i>
                    </a>
                </h6>
            </div>
            <div class="row">
                
                <!-- /18588809/INTER_EMPLEOSAQUA -->
                <div id='div-gpt-ad-1666875910612-0' style='padding-top: 8vh; width: 750px; min-height: 550px; margin: 0 auto;'>
                  <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1666875910612-0'); });
                  </script>
                </div>
                
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12 d-none d-md-block text-center">
                <!-- /18588809/EAHA1_N -->
                <div id='div-gpt-ad-1666795994590-0' style='min-width: 940px; min-height: 90px;'>
                    <script>
                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1666795994590-0'); });
                    </script>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav id="nav-bolsa" class="navbar navbar-expand-md navbar-light" style="/*height: 200px*/">
        
                    <div class="container-fluid d-block">
                        <div class="container">
                            <div class="row">
                                <div class="col col-md-2">
                                    <a class="navbar-brand w-100 h-auto d-block" href="{{url('/')}}">
                                        {{config('app.name', 'Bolsa de empleo')}}
                                    </a>
                                </div>
                                <div class="col col-md-10">
        
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#navbarSupportedContent"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="{{ __('Toggle navigation') }}">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                    
                                    <div id="navbarSupportedContent" class="collapse navbar-collapse">
                                        @if(session()->has('role'))
                                            @include('partials.navigation.' . session()->get('role'))
                                        @else
                                            @include('partials.navigation.guest')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <main id="home-main" class="pb-5">
            @yield('content')
        </main>
    </div>

    <footer class="container-fluid">
        <div class="container container-app">
            <div class="row justify-content-center">
                <div class="col-md-2 col-2 pl-1">
                    <img src="/../images/footer-b2b.png" class="d-inline-block pr-3 border-right">
                </div>
                <div class="col-md-8 col-8">
                    <div class="d-none d-md-inline-block align-middle pl-3">
                        <p class="text-white small m-0">© 2013 B2Bmg ® Todos los derechos
                            reservados</p>
                        <p class="text-white small m-0">Benavente 550 oficina 305, Edificio Campanario, Puerto Montt, Chile. Tel: (56) 65 2470107</p>
                        <p class="text-white small m-0">Magnere 1540 oficina 801, Providencia, Santiago de Chile. Tel: (56-2) 27574200</p>
                        <p class="text-white small m-0">email: <a class="text-white" href="mailto:empleosaqua@b2bmg.cl">empleosaqua@b2bmg.cl</a></p>
                    </div>
                </div>
                <div class="col-md-2 col-2">
                    <div class="row h-100">
                        <div class="col-6 text-center align-middle h-100">
                            <a href="https://www.facebook.com/Empleosaqua/" target="_blank">
                                <i class="fab fa-facebook fa-4x text-white"></i>
                            </a>
                        </div>
                        <div class="col-6 text-center align-middle h-100">
                            <a href="https://www.linkedin.com/company/empleosaqua/" target="_blank">
                                <i class="fab fa-linkedin fa-4x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
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
            
        })
    </script>
    
    <style>
        #intersticial {
            background-color: rgba(0,0,0,0.8);
        }
        #div-gpt-ad-1666875910612-0 > div {
            margin: 0 auto;
        }
    </style>
    
</div>
</body>
