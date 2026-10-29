<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
        @media (min-width: 960px) {
            .container-app {
                width: 1300px;
                max-width: 1300px !important;
            }
        }
    </style>
    
    <style>
        h3, table {
            font-family: 'Roboto', Arial, Sans-serif;
        }
    
        .badge-primary {
            background: #d88f32;
        }
    </style>

</head>
<body class="app">
    <div class="page-container" style="margin-top: 10px;">
        <div id="app" style="max-width: 780px; margin: 0 auto;">
            <div class="row justify-content-center py-2" style="background: #fff; box-shadow: 0px 6px 9px 0px #e3e3e3;">
                <div class="col-md-4 text-center">
                    <a class="navbar-brand pb-3 mb-3" href="{{url('/')}}" style="border-bottom: 1px solid #e9e9e9;">
                        <img class="w-100 pb-3" src="{{url('/images/1x/logo-empleos-aqua.png')}}" alt="Logo" style="max-width: 100%; height: auto;">
                    </a>
                    <p class="small m-0">{{ date('F j, Y') }}</p>
                </div>
            </div>
            <main class="py-3 mt-3" style="background: transparent;">
                @yield('content')
            </main>
        </div>
        <div class="container" style="max-width: 780px;margin: 0 auto;background: #323d7e;padding: 10px 25px;">
            <div class="row justify-content-center">
                <div class="col-md-2 col-2">
                    <img src="/../images/footer-b2b.png" class="w-100 d-inline-block pr-3 border-right">
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
    @stack('footer')
    
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

</div>
</body>
