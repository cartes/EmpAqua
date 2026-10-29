<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/Favicon-EmpleosAqua2.png" type="image/x-icon" />

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-184220893-1"></script>

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

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-184220893-1');
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('scripts')

    @stack('styles')

    <style>
        @media (min-width: 960px) {
            .container-app {
                width: 1300px;
                max-width: 1300px !important;
            }
        }
    </style>
</head>

<body class="app">
    <div class="news-container">
        <div id="app" style="max-width: 800px; margin: 0 auto; border-bottom: 3px solid #f1f1f1">
            <nav id="nav-bolsa" class="navbar navbar-expand-md navbar-light">
                <div class="container container-app" style="border-bottom: 3px solid #f1f1f1">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Bolsa de empleo') }}
                    </a>
                </div>
            </nav>

            <main class="py-3">
                @yield('content')
            </main>
        </div>
        @stack('footer')
    </div>
</body>
